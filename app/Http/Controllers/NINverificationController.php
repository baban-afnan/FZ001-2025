<?php

namespace App\Http\Controllers;

use App\Helpers\noncestrHelper;
use App\Helpers\signatureHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\Ninverification;
use App\Models\Transaction;
use App\Models\Service;
use App\Models\Wallet;
use App\Repositories\NIN_PDF_Repository;
use Carbon\Carbon;

class NINverificationController extends Controller
{
    /**
     * Show NIN verification history
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = Ninverification::with(['modificationField', 'transaction'])
            ->where('user_id', $user->id);

        if ($request->filled('search')) {
            $query->where('number_nin', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $crmSubmissions = $query->orderByDesc('submission_date')
            ->paginate(10)
            ->withQueryString();

        return view('verification.nin-verification', [
            'crmSubmissions' => $crmSubmissions,
        ]);
    }

    /**
     * Store new NIN verification request
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'number_nin' => 'required|string|size:11|regex:/^[0-9]{11}$/',
        ]);

        // 1. Get Verification Service
        $service = Service::where('name', 'Verification')
            ->where('is_active', true)
            ->first();

        if (!$service) {
            return back()->with([
                'status' => 'error',
                'message' => 'Verification service not available.'
            ]);
        }

        // 2. Get default Modification Field
        $modificationField = $service->modificationFields()->where('is_active', true)->first();

        if (!$modificationField) {
            return back()->with([
                'status' => 'error',
                'message' => 'No modification field found for Verification service.'
            ]);
        }

        // 3. Determine service price
        $servicePrice = $modificationField->getPriceForUserType($user->role);

        if ($servicePrice === null) {
            return back()->with([
                'status' => 'error',
                'message' => 'Service price not configured for your user type.'
            ]);
        }

        // 4. Check wallet
        $wallet = Wallet::where('user_id', $user->id)->firstOrFail();

        if ($wallet->status !== 'active') {
            return back()->with([
                'status' => 'error',
                'message' => 'Your wallet is not active.'
            ]);
        }

        if ($wallet->wallet_balance < $servicePrice) {
            return back()->with([
                'status' => 'error',
                'message' => 'Insufficient wallet balance. You need NGN ' . number_format($servicePrice - $wallet->wallet_balance, 2)
            ]);
        }

        try {

            $requestTime = (int) (microtime(true) * 1000);

            $noncestr = noncestrHelper::generateNonceStr();

            $data = [

                'version' => env('API_VERSION'),
                'nonceStr' => $noncestr,
                'requestTime' => $requestTime,
                'nin' => $request->number_nin,
            ];

            $signature = signatureHelper::generate_signature($data, config('keys.private2'));

            $url = env('Domain') . '/api/validator-service/open/nin/inquire';
            $token = env('BEARER');

            $headers = [
                'Accept: application/json, text/plain, */*',
                'CountryCode: NG',
                "Signature: $signature",
                'Content-Type: application/json',
                "Authorization: Bearer $token",
            ];

            // Initialize cURL
            $ch = curl_init();

            // Set cURL options
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

            // Execute request
            $response = curl_exec($ch);

            // Check for cURL errors
            if (curl_errno($ch)) {
                throw new \Exception('cURL Error: ' . curl_error($ch));
            }

            // Close cURL session
            curl_close($ch);

            $data = json_decode($response, true);


            if ($data['respCode'] == 00000000) {

                return  $this->processChargeAndReturn(
                    $wallet,
                    $servicePrice,
                    $user,
                    $modificationField,
                    $service,
                    $data,
                );
            } else if ($data['respCode'] == 99120010) {
            } else {
            }
        } catch (\Exception $e) {
        }
    }

    /**
     * Process wallet charge, transaction creation and response
     */
    private function processChargeAndReturn($wallet, $servicePrice, $user, $modificationField, $service, $ninData)
    {
        DB::beginTransaction();

        try {

            $transactionRef = 'Ver-' . (time() % 1000000000) . '-' . mt_rand(100, 999);

            $transaction = Transaction::create([
                'transaction_ref' => $transactionRef,
                'user_id' => $user->id,
                'amount' => $servicePrice,
                'description' => "NIN Search for {$modificationField->field_name}",
                'type' => 'debit',
                'status' => 'completed',
                'metadata' => [
                    'service' => 'nin',
                    'modification_field' => $modificationField->field_name,
                    'field_code' => $modificationField->field_code,
                    'nin' => $ninData['data']['nin'],
                    'user_role' => $user->role,
                    'price_details' => [
                        'base_price' => $modificationField->base_price,
                        'user_price' => $servicePrice,
                    ],
                    'source' => 'API'
                ],
            ]);

            // Deduct wallet balance
            $wallet->decrement('wallet_balance', $servicePrice);

            Ninverification::create([
                'user_id' => $user->id,
                'modification_field_id' => $modificationField->id,
                'service_id' => $service->id,
                'transaction_id' => $transaction->id,
                'reference' => $transactionRef,
                'number_nin' => $ninData['data']['nin'],
                'firstname' => $ninData['data']['firstName'],
                'middlename' => $ninData['data']['middleName'],
                'surname' => $ninData['data']['surname'],
                'birthdate' =>  $ninData['data']['birthDate'],
                'gender' => $ninData['data']['gender'],
                'telephoneno' => $ninData['data']['telephoneNo'],
                'photo_path' => $ninData['data']['photo'],
                'submission_date' => Carbon::now()
            ]);

            DB::commit();

            // Flash normalized verification data for Blade
            session()->flash('verification', $ninData);

            return redirect()->route('nin.verification.index')->with([
                'status' => 'success',
                'message' => "NIN search successful. Reference: {$transactionRef}. Charged: NGN " . number_format($servicePrice, 2),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);

            return back()->with([
                'status' => 'error',
                'message' => 'Transaction failed: ' . $e->getMessage()
            ]);
        }
    }

    //Downlaod slip
    public function standardSlip($nin_no)
    {
        //Generate PDF
        $repObj = new NIN_PDF_Repository();
        $response = $repObj->standardPDF($nin_no);
        return  $response;
    }

    public function premiumSlip($nin_no)
    {
        //Generate PDF
        $repObj = new NIN_PDF_Repository();
        $response = $repObj->premiumPDF($nin_no);
        return  $response;
    }
}

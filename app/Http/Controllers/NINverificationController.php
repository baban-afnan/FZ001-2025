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

        // 5. Check local DB first
        $existingVerification = Ninverification::where('number_nin', $validated['number_nin'])->first();

        if ($existingVerification) {
            // ✅ Found in DB → normalize + charge wallet
            $normalized = $this->normalizeData($existingVerification);

            return $this->processChargeAndReturn(
                $wallet,
                $servicePrice,
                $user,
                $modificationField,
                $service,
                $validated['number_nin'],
                $normalized,
                'Found in DB'
            );
        }
          try {

                $requestTime = (int) (microtime(true) * 1000);

            $noncestr = noncestrHelper::generateNonceStr();

            $data = [

                'version' => env('VERSION'),
                'nonceStr' => $noncestr,
                'requestTime' => $requestTime,
                'nin' => $request->nin,
            ];

            $signature = signatureHelper::generate_signature($data, config('keys.private2'));

            $url = env('Domain') . '/api/validator-service/open/nin/inquire';
            $token = env('BEARER');

                $headers = [
                    'Accept: application/json, text/plain, */*',
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
                    throw new \Exception('cURL Error: '.curl_error($ch));
                }

                // Close cURL session
                curl_close($ch);

                $response = json_decode($response, true);

                if (isset($response['respCode']) && $response['respCode'] == '000') {

                    $data = $response['data'];

                    $this->processResponseDataForNIN($data);

                    $balance = $wallet->balance - $ServiceFee;

                    Wallet::where('user_id', $loginUserId)
                        ->update(['balance' => $balance]);

                    $serviceDesc = 'Wallet debitted with a service fee of ₦'.number_format($ServiceFee, 2);

                    $this->transactionService->createTransaction($loginUserId, $ServiceFee, 'NIN Verification', $serviceDesc, 'Wallet', 'Approved');

                    return json_encode(['status' => 'success', 'data' => $data]);
                } elseif (in_array($response['respCode'], ['100', '101', '102', '103'])) {

                    return response()->json([
                        'status' => 'Not Found',
                        'errors' => ['No record found'],
                    ], 422);
                } else {
                    return response()->json([
                        'status' => 'Verification Failed',
                        'errors' => ['Verification Failed: No need to worry, your wallet remains secure and intact. Please try again or contact support for assistance.'],
                    ], 422);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'Request failed',
                    'errors' => ['An error occurred while making the API request'],
                ], 422);
            }

        // // 6. Call external API if not in DB
        // try {
        //     $apiResponse = Http::timeout(30)->withHeaders([
        //         'accept' => 'application/json',
        //         'content-type' => 'application/json',
        //         'x-api-key' => env('PREMBLY_API_KEY'),
        //         'app-id' => env('PREMBLY_APP_ID'),
        //     ])->post('https://api.prembly.com/identitypass/verification/vnin', [
        //         'number_nin' => $validated['number_nin']
        //     ]);
        // } catch (\Exception $e) {
        //     return back()->with([
        //         'status' => 'error',
        //         'message' => 'API connection failed: ' . $e->getMessage()
        //     ]);
        // }

        $responseData = $apiResponse->json();

        // ❌ If API also has no record → No charge, return error
        if ($apiResponse->status() !== 200 || ($responseData['status'] ?? false) !== true) {
            return back()->with([
                'status' => 'error',
                'message' => 'NIN NO RECORD FOUND, no charges apply.'
            ]);
        }

        $ninData = $responseData['nin_data'] ?? [];

        // Ensure status always exists
        $ninData['status'] = 'verified';

        // ✅ Only for API response → inject number_nin
        $ninData['number_nin'] = $validated['number_nin'];

        // ✅ Found in API → Save + Charge
        return $this->processChargeAndReturn(
            $wallet,
            $servicePrice,
            $user,
            $modificationField,
            $service,
            $validated['number_nin'],
            (object)$ninData,
            'Found in API'
        );
    }

    /**
     * Process wallet charge, transaction creation and response
     */
    private function processChargeAndReturn($wallet, $servicePrice, $user, $modificationField, $service, $ninNumber, $ninData, $source)
    {
        DB::beginTransaction();

        try {
            $transactionRef = 'Ver-' . (time() % 1000000000) . '-' . mt_rand(100, 999);

            $transaction = Transaction::create([
                'transaction_ref' => $transactionRef,
                'user_id' => $user->id,
                'amount' => $servicePrice,
                'description' => "NIN Search for {$modificationField->field_name} ({$source})",
                'type' => 'debit',
                'status' => 'completed',
                'metadata' => [
                    'service' => 'nin',
                    'modification_field' => $modificationField->field_name,
                    'field_code' => $modificationField->field_code,
                    'nin' => $ninNumber,
                    'user_role' => $user->role,
                    'price_details' => [
                        'base_price' => $modificationField->base_price,
                        'user_price' => $servicePrice,
                    ],
                    'source' => $source
                ],
            ]);

            // Save verification only if it came from API
            if ($source === 'Found in API') {
                Ninverification::create([
                    'reference' => $transactionRef,
                    'user_id' => $user->id,
                    'modification_field_id' => $modificationField->id,
                    'service_id' => $service->id,
                    'firstname' => $ninData->firstname ?? null,
                    'middlename' => $ninData->middlename ?? null,
                    'surname' => $ninData->surname ?? null,
                    'gender' => $ninData->gender ?? null,
                    'birthdate' => $ninData->birthdate ?? null,
                    'birthstate' => $ninData->birthstate ?? null,
                    'birthlga' => $ninData->birthlga ?? null,
                    'birthcountry' => $ninData->birthcountry ?? null,
                    'maritalstatus' => $ninData->maritalstatus ?? null,
                    'email' => $ninData->email ?? null,
                    'telephoneno' => $ninData->telephoneno ?? null,
                    'residence_address' => $ninData->residence_address ?? null,
                    'residence_state' => $ninData->residence_state ?? null,
                    'residence_lga' => $ninData->residence_lga ?? null,
                    'residence_town' => $ninData->residence_town ?? null,
                    'religion' => $ninData->religion ?? null,
                    'employmentstatus' => $ninData->employmentstatus ?? null,
                    'educationallevel' => $ninData->educationallevel ?? null,
                    'profession' => $ninData->profession ?? null,
                    'heigth' => $ninData->heigth ?? null,
                    'title' => $ninData->title ?? null,
                    'number_nin' => $ninNumber,
                    'vnin' => $ninData->vnin ?? null,
                    'photo_path' => $ninData->photo ?? null,
                    'signature_path' => $ninData->signature ?? null,
                    'trackingId' => $ninData->trackingId ?? null,
                    'userid' => $ninData->userid ?? null,
                    'transaction_id' => $transaction->id,
                    'submission_date' => now(),
                    'status' => 'verified',
                ]);
            }

            // Deduct wallet balance
            $wallet->decrement('wallet_balance', $servicePrice);

            DB::commit();

            // Flash normalized verification data for Blade
            session()->flash('verification', $ninData);

            return redirect()->route('nin.verification.index')->with([
                'status' => 'success',
                'message' => "NIN search successful ({$source}). Reference: {$transactionRef}. Charged: NGN " . number_format($servicePrice, 2),
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

    /**
     * Normalize verification data for Blade (ensures number_nin always exists)
     */
    private function normalizeData($verification)
    {
        return (object)[
            'id'         => $verification->id,
            'number_nin' => $verification->number_nin ?? null,
            'firstname'  => $verification->firstname,
            'surname'    => $verification->surname,
            'birthdate'  => $verification->birthdate,
            'gender'     => $verification->gender,
            'telephoneno'=> $verification->telephoneno,
            'email'      => $verification->email,
            'status'     => $verification->status ?? 'verified',
        ];
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\ModificationField;
use App\Models\CRMSubmission;
use App\Models\SendVnin;
use App\Models\Transaction;
use App\Models\Service;
use App\Models\Wallet;

class BvnServicesController extends Controller
{
    /**
     * Show submissions (CRM or SENDVNIN) depending on the route.
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        // Detect service from route name
        $routeName  = $request->route()->getName();      
        $isSendVnin = ($routeName === 'send-vnin');
        $serviceKey = $isSendVnin ? 'VNIN TO NIBSS' : 'CRM';

        // Pick model + search field
        $model       = $isSendVnin ? SendVnin::class : CRMSubmission::class;
        $searchField = $isSendVnin ? 'request_id' : 'ticket_id';

        $query = $model::with(['modificationField', 'transaction'])
            ->where('user_id', $user->id);

        if ($request->filled('search')) {
            $query->where($searchField, 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Status order: pending → processing → query → others
        $query->orderByRaw("
            CASE
                WHEN status = 'pending' THEN 1
                WHEN status = 'processing' THEN 2
                WHEN status = 'query' THEN 3
                ELSE 99
            END
        ")->orderByDesc('submission_date');

        $submissions = $query->paginate(5)->withQueryString();

        // Load service & active fields
        $bvnService = Service::where('name', $serviceKey)->where('is_active', true)->first();

        $modificationFields = $bvnService
            ? $bvnService->modificationFields()->where('is_active', true)->get()
            : collect();

        // Choose view
        $view = $isSendVnin ? 'bvn.send-vnin' : 'bvn.crm';

        // Return both keys to avoid Blade breakages
        return view($view, [
            'modificationFields' => $modificationFields,
            'services'           => Service::where('is_active', true)->get(),
            'serviceName'        => $serviceKey,
            'submissions'        => $submissions,     // new generic
            'crmSubmissions'     => $submissions,     // backwards compatible
        ]);
    }

    /**
     * Store submission for CRM or SENDVNIN depending on the route.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $routeName  = $request->route()->getName();       
        $isSendVnin = ($routeName === 'send-vnin.store');
        $serviceKey = $isSendVnin ? 'SENDVNIN' : 'CRM';

        // Validation
        if ($isSendVnin) {
            $validated = $request->validate([
                'modification_field_id' => 'required|exists:modification_fields,id',
                'request_id'            => 'required|string|size:7|regex:/^[0-9]{7}$/',
                'bvn'                   => 'required|string|size:11|regex:/^[0-9]{11}$/',
                'nin'                   => 'required|string|size:11|regex:/^[0-9]{11}$/',
                'field'                 => 'required',
            ]);
        } else {
            $validated = $request->validate([
                'modification_field_id' => 'required|exists:modification_fields,id',
                'batch_id'              => 'required|string|size:7|regex:/^[0-9]{7}$/',
                'ticket_id'             => 'required|string|size:8|regex:/^[0-9]{8}$/',
            ]);
        }

        $modField = ModificationField::with('service')
            ->findOrFail($validated['modification_field_id']);

        $servicePrice = $modField->getPriceForUserType($user->role);
        if ($servicePrice === null) {
            return back()->with([
                'status'  => 'error',
                'message' => 'Service price not configured for your user type.'
            ])->withInput();
        }

        $wallet = Wallet::where('user_id', $user->id)->firstOrFail();
        if ($wallet->status !== 'active') {
            return back()->with(['status' => 'error', 'message' => 'Your wallet is not active.'])->withInput();
        }
        if ($wallet->wallet_balance < $servicePrice) {
            return back()->with([
                'status'  => 'error',
                'message' => 'Insufficient wallet balance. You need NGN ' .
                    number_format($servicePrice - $wallet->wallet_balance, 2) . ' more.'
            ])->withInput();
        }

        DB::beginTransaction();
        try {
            $reference = $serviceKey . '-' . time() . '-' . mt_rand(100, 999);

            // Log transaction
            $transaction = Transaction::create([
                'transaction_ref' => $reference,
                'user_id'         => $user->id,
                'amount'          => $servicePrice,
                'description'     => "BVN {$serviceKey} Request for {$modField->field_name}",
                'type'            => 'debit',
                'status'          => 'completed',
                'metadata'        => $validated,
            ]);

            // Create submission
            if ($isSendVnin) {
                SendVnin::create([
                    'reference'              => $reference,
                    'user_id'                => $user->id,
                    'modification_field_id'  => $modField->id,
                    'service_id'             => $modField->service_id,
                    'request_id'             => $validated['request_id'],
                    'bvn'                    => $validated['bvn'],
                    'nin'                    => $validated['nin'],
                    'field'                  => $validated['field'],
                    'transaction_id'         => $transaction->id,
                    'submission_date'        => now(),
                    'status'                 => 'pending',
                ]);
            } else {
                CRMSubmission::create([
                    'reference'              => $reference,
                    'user_id'                => $user->id,
                    'modification_field_id'  => $modField->id,
                    'service_id'             => $modField->service_id,
                    'ticket_id'              => $validated['ticket_id'],
                    'batch_id'               => $validated['batch_id'],
                    'transaction_id'         => $transaction->id,
                    'submission_date'        => now(),
                    'status'                 => 'pending',
                ]);
            }

            // Debit wallet
            $wallet->decrement('wallet_balance', $servicePrice);

            DB::commit();

            // Redirect back to proper listing page
            $redirectRoute = $isSendVnin ? 'send-vnin' : 'bvn-crm';

            return redirect()->route($redirectRoute)->with([
                'status'  => 'success',
                'message' => "{$serviceKey} request submitted. Reference: {$reference}. Charged: NGN " . number_format($servicePrice, 2),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);

            return back()->with([
                'status'  => 'error',
                'message' => 'Submission failed: ' . $e->getMessage()
            ])->withInput();
        }
    }

    /**
     * Price lookup for a field.
     */
    public function getFieldPrice(Request $request)
    {
        $request->validate([
            'field_id' => 'required|exists:modification_fields,id'
        ]);

        $user  = Auth::user();
        $field = ModificationField::findOrFail($request->field_id);

        $price = $field->getPriceForUserType($user->role);

        return response()->json([
            'success'         => true,
            'price'           => $price,
            'formatted_price' => 'NGN ' . number_format($price, 2),
            'field_name'      => $field->field_name,
            'base_price'      => $field->base_price,
        ]);
    }

    /**
     * Show CRM submission details (extend similarly for SENDVNIN if needed).
     */
    public function showDetails($id)
    {
        try {
            $submission = CRMSubmission::with(['modificationField', 'transaction', 'user'])
                ->findOrFail($id);

            if (auth()->id() !== $submission->user_id && !auth()->user()->isAdmin()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access to submission details'
                ], 403);
            }

            return response()->json([
                'success'            => true,
                'submission'         => $submission,
                'field_name'         => $submission->modificationField->field_name,
                'field_description'  => $submission->modificationField->description
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Submission not found or error occurred'
            ], 404);
        }
    }
}

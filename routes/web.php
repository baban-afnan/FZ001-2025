<?php

use App\Http\Controllers\MigrationFormController;
use App\Http\Controllers\NinModificationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\BvnServicesController;
use App\Http\Controllers\BvnUserController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\BvnModificationController;
use App\Http\Controllers\PhoneSearchController;
use App\Http\Controllers\ManualSearchController;
use App\Http\Controllers\AgentEnrollmentController;
use App\Http\Controllers\NINverificationController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PinController;
use App\Http\Controllers\SQAController;
use App\Http\Controllers\NinValidationController;
use App\Http\Controllers\NinipeController;
use App\Http\Controllers\selfserviceController;
use App\Http\Controllers\VIPModificationController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/fhc-portal', function () {
    return redirect()->away('https://portal.fhc.gov.ng/index');
});


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

 // Wallet Route
Route::get('/wallet', [WalletController::class, 'index'])->name('wallet');
Route::post('/virtual/account/create', [WalletController::class, 'createWallet'])->name('virtual.account.create');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/update-required', [ProfileController::class, 'updateRequired'])->name('profile.updateRequired');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('settings.services');
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.updatePhoto');
    Route::put('/profile/security-questions', [SQAController::class, 'update'])->name('profile.updateSecurityQuestions');


    // NIN Modification Routes
    Route::get('/nin-modification/{id}/details', [NinModificationController::class, 'showDetails'])->name('nin-modification.details');
    Route::get('/nin-modification/price', [NinModificationController::class, 'getFieldPrice'])->name('nin-modification.price')->middleware('auth');
    Route::get('/nin-modification', [NinModificationController::class, 'index'])->name('nin-modification');
    Route::post('/nin-modification', [NinModificationController::class, 'store'])->name('nin-modification.store');


    //  Services Route
    Route::get('/Bvn - Services', [ServicesController::class, 'bvnServices'])->name('bvn.services');
    Route::get('/vip-services', [ServicesController::class, 'vipServices'])->name('vip.services');
    Route::get('/NIN - Services', [ServicesController::class, 'ninServices'])->name('nin.services');
    Route::get('/Verification - Services', [ServicesController::class, 'verificationServices'])->name('verification.services');
    Route::get('/Support - services', [ServicesController::class, 'supportServices'])->name('support.services');
    Route::get('/profile - settings', [ServicesController::class, 'settingServices'])->name('settings.services');
    Route::get('/transaction - pin', [ServicesController::class, 'transactionPin'])->name('transaction.pin');
    Route::get('/vip - services', [ServicesController::class, 'vipservices'])->name('vip.services');


    // CRM Routes
    Route::get('/bvn-crm', [BvnServicesController::class, 'index'])->name('bvn-crm');
    Route::post('/bvn-crm', [BvnServicesController::class, 'store'])->name('crm.store');

    Route::get('/send-vnin', [BvnServicesController::class, 'index'])->name('send-vnin');
    Route::post('/send-vnin', [BvnServicesController::class, 'store'])->name('send-vnin.store');

    Route::get('/bvn', [BvnUserController::class, 'index'])->name('bvn.index');
    Route::post('/bvn', [BvnUserController::class, 'store'])->name('bvn.store');
    Route::put('/bvn/{id}', [BvnUserController::class, 'update'])->name('bvn.update');


    Route::get('/support/create', [SupportController::class, 'create'])->name('support.create');
    Route::post('/support/store', [SupportController::class, 'store'])->name('support.store');
    Route::get('/support/history', [SupportController::class, 'history'])->name('support.history');

    // BVN MODIFICATION Routes
    Route::get('/modification-fields/{service_id}', [App\Http\Controllers\BvnModificationController::class, 'getModificationFields']);
    Route::get('/modification', [BvnModificationController::class, 'index'])->name('modification');
    Route::post('/modification', [BvnModificationController::class, 'store'])->name('modification.store');

    Route::get('/phone-search', [PhoneSearchController::class, 'index'])->name('phone.search.index');
    Route::post('/phone-search', [PhoneSearchController::class, 'store'])->name('phone.search.store');
    Route::post('/phone-search/{id}/status', [PhoneSearchController::class, 'updateStatus'])->name('phone.search.status');
    Route::post('/manual-search', [ManualSearchController::class, 'store'])->name('manual-search.store');

    //agent bvn report
    Route::get('/agent-enrollments', [AgentEnrollmentController::class, 'index'])->name('enrollments.index');
    Route::get('/agent-enrollments/data', [AgentEnrollmentController::class, 'getEnrollments'])->name('enrollments.data');
    Route::get('/agent-enrollments/preview/{id}', [AgentEnrollmentController::class, 'preview'])->name('enrollments.preview');

    //transaction pin
    Route::post('/pin/request-otp', [PinController::class, 'requestOtp'])->name('pin.requestOtp');
    Route::post('/pin/verify-otp', [PinController::class, 'verifyOtp'])->name('pin.verifyOtp');
    Route::post('/pin/create', [PinController::class, 'create'])->name('pin.create');
    Route::post('/pin/reset', [PinController::class, 'reset'])->name('pin.reset');

    // NIN Verification Routes
    Route::get('/nin-verification', [NINverificationController::class, 'index'])->name('nin.verification.index');
    Route::post('/nin-verification', [NINverificationController::class, 'store'])->name('nin.verification.store');
    Route::post('/nin-verification/{id}/status', [NINverificationController::class, 'updateStatus'])->name('nin.verification.status');
    Route::get('/standardSlip/{id}', [NINverificationController::class, 'standardSlip'])->name("standardSlip");
    Route::get('/premiumSlip/{id}', [NINverificationController::class, 'premiumSlip'])->name("premiumSlip");

    //Whatsapp API Support Routes--------------------------------------------------------------------------
    Route::get('/support', function () {
        $phoneNumber = env('phoneNumber');
        $message = urlencode(env('message'));
        $url = env('API_URL') .
            "{$phoneNumber}&text={$message}";
        return redirect($url);
    })->name('support');
    //End Whatsapp API Support Routes ------------------------------------------------------------------------------------------


    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/export/pdf', [TransactionController::class, 'exportPdf'])->name('transactions.export.pdf');

    //Vip services
    Route::post('/migration-form', [MigrationFormController::class, 'store'])->name('migration-form.store');

    // Nin validation services
    Route::get('/validation', [NinValidationController::class, 'index'])->name('validation');
    Route::post('/validation', [NinValidationController::class, 'store'])->name('validation.store');
    Route::get('/validation/price', [NinValidationController::class, 'getFieldPrice'])->name('validation.price');
    Route::get('/validation/{id}/details', [NinValidationController::class, 'showDetails'])->name('validation.details');
    

     // Nin selfservice services
    Route::get('/selfservice', [selfserviceController::class, 'index'])->name('selfservice');
    Route::post('/selfservice', [selfserviceController::class, 'store'])->name('selfservice.store');
    Route::get('/selfservice/price', [selfserviceController::class, 'getFieldPrice'])->name('selfservice.price');
    Route::get('/selfservice/{id}/details', [selfserviceController::class, 'showDetails'])->name('selfservice.details');


    // NIN ipe Routes
    Route::get('/ipe/{id}/details', [NinipeController::class, 'showDetails'])->name('ipe.details');
    Route::get('/ipe/price', [NinipeController::class, 'getFieldPrice'])->name('ipe.price')    ->middleware('auth');
    Route::get('/ipe', [NinipeController::class, 'index'])->name('ipe');
    Route::post('/ipe', [NinipeController::class, 'store'])->name('ipe.store');


    // BVN MODIFICATION VIP
    Route::get('/modification-fields/{service_id}', [App\Http\Controllers\VIPModificationController::class, 'getModificationFields']);
    Route::get('/vip-modification', [VIPModificationController::class, 'index'])->name('vip-modification');
    Route::post('/vip-modification', [VIPModificationController::class, 'store'])->name('vip-modification.store');

});


require __DIR__ . '/auth.php';

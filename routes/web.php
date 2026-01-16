<?php

use App\Models\User;
use App\Models\Doctor;
use App\Models\Package;
use App\Models\Promocode;
use App\Models\Reservation;
use App\Models\Transaction;
use App\Models\Prescription;
use Illuminate\Http\Request;
use App\Models\ReservationRequest;
use Illuminate\Support\Facades\Route;
use App\Notifications\NewPromocodeAdded;
use App\Notifications\ReservationApproch;
use App\Notifications\ReservationCancled;
use App\Notifications\NewReservationAdded;
use App\Notifications\NewPackageSubscribed;
use App\Notifications\NewPrescriptionAdded;
use App\Notifications\ReservationCallStart;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use App\Notifications\NewReservationRequest;
use App\Notifications\ReservationCallFinished;
use MyFatoorah\Library\PaymentMyfatoorahApiV2;
use App\Http\Controllers\StripWebhookController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\MyFatoorahWebhookController;
// use Throwable;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');  
    Artisan::call('view:clear');
    Artisan::call('config:cache');
    Artisan::call('route:clear');
   echo "Cache cleared.";
    
});
Route::get('/optimize', function () {
    Artisan::call('optimize');  
    echo "Cache optimize.";
    
});






Route::get('refund/{transaction}', function (Transaction $transaction) {
    /** @var Transaction $transaction */
    if ($transaction != null) {
        $type = Arr::get($transaction->gateway_data, 'type');
        if ($type == 'myfatoorah') {
            $data = $transaction->online_gateway_info;
            $payment_id = $transaction->online_payment_id;
            $response = app(PaymentMyfatoorahApiV2::class)->refund(
                paymentId: $payment_id,
                amount: $transaction->total,
                currencyCode: 'SAR',
                reason: 'cancel reservation',
                orderId: $transaction->id,
            );
            dd($response);
        }
    }
});

Route::get('prescription/{prescription}/print', [
    \App\Http\Controllers\PrintController::class,
    'printPrescription',
])->name('printPrescription');

Route::any('/webhook', MyFatoorahWebhookController::class);
Route::view('/ar', 'site.landing.index_ar');
Route::view('/en', 'site.landing.index_en');
Route::view('/ar/refundpolicies', 'site.refund.policies_ar');
Route::view('/en/refundpolicies', 'site.refund.policies_en');
Route::redirect('/', '/ar');
Route::redirect('/refundpolicies', '/ar/refundpolicies');

Route::prefix('test/notifications')->group(function () {
    Route::get('promo/{patient_id}', function ($p) {
        $user = User::find($p);
        $promocode = Promocode::first();
        throw_if(
            $user == null || $promocode == null,
            new Exception('No User Or Promocode'),
        );
        $user->notify(new NewPromocodeAdded($promocode));
    });
    Route::get('subscription/{doctor_id}', function ($p) {
        $user = Doctor::find($p);
        $promocode = Package::first();
        throw_if(
            $user == null || $promocode == null,
            new Exception('No User Or Package '),
        );
        $user->notify(new NewPackageSubscribed($promocode));
    });

    Route::get('reservation/{doctor_id}', function ($p) {
        $user = Doctor::find($p);
        $promocode = Reservation::first();
        throw_if(
            $user == null || $promocode == null,
            new Exception('No User Or Reservation '),
        );
        $user->notify(new NewReservationAdded($promocode));
    });

    Route::get('reservation/request/{patient_id}', function ($p) {
        $user = User::find($p);
        $promocode = ReservationRequest::first();
        throw_if(
            $user == null || $promocode == null,
            new Exception('No User Or Reservation Request'),
        );
        $user->notify(new NewReservationRequest($promocode));
    });

    Route::get('reservation/approch/{patient_id}', function ($p) {
        $user = User::find($p);
        $promocode = Reservation::first();
        throw_if(
            $user == null || $promocode == null,
            new Exception('No User Or Reservation'),
        );
        $user->notify(new ReservationApproch($promocode));
    });

    Route::get('reservation/start/{patient_id}', function ($p) {
        $user = User::find($p);
        $promocode = Reservation::first();
        throw_if(
            $user == null || $promocode == null,
            new Exception('No User Or Reservation'),
        );
        $user->notify(new ReservationCallStart($promocode));
    });

    Route::get('reservation/finished/{patient_id}', function ($p) {
        $user = User::find($p);
        $promocode = Reservation::first();
        throw_if(
            $user == null || $promocode == null,
            new Exception('No User Or Reservation'),
        );
        $user->notify(new ReservationCallFinished($promocode));
    });

    Route::get('reservation/canceled/{patient_id}', function ($p) {
        $user = User::find($p);
        $promocode = Reservation::first();
        throw_if(
            $user == null || $promocode == null,
            new Exception('No User Or Reservation'),
        );
        $user->notify(new ReservationCancled($promocode));
    });
    Route::get('prescription/added/{patient_id}', function ($p) {
        $user = User::find($p);
        $prescription = Prescription::first();
        throw_if(
            $user == null || $prescription == null,
            new Exception('No User Or Prescription'),
        );
        $user->notify(new NewPrescriptionAdded($prescription));
    });

});


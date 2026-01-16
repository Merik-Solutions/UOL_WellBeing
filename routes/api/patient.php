<?php

use App\Http\Controllers\Api\v1\ScheduleController;
use App\Http\Controllers\Api\v1\Patient;
use App\Http\Controllers\Api\v1\Patient\NotificationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('auth/register', [Patient\AuthController::class, 'register']);
Route::post('auth/send/verification', [
    Patient\AuthController::class,
    'sendSMS',
]);
Route::post('auth/verify', [Patient\AuthController::class, 'verify']);
Route::post('auth/updateFCM', [Patient\AuthController::class, 'updateFCM']);
Route::post('auth/logout', [Patient\AuthController::class, 'logout']);
Route::post('auth/profile', [Patient\AuthController::class, 'profile']);
Route::post('auth/update', [Patient\AuthController::class, 'update']);
Route::post('auth/change-phone', [
    Patient\AuthController::class,
    'updatePhone',
]);
Route::post('auth/new-phone/verify', [
    Patient\AuthController::class,
    'verifyNewPhone',
]);


Route::get('doctors/{category_id}', [Patient\DoctorController::class, 'index']);
Route::get('doctor/{doctor_id}', [Patient\DoctorController::class, 'show']);
Route::get('doctor/{doctor_id}/ratings', [Patient\RatingController::class,'index']);
Route::get('doctor/{doctor_id}/packages', [Patient\PackageController::class,'index']);
Route::get('schedule', ScheduleController::class);

Route::middleware(['auth:api'])->group(function () {
    
    Route::get('promocode/check', [Patient\PromocodeController::class, 'check']);
    Route::apiResource('patients', Patient\PatientController::class)->except('show');

    Route::post('package/subscribe', [Patient\PackageController::class,'store']);

    // Route::post('package/subscribe', [Patient\PackageController::class,'store']);

    Route::get('reservations/upcoming', [
        Patient\ReservationController::class,
        'upcoming',
    ]);
    Route::get('reservations/previous', [
        Patient\ReservationController::class,
        'previous',
    ]);

    Route::get('reservations/invoice/{id?}', [
        Patient\ReservationController::class,
        'getInvoiceData',
    ])->name('reservations.invoice');
    
    Route::post('reservations/create', [
        Patient\ReservationController::class,
        'create',
    ]);
    Route::get('reservations/{reservation}', [
        Patient\ReservationController::class,
        'show',
    ]);
    Route::post('reservations/cancel', [
        Patient\ReservationController::class,
        'cancel',
    ]);
    Route::post('reservations/cancel2', [
        Patient\ReservationController::class,
        'cancel2',
    ]);

    Route::post('reservations/{id}/request/confirm', [
        Patient\ReservationRequestController::class,
        'confirm',
    ]);

    Route::post('reservations/{id}/request/cancel', [
        Patient\ReservationRequestController::class,
        'cancel',
    ]);

    Route::post('reservations/rate', [
        Patient\RatingController::class,
        'create',
    ]);
    Route::post('reservations/call/start', [
        Patient\VideoCallController::class,
        'start',
    ]);
    Route::post('reservations/call/finish', [
        Patient\VideoCallController::class,
        'finish',
    ]);

    //prescriptions
    Route::get('prescriptions', [
        Patient\PrescriptionController::class,
        'index',
    ]);
    Route::get('reservations/{reservation}/prescription', [
        Patient\PrescriptionController::class,
        'show',
    ]);

    //chat
    Route::get('chats', [Patient\ChatController::class, 'index']);
    Route::get('chat/{chat_id}', [Patient\ChatController::class, 'show']);
    Route::post('chats/create', [Patient\ChatController::class, 'create']);
    Route::post('chat/file', [Patient\ChatController::class, 'addImage']);

    Route::get('notifications', [
        Patient\NotificationController::class,
        'notifications',
    ]);
    Route::get('promocodes', [
        Patient\NotificationController::class,
        'promocodes',
    ]);
    Route::get('transactions', [Patient\TransactionController::class, 'index']);
    Route::post('charge', [
        Patient\TransactionController::class,
        'addToWallet',
    ]);
    Route::patch('locale', [Patient\AuthController::class, 'updateLocale']);

    Route::put('notification/{id}/read', [
        NotificationController::class,
        'read',
    ]);
    Route::put('notification/read/all', [
        NotificationController::class,
        'readAll',
    ]);

    Route::get('refund-requests', [
        Patient\RefundRequestController::class,
        'index',
    ]);
    Route::post('refund-requests', [
        Patient\RefundRequestController::class,
        'create',
    ]);

    Route::post('addComplaintOrFeedback', [
        App\Http\Controllers\Api\v1\Patient\ComplaintOrFeedbackController::class,
        'addComplaintOrFeedback',
    ])->name('addComplaintOrFeedback');
    
    Route::post('getReservation', [
        App\Http\Controllers\Api\v1\Patient\ReservationController::class,
        'getPatientReservation',
    ])->name('getReservation');
    
    Route::post('disputed_appointment', [
        App\Http\Controllers\Api\v1\Patient\ReservationController::class,
        'makeAppointmentDisputed',
    ])->name('disputed_appointment');
    
    Route::post('latestPackage', [Patient\PackageController::class, 'latestPackage'])->name('latestPackage');
    Route::post('chat_checking', [Patient\ChatController::class, 'checkingChat'])->name('chat_checking');
    
    Route::post('getDisputedAppointment', [Patient\ComplaintOrFeedbackController::class, 'getDisputedAppointment'])->name('getDisputedAppointment');
    
    Route::get('package/invoice/{id?}', [Patient\PackageController::class,'getInvoiceData',])->name('package.invoice');
    // get all patient invoices by patient id
    Route::get('get_packages/invoices/{patient_id?}', [Patient\PackageController::class,'getInvoicesData',])->name('get_packages.invoices');
});
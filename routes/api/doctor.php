<?php

use App\Http\Controllers\Api\v1\Doctor;
use App\Http\Controllers\Api\v1\Patient\NotificationController;
use Illuminate\Support\Facades\Route;


Route::post('auth/register', [Doctor\AuthController::class, 'register']);
Route::post('auth/send/verification', [
    Doctor\AuthController::class,
    'sendSMS',
]);
Route::post('auth/verify', [Doctor\AuthController::class, 'verify']);
Route::post('auth/updateFCM', [Doctor\AuthController::class, 'updateFCM']);

Route::middleware(['auth:doctor_api'])->group(function () {
    Route::get('prescription', [Doctor\PrescriptionController::class, 'index']);
    Route::post('prescription/create', [
        Doctor\PrescriptionController::class,
        'create',
    ]);
    Route::post('prescription/{prescription}/delete', [
        Doctor\PrescriptionController::class,
        'delete',
    ]);

    Route::post('auth/logout', [Doctor\AuthController::class, 'logout']);
    Route::post('auth/profile', [Doctor\AuthController::class, 'profile']);
    Route::post('auth/update', [Doctor\AuthController::class, 'update']);
    Route::post('auth/update/business', [
        Doctor\AuthController::class,
        'updateBusiness',
    ]);
    Route::post('auth/change-phone', [
        Doctor\AuthController::class,
        'updatePhone',
    ]);
    Route::post('auth/new-phone/verify', [
        Doctor\AuthController::class,
        'verifyNewPhone',
    ]);

    Route::get('reservations', [Doctor\ReservationController::class, 'index']);
    Route::get('reservations/upcoming', [
        Doctor\ReservationController::class,
        'upcoming',
    ]);
    Route::get('reservations/previous', [
        Doctor\ReservationController::class,
        'previous',
    ]);

    Route::apiResource('notes', Doctor\NoteController::class)->only(
        'index',
        'store',
        'update',
        'destroy',
    );
    Route::get('patient', [Doctor\PatientController::class, 'index']);
    Route::get('patient/{user}', [Doctor\PatientController::class, 'show']);
    Route::get('patient/{user}/notes', [
        Doctor\PatientController::class,
        'getNotes',
    ]);
    Route::get('patient/{patient}/prescriptions', [
        Doctor\PatientController::class,
        'getPrescriptions',
    ]);
    Route::get('patient/{patient}/reservations', [
        Doctor\PatientController::class,
        'getReservations',
    ]);

    Route::post('reservations/call/start', [
        Doctor\VideoCallController::class,
        'start',
    ]);
    Route::post('reservations/call/finish', [
        Doctor\VideoCallController::class,
        'finish',
    ]);
    Route::post(
        'reservations/change-request',
        Doctor\ReservationRequestController::class,
    );

    //chat
    Route::get('chats', [Doctor\ChatController::class, 'index']);
    Route::get('chat/{chat_id}', [Doctor\ChatController::class, 'show']);
    Route::post('chat/message', [Doctor\ChatController::class, 'addMessage']);
    Route::post('chat/file', [Doctor\ChatController::class, 'addImage']);

    //withdraws
    Route::get('withdraws', [Doctor\WithdrawRequestController::class, 'index']);
    Route::get('withdraws/finished', [
        Doctor\WithdrawRequestController::class,
        'finished',
    ]);
    Route::get('withdraws/waiting', [
        Doctor\WithdrawRequestController::class,
        'waiting',
    ]);
    Route::post('withdraws/create', [
        Doctor\WithdrawRequestController::class,
        'store',
    ]);
    Route::post('withdraws/delete', [
        Doctor\WithdrawRequestController::class,
        'delete',
    ]);

    Route::get('schedules', [Doctor\ScheduleController::class, 'index']);
    Route::post('schedules/create', [
        Doctor\ScheduleController::class,
        'store',
    ]);

    Route::get('packages', Doctor\PackageController::class);
    Route::get('doctor-packages', [
        Doctor\DoctorPackageController::class,
        'index',
    ]);
    Route::post('doctor-packages', [
        Doctor\DoctorPackageController::class,
        'store',
    ]);
    Route::post('doctor-packages', [
        Doctor\DoctorPackageController::class,
        'store',
    ]);
    Route::post('doctor-packages/{doctorPackage}/delete', [
        Doctor\DoctorPackageController::class,
        'destroy',
    ]);

    Route::get('notifications', [
        Doctor\NotificationController::class,
        'notifications',
    ]);
    Route::post('notify/patient/{patient}', [
        Doctor\PatientController::class,
        'notifyPatient',
    ]);

    Route::patch('locale', [Doctor\AuthController::class, 'updateLocale']);

    Route::put('notification/{id}/read', [
        Doctor\NotificationController::class,
        'read',
    ]);
    Route::put('notification/read/all', [
        Doctor\NotificationController::class,
        'readAll',
    ]);
    
    Route::post('doctor_payment', [App\Http\Controllers\Api\v1\Doctor\PaymentController::class,'doctorPayable',])->name('doctor_payment');
    
    
    Route::post('payments', [Doctor\PaymentController::class,'payments',])->name('payments');

    Route::post('doctor_latestPackages', [Doctor\PackageController::class,'latestPackage',])->name('doctor_latestPackages');
    Route::post('disabled_package', [App\Http\Controllers\Api\v1\Doctor\PackageController::class,'disabledPackage',])->name('disabled_package');

});
Route::post('getDoctorDisputed', [Doctor\ComplaintOrFeedbackController::class,'getDisputedAppointment',])->name('getDoctorDisputed');




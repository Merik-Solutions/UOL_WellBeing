<?php
use Illuminate\Auth\Middleware\Authorize;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\Auth;
use App\Http\Controllers\Admin\ComplaintOrFeedbackController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolesController;
use phpDocumentor\Reflection\Types\Null_;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\TransactionController;

if ( request()->segment(2) == 'en' || request()->segment(2) == 'ar') {
    app()->setLocale(request()->segment(2));
}else{
    app()->setLocale('en');
}
// if (request()->segment(2) == 'ar'){
//     // dd(app()->getLocale());
//     Route::get('/', function () {
//         return redirect(url('admin/ar'));
//     });
// }else{
    Route::get('/', function () {
        return redirect(url('admin/en'));
    });
// }

$locale = app()->getLocale();
// if (!(app()->getLocale() == 'ar'|| app()->getLocale() == 'en')) {
    //     // $locale = app()->setLocale('ar');
    //     Route::redirect('', 'ar/');
    // }
    // if (app()->getLocale()  == 'login' && Request::segment( 2 ) == 'login') {
        //         // return redirect('admin/ar/login');
        //     Route::redirect('', 'ar/');

        //     }
        // dd($locale,Request::segment( 2 ),app()->getLocale() );
// Route::prefix($locale)->middleware('SetLocale')->group(function () {
Route::group(['prefix' => $locale,'where' => ['locale' => '[a-zA-Z]{2}'],'middleware' => 'SetLocale'], function() {

    Route::name('admin.')->group(function () {
        // Login
        Route::get('login', [Auth\LoginController::class, 'showLoginForm'])->name(
            'login',
        );
        Route::post('login', [Auth\LoginController::class, 'login']);
        Route::post('logout', [Auth\LoginController::class, 'logout'])->name(
            'logout',
        );

        // Passwords
        Route::post('password/email', [
            Auth\ForgotPasswordController::class,
            'sendResetLinkEmail',
        ])->name('password.email');
        Route::post('password/reset', [
            Auth\ResetPasswordController::class,
            'reset',
        ]);
        Route::get('password/reset', [
            Auth\ForgotPasswordController::class,
            'showLinkRequestForm',
        ])->name('password.request');
        Route::get('password/reset/{token}', [
            Auth\ResetPasswordController::class,
            'showResetForm',
        ])->name('password.reset');
        // Verify
        Route::post('email/resend', [
            Auth\VerificationController::class,
            'resend',
        ])->name('verification.resend');
        Route::get('email/verify', [
            Auth\VerificationController::class,
            'show',
        ])->name('verification.notice');
        Route::get('email/verify/{id}/{hash}', [
            Auth\VerificationController::class,
            'verify',
        ])->name('verification.verify');
        Route::middleware(['admin.auth:admin'])->group(function () {
            
            Route::get('migrate/{path?}', function ($file) {
                try {
                    if($file){
                        $migrationPath = base_path("database/migrations/{$file}");
                        Artisan::call('migrate', ['--path' => $migrationPath]);
                    }else{
                        Artisan::call('migrate');
                    }
                    echo "Migration successful.";
                } catch (Throwable $e) {
                    print($e->getMessage());
                }
            });
            
            
            Route::get('/', [Admin\HomeController::class, 'index'])->name(
                'dashboard',
            );
            Route::get('/update-statistics', [
                Admin\HomeController::class,
                'updateStatistics',
            ])->name('update-statistics');
            Route::resource('admins', Admin\AdminController::class);
            Route::resource('categories', Admin\CategoryController::class);
            Route::resource('countries', Admin\CountryController::class);

            Route::get('doctors/{doctor}/block', [
                Admin\DoctorController::class,
                'blockDoctor',
            ])->name('doctors.block');
            Route::resource('doctors', Admin\DoctorController::class);
            Route::get('doctor_profile/{id}', [Admin\DoctorController::class,'doctor_profile'])->name('doctor_profile');
            Route::get('doctor/package/status/{id?}', [Admin\DoctorController::class,'isMessagePackage'])->name('doctor.package.status');

            Route::get('doctors/{doctor}/schedules', [
                Admin\ScheduleController::class,
                'index',
            ])->name('schedules.index');

            Route::get('doctors/{doctor}/schedules/create', [
                Admin\ScheduleController::class,
                'create',
            ])->name('schedules.create');
            Route::post('doctors/{doctor}/schedules', [
                Admin\ScheduleController::class,
                'store',
            ])->name('schedules.store');

            // Route::post('patients/{patient}/block', [Admin\PatientController::class, 'block'])->name('patients.block');

            Route::resource('users', Admin\UserController::class);
            Route::resource(
                'users.patients',
                Admin\PatientController::class,
            )->shallow();
            Route::get('patient_profile/{id}', [Admin\PatientController::class,'patient_profile'])->name('patient_profile');

            Route::resource('packages', Admin\PackageController::class);
            Route::get('package/status/{id?}', [Admin\PackageController::class,'isPackageActive'])->name('package.status');
            
            Route::get('dispute_center', [\App\Http\Controllers\Admin\ComplaintOrFeedbackController::class, 'index'])->name('dispute_center');
            Route::get('show_res_detail/{id}', [\App\Http\Controllers\Admin\ComplaintOrFeedbackController::class, 'resDetail'])->name('show_res_detail');
            
            Route::get('payments', [\App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('payments');
            Route::post('filterPayments', [\App\Http\Controllers\Admin\PaymentController::class, 'filterPayments'])->name('filterPayments');

            Route::get('doctor_payment_details/{doctor_id}/status/{status}', [\App\Http\Controllers\Admin\PaymentController::class, 'doctor_payment_details'])->name('doctor_payment_details');

            Route::post(
                'get_package_detail',
                [Admin\PackageController::class,'get_package_detail'],
            )->name('get_package_detail');

            Route::post('show_payment_modal/{doctor_id}', [\App\Http\Controllers\Admin\PaymentController::class, 'show_payment_modal'])->name('show_payment_modal');
            Route::post('pay_total_amount/{doctor_id}', [\App\Http\Controllers\Admin\PaymentController::class, 'pay_total_amount'])->name('pay_total_amount');

            Route::post('show_reservation_detail/{reservation_id}', [\App\Http\Controllers\Admin\ReservationController::class, 'show_reservation_detail'])->name('show_reservation_detail');

            Route::resource('promocodes', Admin\PromocodeController::class);
            Route::resource('contacts', Admin\ContactController::class)->except(
                'create',
                'store',
            );
            Route::resource(
                'notifications',
                Admin\AdminNotificationController::class,
            )->except('update', 'edit', 'show');
            Route::resource('settings', Admin\SettingController::class)->only(
                'index',
                'edit',
                'update',
            );
            Route::resource('reservations', ReservationController::class);

            Route::post(
                'get_reservation_detail',
                [ReservationController::class,'get_reservation_detail'],
            )->name('get_reservation_detail');

            Route::get(
                'get_call_recording/{id?}',
                [ReservationController::class,'getCallRecording'],
            )->name('get_call_recording');
            
            
            Route::post(
                'addComplaintOrFeedbackRemarks',
                [ComplaintOrFeedbackController::class,'addComplaintOrFeedbackRemarks'],
            )->name('addComplaintOrFeedbackRemarks');

            Route::post(
                'add_dispute',
               [Admin\ReservationController::class, 'addDispute']
            )->name('add_dispute');
            Route::resource(
                'reservation.prescription',
                Admin\PrescriptionController::class,
            );
            Route::get('prescriptions',[Admin\PrescriptionController::class, 'getPrescriptions'])->name('get_prescriptions');
            Route::get('prescription_details/{id?}',[Admin\PrescriptionController::class, 'getPrescriptionDetails'])->name('prescription_details');

            Route::get('clinical-notes', [Admin\ClinicalNotesController::class, 'index'])->name('clinical_notes');
            Route::get('note_detail/{id?}', [Admin\ClinicalNotesController::class, 'getNote'])->name('note_detail');
            Route::get('printNote/{id}/print', [\App\Http\Controllers\PrintController::class,'printNote'])->name('printNote');

            
            Route::resource(
                'withdraw-requests',
                Admin\WithdrawRequestController::class,
            )->only('index', 'update','refund_index');
            // Route::get('refunds', [\App\Http\Controllers\Admin\WithdrawRequestController::class, 'refund_index'])->name('refunds');

            Route::resource('chats', Admin\ChatController::class)->only(
                'index',
                'show',
            );
            Route::get('printChat/{id}/print', [\App\Http\Controllers\PrintController::class,'printChat'])->name('printChat');

            Route::get('transactions', [Admin\TransactionController::class,'index'])->name('transactions');
            // Route::get('transactions', TransactionController::class)->name('transactions.index');
            Route::get('get_transactions',[Admin\TransactionController::class,'transactions'])->name('get_transactions');
            Route::post('transactions_filter',[Admin\TransactionFilterController::class,'filter'])->name('transactions_filter');


            //Roles and permissions Routes
            // Route::group(['middleware' => ['role:admin']], function () {
                Route::resource('roles', RolesController::class);
                Route::resource('permissions', PermissionsController::class);
            // });
            
            Route::get('message_packages', [Admin\MessagePackageController::class, 'index'])->name('message_packages');
            Route::post('add_message_dispute', [Admin\MessagePackageController::class, 'add_message_dispute'])->name('add_message_dispute');
            Route::post('show_package_detail/{id}', [Admin\MessagePackageController::class, 'show_package_detail'])->name('show_package_detail');

            Route::get('call_logs', [Admin\VideoCallController::class, 'index'])->name('call_logs');
            Route::get('show_call_log/{id}', [Admin\VideoCallController::class, 'showCallLogs'])->name('show_call_log');

            // reservation invoice view
            Route::get('invoice-pdf/{id?}',[\App\Http\Controllers\PrintController::class,'reservationInvoice'])->name('invoice-pdf');
            // package invoice view
            Route::get('package-invoice/{id?}',[\App\Http\Controllers\PrintController::class,'packageInvoice'])->name('package-invoice');

            Route::get('sale_reports', [\App\Http\Controllers\Admin\HomeController::class,'saleReports'])->name('sale_reports');
            Route::post('filter_reports', [\App\Http\Controllers\Admin\HomeController::class,'filterReports'])->name('filter_reports');

        });

        Route::get('reservation_cancel/{patient_id}/{reservation_id}', [
            \App\Http\Controllers\Admin\ReservationController::class,
            'reservation_cancel_byAdmin',
        ]);

       
    });
});

<?php

namespace App\Http\Controllers\Api\v1\Patient;

use App\Http\Controllers\Controller;
use App\Http\Middleware\ShouldHavePatientId;
use App\Http\Requests\UserDoctorPackage\UserDoctorPackageRequest;
use App\Http\Resources\Package\DoctorPackageResource;
use App\Http\Resources\Package\PackageInvoiceResource;
use App\Http\Resources\Package\PackageResource;
use App\Http\Resources\UserDoctorPackage\SubscriptionResource;
use App\Models\UserDoctorPackage;
use App\Notifications\NewPackageSubscribed;
use App\Repositories\interfaces\DoctorRepository;
use App\Repositories\interfaces\PackageRepository;
use App\Repositories\interfaces\UserDoctorPackageRepository;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class PackageController extends Controller
{
    protected $repo;

    public function __construct(PackageRepository $repo)
    {
        $this->repo = $repo;
        $this->middleware(ShouldHavePatientId::class)->only('store');
    }

    public function index($doctor_id, DoctorRepository $doctorRepo)
    {
        $packages = $doctorRepo->find($doctor_id)->packages;

        return responseJson(
            DoctorPackageResource::collection($packages),
            __('Loaded Successfully'),
        );
    }

    public function store(
        UserDoctorPackageRequest    $request,
        UserDoctorPackageRepository $subscriptionRepo,
    )
    {
        $data = $request->validated();
        /** @var \App\Models\UserDoctorPackage $subscription */
        $subscription = $subscriptionRepo->create($data);
        /** @var \App\Models\User $user */

        $request->validatePaidAmountShouldEqualPackagePrice($data['price']);
        // $request->validateUserWalletHasTheDeductedAmount();
        // if ($request->input('wallet') != 0) {
        //     $subscription->payWallet();
        // }
        // if ($request->input('online') != 0) {
        $subscription->payOnline();
        // }

        //        $subscription->pay($request->gateway);
        $subscription->doctor->notify(new NewPackageSubscribed($subscription->package));
        $subscription->load('transactions');

        $this->packageInvoiceMail($subscription->id);
        return responseJson(
            new SubscriptionResource($subscription),
            __('Subscribed successfully'),
        );
    }

    public function latestPackage(Request $req)
    {
        $package = UserDoctorPackage::with(['package:id,quantity'])->where('patient_id', $req->patient_id)
            ->select('id', 'patient_id', 'doctor_id', 'transaction_id', 'package_id', 'price', 'expired_at', 'created_at')
            ->whereIn('created_at', function ($query) use ($req) {
            $query->selectRaw('MAX(created_at)')
            ->from('user_doctor_packages')
            ->whereColumn('doctor_id', 'user_doctor_packages.doctor_id')
            ->where('patient_id', $req->patient_id)
            ->groupBy('doctor_id');
            })
            ->get();
        return responseJson(
            ['latestPackage' => $package],
            __('Latest patient package.'),
        );
    }

    public function packageInvoiceMail($id){
        $package = UserDoctorPackage::with([
            'doctor:id,name_en,name_ar,company_name',
            'patient:id,name,user_id,relation,email,national_id',
            'transaction',
            'promocode'])->find($id);

        $data['package'] = $package;
        $data['email'] = $package->patient->email;
        $data['patient_name'] = $package->patient?->name ?? '';
        $data['title'] = 'Message Package';
        set_time_limit(300);
        
        $pdf = \PDF::loadHTML(
            view('emails.package_invoice', $data)->render(),
        );
        $pdf = $pdf->setOption('page-width', '100')->setPaper('b4');    
        // return $pdf->inline("kindaHealth_package_invoice.pdf");

        try {
            Mail::send('emails.invoice', $data, function($message)use($data,$pdf) {
                $message->to($data["email"], $data["patient_name"])
                ->subject("KindaHealth Package Invoice")
                ->attachData($pdf->output(), "kindahealth_invoice.pdf");
                });
        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }

    }
    public function getInvoiceData($id){
        $package = UserDoctorPackage::with([
            'doctor:id,name_en,name_ar,company_name',
            'patient:id,name,user_id,relation,email,national_id',
            'transaction',
            'promocode'])->find($id);

        return responseJson(
            new PackageInvoiceResource($package),
            __('Data loaded Successfully'),
        );

    }
    public function getInvoicesData($patient_id){
        $packages = UserDoctorPackage::with([
            'doctor:id,name_en,name_ar,company_name',
            'patient:id,name,user_id,relation,email,national_id',
            'transaction',
            'promocode'])->where('patient_id',$patient_id)->MessageCount()->orderBy('id','desc')->get();

        return responseJson(
            PackageInvoiceResource::collection($packages),
            // $packages,
            __('Data loaded Successfully'),
        );
    }
}

<?php

namespace App\Http\Controllers\Api\v1\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Resources\Package\PackageResource;
use App\Models\DisabledPackage;
use App\Models\UserDoctorPackage;
use App\Repositories\interfaces\PackageRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PackageController extends Controller
{
    public function __invoke(PackageRepository $repo)
    {
        return responseJson(
            PackageResource::collection($repo->isActive()->paginate()),
            __('Loaded Successfully'),
        );
    }


    public function latestPackage(Request $req)
    {
        $package = UserDoctorPackage::with(['package:id,quantity'])->where('doctor_id', $req->doctor_id)
            ->select('id', 'patient_id', 'doctor_id', 'transaction_id', 'package_id', 'price', 'expired_at', 'created_at')
            ->whereIn('created_at', function ($query) use ($req) {
            $query->selectRaw('MAX(created_at)')
            ->from('user_doctor_packages')
            ->whereColumn('patient_id', 'user_doctor_packages.patient_id')
            ->where('doctor_id', $req->doctor_id)
            ->groupBy('patient_id');
            })
            ->get();
        return responseJson(
            ['latestPackage' => $package],
            __('Latest patient package.'),
        );
    }
    
    public function disabledPackage(Request $req)
    {
        if($req->is_disabled == 'true'){
            $package = DisabledPackage::firstOrCreate([
                'package_id' => $req->package_id,
                'doctor_id' => auth()->id()
            ]);
        }else{
            $package = DisabledPackage::where('package_id', $req->package_id)->where('doctor_id',auth()->id())->first();
            if($package){
                $package->delete();
            }
        }
        return responseJson(
            __('Package status changed.'),
        );
    }
}

<?php

namespace App\Http\Controllers\Api\v1\Doctor;

use App\Criteria\OfDoctorCriteria;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\DoctorPackage\StoreDoctorPackageRequest;
use App\Http\Resources\DoctorPackage\DoctorPackageResource;
use App\Models\DoctorPackage;
use App\Repositories\interfaces\DoctorPackageRepository;
use Illuminate\Http\Request;

class DoctorPackageController extends Controller
{
    protected $repo;

    public function __construct(DoctorPackageRepository $repo)
    {
        $this->repo = $repo->pushCriteria(
            new OfDoctorCriteria(auth('doctor_api')->id()),
        );
    }
    public function index()
    {
        $packages = $this->repo->with('package')->paginate();

        return responseJson(DoctorPackageResource::collection($packages));
    }

    public function store(StoreDoctorPackageRequest $request)
    {
        $doctor_package = $this->repo->updateOrCreate(
            [
                'package_id' => $request->package_id,
                'doctor_id' => auth()->id(),
            ],
            $request->validated(),
        );
        return responseJson(
            new DoctorPackageResource($doctor_package),
            __('Saved Successfully'),
        );
    }

    public function destroy(DoctorPackage $doctorPackage)
    {
        $doctorPackage->delete();
        return responseJson(null, __('Deleted Successfully'));
    }
}

<?php

namespace App\Http\Controllers\Api\v1\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Resources\Doctor\DoctorResource;
use App\Models\Doctor;
use App\Repositories\interfaces\DoctorRepository;
use Illuminate\Http\Request;
use App\Models\Reservation;

class DoctorController extends Controller
{
    private $repo;

    public function __construct(DoctorRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        $popular_doctors = $this->repo
            ->with(['category', 'sub_categories'])
            ->where('blocked_at', null)
            ->limit(10)
            ->get()
            ->sortBy(function (Doctor $doctor) {
                return $doctor->reservation()->count();
            });

        $doctors_you_may_call = $this->repo
            ->with(['category', 'sub_categories'])
            ->where('blocked_at', null)
            ->whereNotIn('id', $popular_doctors->pluck('id'))
            ->get();

        $popular_doctors = DoctorResource::collection($popular_doctors);
        $doctors_you_may_call = DoctorResource::collection(
            $doctors_you_may_call,
        );
        return responseJson(
            compact('popular_doctors', 'doctors_you_may_call'),
            __('Loaded Successfully'),
        );
    }

    public function doctorsInCategory(Request $request)
    {
        $doctors = $this->repo->doctorsInCategory($request);
        $doctors = DoctorResource::collection($doctors);
        return responseJson(compact('doctors'), __('Loaded Successfully'));
    }

    public function search(Request $request)
    {
        $doctors = $this->repo->searchInDoctors($request);
        $doctors = DoctorResource::collection($doctors);

        return responseJson(compact('doctors'), __('Loaded Successfully'));
    }
    
}

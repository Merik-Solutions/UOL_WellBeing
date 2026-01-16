<?php

namespace App\Http\Controllers\Api\v1\Patient;

use App\Criteria\OfDoctorCriteria;
use App\Http\Controllers\Controller;
use App\Http\Requests\Rating\StoreRatingRequest;
use App\Http\Resources\Doctor\DoctorResource;
use App\Http\Resources\Rating\RatingResource;
use App\Repositories\interfaces\DoctorRepository;
use App\Repositories\interfaces\RatingRepository;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public $repo;

    public function __construct(RatingRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index($doctor_id, DoctorRepository $doctors)
    {
        $doctor = $doctors->find($doctor_id);
        $this->repo->pushCriteria(new OfDoctorCriteria($doctor_id));
        $ratings = $this->repo->with(['user:id,name'])->paginate(10);
        return responseJson(
            [
                'doctor' => new DoctorResource($doctor),
                'count' => $ratings->total(),
                'ratings' => RatingResource::collection($ratings),
            ],
            __('Loaded Successfully'),
        );
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(StoreRatingRequest $request)
    {
        $rate = $this->repo->updateOrCreate(
            $request->only('reservation_id'),
            $request->validated(),
        );

        return responseJson(
            new RatingResource($rate),
            __('Rated Successfully'),
        );
    }
}

<?php

namespace App\Http\Controllers\Api\v1\Doctor;

use App\Criteria\OfDoctorCriteria;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Schedule\StoreScheduleRequest;
use App\Http\Resources\Schedule\ScheduleResource;
use App\Repositories\interfaces\ScheduleRepository;
use DB;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public $repo;

    public function __construct(ScheduleRepository $repo)
    {
        $this->repo = $repo->pushCriteria(
            new OfDoctorCriteria(auth('doctor_api')->id()),
        );
    }

    public function index(Request $request)
    {
        $schedules = $this->repo->get();

        return responseJson(
            ScheduleResource::collection($schedules),
            __('Loaded Successfully'),
        );
    }

    public function store(StoreScheduleRequest $request)
    {
        /** @var \App\Models\Doctor $doctor */
        $doctor = auth()->user();
        $doctor->fill([
            'price' => $request->price,
            'period' => $request->period,
        ]);
        DB::beginTransaction();
        $schedules = $this->repo->UpdateMultiDaySchedule($request->schedule);
        $doctor->save();
        DB::commit();
        return responseJson(
            [
                'price' => $doctor->price,
                'period' => $doctor->period,
                'schedule' => ScheduleResource::collection($schedules),
            ],
            __('Saved Successfully'),
        );
    }
}

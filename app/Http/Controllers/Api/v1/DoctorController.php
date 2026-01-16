<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Doctor\DoctorResource;
use App\Http\Resources\Schedule\ScheduleResource;
use App\Models\Doctor;
use App\Repositories\interfaces\DoctorRepository;
use App\Repositories\interfaces\ScheduleRepository;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    private $repo;

    public function __construct(DoctorRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getSchedules(
        Request $request,
        ScheduleRepository $scheduleRepo,
    ) {
        $this->validate($request, [
            'doctor_id' => 'required|integer|exists:doctors,id',
        ]);

        $schedules = $scheduleRepo->findWhere($request->only('doctor_id'));

        $schedules = ScheduleResource::collection($schedules);

        return responseJson(compact('schedules'), __('Loaded Successfully'));
    }

    public function getDoctorTimetable(
        Request $request,
        ScheduleRepository $scheduleRepo,
    ) {
        $this->validate($request, [
            'doctor_id' => 'required|integer|exists:doctors,id',
            'date' => 'required|date',
        ]);

        $day = CarbonImmutable::parse($request->date)->weekday() + 1;

        $schedules = $scheduleRepo->findWhere([
            'doctor_id' => $request->doctor_id,
            'day' => $day,
        ]);
        $doctor = $this->repo->findByField('id', $request->doctor_id)->first();
        $times = [];
        foreach ($schedules as $sch) {
            $schedules = ScheduleResource::collection($schedules);
        }
        return responseJson(compact('schedules'), __('Loaded Successfully'));
    }
}

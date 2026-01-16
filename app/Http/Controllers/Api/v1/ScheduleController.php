<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Schedule\AppointmentResource;
use App\Repositories\interfaces\ScheduleRepository;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function __invoke(Request $request, ScheduleRepository $scheduleRepo)
    {
        $this->validate($request, [
            'doctor_id' => 'required|integer|exists:doctors,id',
            'date' => 'required|date',
        ]);

        $day = CarbonImmutable::parse($request->date)->dayOfWeek;

        $schedules = $scheduleRepo->firstWhere([
            'doctor_id' => $request->doctor_id,
            'day' => $day,
        ]);
        if ($schedules == null) {
            return responseJson([], __('No Appointemnts'));
        }
        return responseJson(
            AppointmentResource::collection(optional($schedules)->appointments),
            __('Loaded Successfully'),
        );
    }
}

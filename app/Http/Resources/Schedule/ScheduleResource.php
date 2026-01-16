<?php

namespace App\Http\Resources\Schedule;

use App\Http\Resources\Doctor\DoctorResource;
use App\Http\Resources\Reservation\ReservationResource;
use Carbon\CarbonImmutable;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $is_doctor = false;
        if($this->whenLoaded('doctor')){
            $is_doctor = true;
        }
        // $name = days()[$this->day]
        //     . '-' . CarbonImmutable::parse($this->from_time)->format('h:i A') .
        //     ':'
        //     . CarbonImmutable::parse($this->to_time)->format('h:i A');
        return [
            'id' => $this->id,
            // 'name' => $name,
            'doctor' => new DoctorResource($this->whenLoaded('doctor'),$is_doctor),
            'day' => days()[$this->day],
            'from_time' => CarbonImmutable::parse($this->from_time)->format(
                'H:i',
            ),
            'to_time' => CarbonImmutable::parse($this->to_time)->format(
                'H:i',
            ),
            'reservations' => ReservationResource::collection(
                $this->whenLoaded('reservations'),
            ),
        ];
    }
}

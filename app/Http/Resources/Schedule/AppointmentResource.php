<?php

namespace App\Http\Resources\Schedule;

use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'date' => $request->date,
            'from' => $this->start->toTimeString(),
            'to' => $this->end->toTimeString(),
            'schedule_id' => $this->schedule_id,
            'has_reservation' => $this->has_reservation,
        ];
    }
}

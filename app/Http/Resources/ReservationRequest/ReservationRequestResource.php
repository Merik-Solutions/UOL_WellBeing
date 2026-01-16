<?php

namespace App\Http\Resources\ReservationRequest;

use Illuminate\Http\Resources\Json\JsonResource;

class ReservationRequestResource extends JsonResource
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
            'id' => $this->id,
            'date' => $this->id,
            'from_time' => $this->from_time,
            'to_time' => $this->to_time,
            'status' => __($this->status),
        ];
    }
}

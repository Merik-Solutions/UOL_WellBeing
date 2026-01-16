<?php

namespace App\Http\Resources\Rating;

use App\Http\Resources\Doctor\DoctorResource;
use App\Http\Resources\patients\PatientResource;
use App\Http\Resources\Reservation\ReservationResource;
use App\Models\Reservation;
use Illuminate\Http\Resources\Json\JsonResource;

class RatingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'rate' => (int) $this->rate,
            'description' => $this->description,
            'created_at' => optional($this->created_at)->toDateString(),

            'user' => $this->whenLoaded(
                'patient',
                fn() => [
                    'id' => $this->patient->id,
                    'name' => $this->patient->name,
                ],
            ),
            'doctor' => $this->whenLoaded(
                'doctor',
                fn() => [
                    'id' => $this->doctor->id,
                    'name' => $this->doctor->name,
                    'title' => $this->doctor->title,
                    'image' => $this->doctor->image,
                ],
            ),
            //relashions
        ];
    }
}

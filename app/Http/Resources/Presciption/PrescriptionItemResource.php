<?php

namespace App\Http\Resources\Presciption;

use App\Models\PrescriptionItem;
use Illuminate\Http\Resources\Json\JsonResource;

class PrescriptionItemResource extends JsonResource
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
            'medicine' => $this->medicine,
            'dose' => $this->dose,
            'description' => $this->description,
        ];
    }
}

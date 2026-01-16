<?php

namespace App\Http\Resources\DoctorPackage;

use Illuminate\Http\Resources\Json\JsonResource;

class DoctorPackageResource extends JsonResource
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
            'name' => $this->package->name,
            'description' => $this->package->description,
            'quantity' => $this->package->quantity,
            'package_id' => $this->package_id,
            'price' => number_format($this->price, 1),
            'expires_in' => $this->expires_in,
        ];
    }
}

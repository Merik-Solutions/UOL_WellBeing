<?php

namespace App\Http\Resources\Patient;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

/**
 * @mixin  \App\Models\Patient
 */
class PatientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'name_ar' => $this->name_ar,
            'email' => $this->email,
            'code' => $this->medical_history,
            // 'phone' => $this->phone,
            'birthdate' => $this->birthdate,
            'relation' => $this->relation,
            'gender' => $this->gender,
            'image' => $this->image,
            'national_id' => $this->national_id,
        ];
    }
}

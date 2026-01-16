<?php

namespace App\Http\Resources\Complaint;

use Illuminate\Http\Resources\Json\JsonResource;

class DisputedResource extends JsonResource
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
            'type' => $this->type,
            'description' => $this->description,
            'disputed_id' => $this->disputed_id,
            'disputed_type' => $this->disputed_type,
            'remarks' => $this->remarks,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'patient_id' => $this->patient_id,
            'patient' => $this->patient ??'',
            'reservation' => $this->reservation??'',
            'package' => $this->messagePackage??'',
            'remarks_history' => $this->remarks_history??'',
        ];
    }
}

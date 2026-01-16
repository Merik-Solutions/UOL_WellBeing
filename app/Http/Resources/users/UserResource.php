<?php

namespace App\Http\Resources\users;

use App\Models\Patient;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $user = ($this->resource instanceof Patient) ? $this->resource->user : $this->resource;
        return [
            'id' => $this->id,
            'name' => $this->name ?? $this->mydata->name ?? 'No name' ,
            'name_ar' => $this->name ?? $this->mydata->name_ar ?? 'No name',
            'email' => $this->email ?? $this->mydata->email ?? 'no email',
            'phone' => $this->phone,
            'birthdate' => $this->birthdate,
            'gender' => $this->gender,
            'country' => $this->country,
            'image' => $this->image,
            'national_id' => $this->mydata->national_id ?? null,
            'wallet' => $user->wallet,
            'locale' => $this->locale,
        ];
    }
}

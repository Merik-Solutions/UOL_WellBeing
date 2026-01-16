<?php

namespace App\Http\Resources\Package;

use App\Models\DisabledPackage;
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
        $patient = request()->user()->mydata??null;
        $service_rate = addAppCommission($this->pivot->price);
        $disabled_package = DisabledPackage::where('doctor_id', $this->pivot->doctor_id)->where('package_id', $this->id)->first();
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => number_format(floatval($service_rate),2),
            'vat_tax' => $patient ? floatval(calculateVATtax($patient->national_id,$service_rate)):floatval(priceWithVATtax($service_rate)),
            'quantity' => $this->quantity,
            'expire_in' => $this->pivot->exipres_in,
            'is_disabled' => $disabled_package ? true : false,
        ];
    }
}

<?php

namespace App\Http\Resources\Package;

use App\Http\Resources\Doctor\DoctorResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PackageInvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $service_rate=$this->transaction?->amount + $this->transaction?->commission;
        $discount = $this?->promocode?->percent ? findDiscountedAmount($this->promocode?->percent, $this->doctor->price ):0.00;
        $expire_at = new Carbon($this->expired_at); 
        
        return [
            'package_no' => $this->id,
            'patient_no' => $this->patient->id,
            'patient_name' => $this->patient->name,
            'national_id' => $this->patient->national_id,
            'doctor' => new DoctorResource($this->doctor),
            'doctor_id' => $this->doctor->id,
            'doctor_name' => $this->doctor?->name_en,
            'clinic_name' => $this->doctor->category->name_en,
            'status' => $this->status,
            'expire_at' => $expire_at->format('d M Y H:i'),
            'purchased_at' => $this->created_at->format('d M Y H:i'),
            'service_rate' => floatval($service_rate),
            'commission' => floatVal($this->transaction->commission??0.00),
            'price' => floatval($this->price??0.00),
            'discount' => floatVal($discount??0.00),
            'vat' => floatval($this->transaction->vat_tax??0.00),
            'total' => number_format($service_rate + $this->transaction?->vat_tax, 2),
            'description' => "Message package",
            'date' => $this->created_at->format('d M Y'),
            'quantity'=> $this->package->quantity,
            'total_messages'=> $this->patient_messages_count,
        ];
    }
}

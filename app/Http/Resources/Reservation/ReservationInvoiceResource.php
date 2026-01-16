<?php

namespace App\Http\Resources\Reservation;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\CarbonImmutable;
use Illuminate\Support\Arr;

class ReservationInvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $discount = $this?->promocode?->percent ? findDiscountedAmount($this->promocode?->percent, $this->doctor->price ):0.00;
        $app_date_time = new Carbon($this->date.' '.$this->from_time); 
        
        return [
            'appointment_no' => $this->id,
            'patient_no' => $this->patient_id,
            'patient_name' => $this->patient->name,
            'national_id' => $this->patient->national_id,
            'doctor_id' => $this->doctor_id,
            'doctor_name' => $this->doctor?->name_en,
            'clinic_name' => $this->doctor->category->name_en,
            'date' => CarbonImmutable::parse($this->date)->toDateString(),
            'price' => round($this->price, 1),
            'status' => $this->status,
            'app_date_time' => $app_date_time->format('d M Y H:m'),
            'from_time' => CarbonImmutable::parse($this->from_time)->toTimeString(),
            'to_time' => CarbonImmutable::parse($this->to_time)->toTimeString(),
            'service_rate' => floatval(number_format($this->transaction?->amount, 2)),
            'commission' => floatVal($this->transaction->commission??0.00),
            'price' => floatval($this->price??0.00),
            'discount' => floatVal($discount??0.00),
            'vat' => floatval($this->transaction->vat_tax??0.00),
            'total' => number_format($this->transaction?->total, 2),
            'reservation_status' => $this->reservation_status,
            'description' => "Reservation Appointment",
        ];
    }
}

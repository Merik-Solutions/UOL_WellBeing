<?php

namespace App\Http\Resources\Doctor;

use App\Models\Doctor;
use App\Models\Transaction;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

/**
 * @mixin Doctor
 */
class DoctorResource extends JsonResource
{
    public function __construct($resource)
    {
        parent::__construct($resource);
    }
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $patient = request()->user()->mydata??null;
        $waiting_money = $this->resource->getWaitingMoney();
        $service_rate = addAppCommission($this->price);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'name_ar' => $this->name_ar,
            'name_en' => $this->name_en,
            'title' => $this->title,
            'description' => $this->description,
            'email' => $this->email,
            'phone' => $this->phone,
            'expirence' => $this->expirence,
            'country' => $this->country,
            'price' => $this->isDoctor ? $this->price : floatval($service_rate),
            'vat_tax' => $patient ? floatval(calculateVATtax($patient->national_id,$service_rate)):floatval(priceWithVATtax($service_rate)),
            'status' => $this->status,
            'period' => $this->period,
            'image' => $this->image,
            'heal_cases' => $this->heal_cases,
            'rating_count' => $this->whenLoaded(
                'ratings',
                fn() => $this->ratings->count(),
            ),
            'rating' => $this->whenLoaded(
                'ratings',
                fn() => (string)round($this->ratings->avg('rate'), 1),
            ),
            'wallet' => round($this->wallet ?? 0, 1) + round($waiting_money, 2),
            'category_id' => $this->category_id,
            'national_id' => $this->national_id,
            'birthdate' => $this->birthdate,
            'gender' => $this->gender,
            'company_name' => $this->company_name,
            'company_license' => $this->company_license,
            'license_number' => $this->license_number,
            'locale' => $this->locale,
            'isPackageActive' => $this->isPackageActive == '1' ? 1:0,
            'bank_account' => $this->whenLoaded(
                'bank_account',
                fn() => $this?->bank_account?->data ?? [],
                [],
            ),
        ];
    }
}

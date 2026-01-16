<?php

namespace App\Http\Resources\Package;

use App\Models\DisabledPackage;
use App\Models\DoctorPackage;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Package
 */
class PackageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $package = DisabledPackage::where('doctor_id', auth()->id())->where('package_id', $this->id)->first();
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => request()->user()->locale == 'en'?$this->doc_description_en:$this->doc_description_ar,
            'min_price' => number_format($this->min_price, 1),
            'max_price' => number_format($this->max_price, 1),
            // 'min_expire_in' => $this->min_expire_in ?? 0,
            // 'max_expire_in' => $this->max_expire_in ?? 0,
            'expire_in' => $this->expire_in ?? 0,
            'quantity' => $this->quantity,
            'doctor_price' => DoctorPackage::where('doctor_id', auth()->id())
                ->where('package_id', $this->id)
                ->value('price'),
            'is_disabled' => $package ? true : false,
        ];
    }
}

<?php

namespace App\Http\Resources\Presciption;

use App\Http\Resources\Doctor\DoctorResource;
use App\Http\Resources\patients\PatientResource;
use App\Http\Resources\Reservation\ReservationResource;
use App\Models\PrescriptionItem;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PrescriptionResource extends JsonResource
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
            'id' => $this->id,
            'date' => optional($this->created_at)->format('Y-m-d'),
            // 'title' => $this->title,
            'diagnosis' => $this->diagnosis,
            'qr' => route('printPrescription', $this->id),
            'patient' => $this->when(
                $this->resource->relationLoaded('patient'),
                function () {
                    return [
                        'code' => $this->patient->medical_history,
                        'name' => $this->patient->name,
                        'birthdate' => $this->patient->birthdate,
                        'age' => self::getAge($this->patient->birthdate),
                        'image' => $this->patient->image,
                    ];
                },
            ),
            'items' => $this->items,
            'doctor' => $this->when(
                $this->resource->relationLoaded('doctor'),
                function () {
                    return [
                        'name' => $this->doctor->name,
                        'name_en' => $this->doctor->name_en,
                        'title' => $this->doctor->title,
                        'description' => $this->doctor->description,
                        'logo' => $this->doctor->image,
                        'company_name' => $this->doctor->company_name,
                        'company_license' => $this->doctor->company_license,
                        'license_number' => $this->doctor->license_number,
                        'signature' => $this->doctor->signature,
                    ];
                },
            ),
        ];
    }

    public static function getAge($date = null)
    {
        if ($date == null) {
            return null;
        }

        if ($years = Carbon::now()->diffInYears(Carbon::parse($date))) {
            return $years . __(' Years Old');
        } elseif ($Months = Carbon::now()->diffInMonths(Carbon::parse($date))) {
            return $Months . __(' Months Old');
        } elseif ($days = Carbon::now()->diffInDay(Carbon::parse($date))) {
            return $days . __(' Days Old');
        }
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Prescription;

use App\Models\Reservation;
use App\Repositories\interfaces\ReservationRepository;
use Illuminate\Foundation\Http\FormRequest;

class PrescriptionRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => ['nullable', 'string', 'max:191'],
            'reservation_id' => [
                'nullable',
                'integer',
                //                'exists:reservations,id,doctor_id,' .
                //                auth('doctor_api')->id() .
                //                ',status,' .
                //                Reservation::STATUS_FINISHED,
            ],
            'diagnosis' => 'nullable|string|max:191',
            'description' => 'nullable',
            'patient_id' => ['required', 'integer'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.name' => ['required'],
            'items.*.dose' => ['required'],
            'items.*.dose_number' => ['required'],
            'items.*.days' => ['required', 'nullable'],
        ];
    }

    public function validated($key = null, $default = null)
    {
        // $reservation = app(ReservationRepository::class)
        // ->find($this->reservation_id, ['user_id']);

        $data = [
            'doctor_id' => auth()->id(),
            'code' => rand(00000, 99999),
            // 'user_id' => $reservation->user_id,
        ];
        $inputs = parent::validated();
        return $data + $inputs;
    }
}

<?php

namespace App\Http\Requests\Reservation;

use App\Criteria\IsActiveCriteria;
use App\Repositories\interfaces\DoctorRepository;
use App\Repositories\interfaces\PromocodeRepository;
use App\Rules\BeforeADayOfReservation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CancleReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // dd(111111111111);
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'reservation_id' => [
                'required',
                'integer',
                Rule::exists('reservations', 'id')->where(
                    'patient_id',
                    request('patient_id'),
                ),
                new BeforeADayOfReservation(),
            ],
        ];
    }
}

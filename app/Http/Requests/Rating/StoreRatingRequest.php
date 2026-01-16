<?php

namespace App\Http\Requests\Rating;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRatingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
                Rule::exists('reservations', 'id')
                    ->where('patient_id', request('patient_id'))
                    ->where('doctor_id', $this->doctor_id),
                Rule::unique('ratings', 'reservation_id')
                    ->where('patient_id', request('patient_id'))
                    ->where('doctor_id', $this->doctor_id),
            ],
            'description' => ['nullable', 'string'],
            'doctor_id' => ['required', 'integer', 'exists:doctors,id'],
            'rate' => ['required', 'integer', 'min:0', 'max:5'],
        ];
    }
    public function validated($key = null, $default = null)
    {
        $data = parent::validated();
        $data['user_id'] = auth()->id();
        $data['patient_id'] = request('patient_id');
        return $data;
    }
}

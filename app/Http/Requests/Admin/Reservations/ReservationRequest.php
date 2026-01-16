<?php

namespace App\Http\Requests\Admin\Reservations;

use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
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
            'doctor_id' => 'required|integer|exists:doctors,id',
            'date' => 'required|date|date_format:Y-m-d',
            'from_time' => ['required'],
            'to_time' => ['required'],
            'communication_type' => 'required|integer|min:1|max:2',
            'description' => 'nullable|string',
        ];
    }
}

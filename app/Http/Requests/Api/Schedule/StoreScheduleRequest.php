<?php

namespace App\Http\Requests\Api\Schedule;

use Illuminate\Foundation\Http\FormRequest;

class StoreScheduleRequest extends FormRequest
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
            'period' => ['required', 'integer', 'max:60'],
            'price' => [
                'required',
                'numeric',
                'min:' . config('services.stripe.min'),
            ],
            'schedule' => ['required', 'array', 'min:7'],
            'schedule.*.day' => ['required', 'integer', 'between:0,6'],
            'schedule.*.from_time' => ['nullable', 'date_format:H:i'],
            'schedule.*.to_time' => ['nullable', 'date_format:H:i'],
        ];
    }
}

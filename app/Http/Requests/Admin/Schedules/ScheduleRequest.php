<?php

namespace App\Http\Requests\Admin\Schedules;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class ScheduleRequest extends FormRequest
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
            'schedule.*.day' => 'required|integer|between:0,6',
            'schedule.*.from_time' => [
                'nullable',
                'required_with:schedule.*.to_time',
                'date_format:g:i A',
                'before:schedule.*.to_time',
            ],
            'schedule.*.to_time' => [
                'nullable',
                'required_with:schedule.*.from_time',
                'date_format:g:i A',
                'after:schedule.*.from_time',
            ],
        ];
    }
}

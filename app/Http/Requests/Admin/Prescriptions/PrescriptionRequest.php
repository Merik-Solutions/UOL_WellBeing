<?php

namespace App\Http\Requests\Admin\Prescriptions;

use App\Models\Reservation;
use Illuminate\Foundation\Http\FormRequest;

class PrescriptionRequest extends FormRequest
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
            [
                'diagnosis' => 'required|string|max:191',
                'description' => 'nullable',
                'items' => 'required|array',
                // 'items.*.medicine' => 'required|string|max:191',
                'items.*.name' => 'required|string|max:191',
                'items.*.dose' => 'required|string|max:191',
                'items.*.description' => 'nullable|string',
            ],
        ];
    }
}

<?php

namespace App\Http\Requests\Admin\Doctor;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

/** @property-read \App\Models\Doctor $doctor */
class DoctorRequest extends FormRequest
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
        return ($this->doctor ?? new Doctor())->rules();
    }
}

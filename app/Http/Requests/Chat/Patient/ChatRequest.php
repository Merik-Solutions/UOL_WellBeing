<?php

namespace App\Http\Requests\Chat\Patient;

use App\Criteria\IsActiveCriteria;
use App\Repositories\interfaces\UserDoctorPackageRepository;
use App\Rules\HasDoctorPackage;
use Illuminate\Foundation\Http\FormRequest;

class ChatRequest extends FormRequest
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
            'doctor_id' => [
                'required_without',
                'nullable',
                'integer',
                'exists:doctors,id',
                // new HasDoctorPackage($this->doctor_id),
            ],
        ];
    }
    public function validated($key = null, $default = null)
    {
        $data = parent::validated();

        $data['user_doctor_packages_id'] = $this->getUserDoctorPackageId();
        return $data;
    }
    public function getUserDoctorPackageId()
    {
        return app(UserDoctorPackageRepository::class)
            ->pushCriteria(IsActiveCriteria::class)
            ->ofDoctor($this->doctor_id)
            ->first(['id'])->id;
    }
}

<?php

namespace App\Http\Requests\Chat\Patient;

use App\Criteria\IsActiveCriteria;
use App\Repositories\interfaces\UserDoctorPackageRepository;
use App\Rules\HasDoctorPackage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MessageRequest extends FormRequest
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
            'chat_id' => [
                'required',
                'integer',
                'exists:doctors,id',
                new HasDoctorPackage($this->doctor_id, $this->chat_id),
            ],

            'message' => ['nullable', 'string', 'max:400'],
            'files' => ['nullable', 'array', 'max:10'],
            'files.*' => ['nullable', 'mimes:png,jpg,pdf,txt,jpeg'],
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
            ->ofChat($this->chat_id)
            ->first(['id'])->id;
    }
}

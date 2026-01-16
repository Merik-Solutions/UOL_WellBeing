<?php

namespace App\Http\Requests\Api\DoctorPackage;

use App\Models\DoctorPackage;
use App\Models\Package;
use Illuminate\Foundation\Http\FormRequest;

class StoreDoctorPackageRequest extends FormRequest
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
        return DoctorPackage::make([
            'package_id' => $this->package_id,
        ])->rules();
    }

    public function validated($key = null, $default = null)
    {
        $data = parent::validated();
        $data['doctor_id'] = auth()->id();
        $data['expires_in'] = Package::find($this->package_id)->expire_in;
        return $data;
    }
}

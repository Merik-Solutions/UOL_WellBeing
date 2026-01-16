<?php

namespace App\Http\Requests\Api\Note;

use App\Models\Note;
use Illuminate\Foundation\Http\FormRequest;

class UpdateNoteRequest extends FormRequest
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
        return (new Note())->rules();
    }
    public function validated($key = null, $default = null)
    {
        $data = parent::validated();
        $data['doctor_id'] = auth()->id();
        return $data;
    }
}

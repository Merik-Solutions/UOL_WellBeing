<?php

namespace App\Http\Requests\Chat\Doctor;

use Illuminate\Foundation\Http\FormRequest;

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
            'chat_id' => ['required', 'integer', 'exists:doctors,id'],
            'message' => ['nullable', 'string', 'max:400'],
            'files' => ['nullable', 'array', 'max:10'],
            'files.*' => ['nullable', 'mimes:png,jpg,pdf,txt,jpeg'],
        ];
    }
}

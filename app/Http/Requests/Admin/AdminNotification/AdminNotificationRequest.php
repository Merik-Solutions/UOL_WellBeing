<?php
namespace App\Http\Requests\Admin\AdminNotification;

use Illuminate\Foundation\Http\FormRequest;

class AdminNotificationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:100',
            'body' => 'required|string|max:255',
            'user_types' => ['nullable', 'boolean'],
            'doctors' => ['nullable', 'array'],
            'doctors.*' => ['integer', 'exists:doctors,id'],
            'users' => ['nullable', 'array'],
            'users.*' => ['integer', 'exists:users,id'],
            'file_upload' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'video_url' => ['nullable', 'string'],
        ];
    }
}

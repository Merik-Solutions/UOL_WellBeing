<?php

namespace App\Http\Requests\Admin\categories;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'name_ar' =>
                'required|string|unique:categories,name_ar,' . $this->category,
            'name_en' =>
                'required|string|unique:categories,name_en,' . $this->category,
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'category_id' => 'nullable|integer|exists:categories,id',
            'image' =>
                'nullable|image|mimes:jpeg,png,jpg,svg|max:2048|dimensions:min_width=100,min_height=100',
        ];
    }
}

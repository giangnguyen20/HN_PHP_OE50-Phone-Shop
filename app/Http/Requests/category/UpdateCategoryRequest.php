<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:categories,name,' . request()->id,
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => trans('name.unique'),
            'name.max' => __('max', ['attr' => __('category_name'), 'value' => '255']),
            'name.required' => trans('name.required')
        ];
    }
}

<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
            'name' => 'required|string|unique:products',
            'price' => 'required|numeric|min:0|max:1000000000',
            'accessories' => 'required|string|min:0',
            'warranty' => 'required|numeric|min:1|max:24',
            'color' => 'required|string|min:0',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => trans('name.required'),
            'name.unique' => trans('name.unique'),
            'price.required' => trans('price.required'),
            'price.min' => trans('price.min'),
            'price.max' => trans('price.max'),
            'warranty.min' => trans('warranty.min'),
            'warranty.max' => trans('warranty.max'),
        ];
    }
}

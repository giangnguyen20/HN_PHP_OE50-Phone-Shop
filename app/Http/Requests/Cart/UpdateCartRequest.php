<?php

namespace App\Http\Requests\Cart;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCartRequest extends FormRequest
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
            'qty.*' => 'required|numeric|min:1|max:10',
        ];
    }

    public function messages()
    {
        return [
            'qty.required' => trans('qty.required'),
            'qty.*.numeric' => trans('qty.num'),
            'qty.*.min' => trans('qty.min'),
            'qty.*.max' => trans('qty.max'),
        ];
    }
}

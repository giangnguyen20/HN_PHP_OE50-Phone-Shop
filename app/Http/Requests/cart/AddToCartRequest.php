<?php

namespace App\Http\Requests\cart;

use Illuminate\Foundation\Http\FormRequest;

class AddToCartRequest extends FormRequest
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
            'quantity' => 'numeric|min:1|max:10',
        ];
    }

    public function messages()
    {
        return [
            'quantity.numeric' => trans('qty.num'),
            'quantity.min' => trans('qty.min'),
            'quantity.max' => trans('qty.max'),
        ];
    }
}

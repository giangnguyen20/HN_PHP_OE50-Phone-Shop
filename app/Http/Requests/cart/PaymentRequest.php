<?php

namespace App\Http\Requests\Cart;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
            'name' => 'required|string|min:3',
            'phone' => 'required|digits:10|numeric',
            'address' => 'required|string|min:5',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => trans('name.required'),
            'name.min' => trans('name.min'),
            'phone.digits' => trans('phone.digits'),
            'phone.numeric' => trans('phone.numeric'),
            'address.min' => trans('address.min'),
        ];
    }
}

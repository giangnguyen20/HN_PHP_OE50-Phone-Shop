<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Register extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'fullname.required' => __('required', ['attr' => __('name')]),
            'fullname.string' => __('string', ['attr' => __('name')]),
            'fullname.min' => __('min', ['attr' => __('name'), 'value' => '6']),
            'fullname.max' => __('max', ['attr' => __('name'), 'value' => '255']),
            'email.required' => __('required', ['attr' => __('email')]),
            'email.email' => __('email_val'),
            'email.max' => __('max', ['attr' => __('email'), 'value' => '320']),
            'email.unique' => __('unique', ['attr' => __('email')]),
            'password.required' => __('required', ['attr' => __('password')]),
            'password.string' => __('string', ['attr' => __('password')]),
            'password.min' => __('min', ['attr' => __('password'), 'value' => '8']),
            'password.max' => __('max', ['attr' => __('password'), 'value' => '20']),
            'password.confirmed' => __('confirmed', ['attr' => __('password')]),
        ];
    }
}

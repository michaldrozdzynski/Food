<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterUser extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed',
            'avatar' => 'nullable|mimes:jpg,bmp,png',
            'gender' => [
                'required',
                'string',
                Rule::in(['men', 'women']),
            ]
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.unique' => 'Your e-mail is not unique',
            'password.confirmed' => 'Your password and confirmation password do not match.',
            'gender.required' => 'You must choose your gender.'
        ];
    }
}

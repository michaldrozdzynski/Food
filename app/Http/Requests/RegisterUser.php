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
            'email' => 'required|email|unique:users,email        ',
            'password' => 'required|string',
            'avatar' => 'nullable|mimes:jpg,bmp,png',
            'gender' => [
                'required',
                'string',
                Rule::in(['men', 'women']),
            ]
        ];
    }
}

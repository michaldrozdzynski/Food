<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUser extends FormRequest
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
            'avatar' => 'nullable|mimes:jpg,bmp,png',
            'gender' => [
                'required',
                'string',
                Rule::in(['men', 'women']),
            ]
        ];
    }
}

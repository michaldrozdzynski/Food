<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFoodporn extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
           'user_id' => 'required|integer|exists:users,id',
           'name' => 'required|string',
           'image' => 'required|string',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFoodRecipe extends FormRequest
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
            'image' => 'required|string',
            'category' => 'required|string',
            'cuisine_country' => 'required|string',
            'vegetarian' => 'required|boolean',
            'description' => 'required|string',
            'ingredient' => 'required|array',
        ];
    }

}

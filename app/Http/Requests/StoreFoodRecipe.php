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
            'image' => 'required|mimes:jpg,bmp,png',
            'category_id' => 'required|integer|exists:food_categories,id',
            'cuisine_country_id' => 'required|integer|exists:cuisine_countries,id',
            'vegetarian' => 'required|boolean',
            'description' => 'required|string',
            'ingredient' => 'required|array',
        ];
    }
}

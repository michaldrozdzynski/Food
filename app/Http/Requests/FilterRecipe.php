<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilterRecipe extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'category_id' => 'nullable|integer|exists:food_categories,id',
            'cuisine_country_id' => 'nullable|integer|exists:cuisine_countries,id',
            'vegetarian' => 'nullable|boolean',
            'user_id' => 'nullable|integer|exists:users,id'
        ];
    }
}

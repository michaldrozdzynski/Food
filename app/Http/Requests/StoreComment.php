<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreComment extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'food_recipe_id' => 'required|integer|exists:food_recipes,id',
            'parent_id' => 'nullable|integer|exists:comments,id',
            'content' => 'required|string',
        ];
    }
}

<?php

namespace App\Repositories;

use App\Models\FoodRecipe;
use App\Models\Comment;
use Auth;
use Storage;

/**
 * Class FoodRecipeRepository
 *
 * @package App\Repositories
 */ 
class FoodRecipeRepository
{
    public function getAll(array $data)
    {
        $foodporn =  FoodRecipe::withCategoryAndCuisineCountryAndUser()
            ->orderBy('created_at', 'DESC');

        if (isset($data['vegetarian'])) {
            $foodporn = $foodporn->where('vegetarian', $data['vegetarian']);
        } 

        if (isset($data['category_id'])) {
            $foodporn = $foodporn->where('category_id', $data['category_id']);
        } 

        if (isset($data['cuisine_country_id'])) {
            $foodporn = $foodporn->where('cuisine_country_id', $data['cuisine_country_id']);
        } 

        if (isset($data['user_id'])) {
            $foodporn = $foodporn->where('user_id', $data['user_id']);
        } 
        
        return $foodporn->get();
    }

    public function store(array $data)
    {
        $recipeData = [
            'user_id' => Auth::user()->id,
            'name' => $data['name'],
            'image' => $data['image'],
            'category_id' => $data['category_id'],
            'cuisine_country_id' => $data['cuisine_country_id'],
            'vegetarian' => $data['vegetarian'],
            'description' => $data['description'],
        ];

        $ingredients = $data['ingredient'];

        $foodRecipe = FoodRecipe::create($recipeData);

        $recipeIngredients = [];
        $number = 1;
        foreach($ingredients as $ingredient) {
            array_push($recipeIngredients, $foodRecipe->ingredients()->create([
                'number' => $number,
                'name' => $ingredient,
            ]));

            $number++;
        }    

        $recipe = [
            'foodRecipe' => $foodRecipe,
            'ingredients' => $recipeIngredients,
        ];

        return $recipe;
    }

    public function getOne(FoodRecipe $foodRecipe)
    {
        $recipeIngredients = $foodRecipe->ingredients()->get(); 

        $recipe = [
            'foodRecipe' => $foodRecipe,
            'ingredients' => $recipeIngredients,
        ];

        return $recipe;
    }

    public function plus(FoodRecipe $foodRecipe)
    {
        $foodRecipe->increment('points');
        $foodRecipe->save();

        $foodRecipe->rates()->create([
            'user_id' => Auth::user()->id,
            'rating' => 1,
        ]);

        return $foodRecipe;
    }

    public function minus(FoodRecipe $foodRecipe)
    {
        $foodRecipe->decrement('points');
        $foodRecipe->save();

        $foodRecipe->rates()->create([
            'user_id' => Auth::user()->id,
            'rating' => -1,
        ]);

        return $foodRecipe;
    }

    public function update(array $data, FoodRecipe $foodRecipe) {
        $filename = $foodRecipe->image;

        Storage::delete($filename);

        $recipeData = [
            'user_id' => Auth::user()->id,
            'name' => $data['name'],
            'category_id' => $data['category_id'],
            'cuisine_country_id' => $data['cuisine_country_id'],
            'vegetarian' => $data['vegetarian'],
            'description' => $data['description'],
            'image' => $data['image'],
        ];

        $foodRecipe->update($recipeData);

        $foodRecipe->ingredients()->delete();
        $ingredients = $data['ingredient'];

        $recipeIngredients = [];
        $number = 1;

        foreach($ingredients as $ingredient) {
            array_push($recipeIngredients, $foodRecipe->ingredients()->create([
                'number' => $number,
                'name' => $ingredient,
            ]));

            $number++;
        }    

        $recipe = [
            'foodRecipe' => $foodRecipe,
            'ingredients' => $recipeIngredients,
        ];

        return $recipe;
    }

    public function delete(FoodRecipe $recipe) {
        $filename = $recipe->image;
        
        Storage::delete($filename);

        $recipe->delete();

        return 'Success. You have deleted this recipe.';
    }

}
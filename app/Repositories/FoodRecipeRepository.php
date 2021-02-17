<?php

namespace App\Repositories;

use App\Models\FoodRecipe;
use App\Models\Comment;
use Auth;
use Storage;
use URL;

/**
 * Class FoodRecipeRepository
 *
 * @package App\Repositories
 */ 
class FoodRecipeRepository
{
    public function getAll(array $data)
    {
        $foodRecipe =  FoodRecipe::withCategoryAndCuisineCountryAndUser()
            ->orderBy('created_at', 'DESC');

        if (isset($data['vegetarian'])) {
            $foodRecipe = $foodRecipe->where('vegetarian', $data['vegetarian']);
        } 

        if (isset($data['category_id'])) {
            $foodRecipe = $foodRecipe->where('category_id', $data['category_id']);
        } 

        if (isset($data['cuisine_country_id'])) {
            $foodRecipe = $foodRecipe->where('cuisine_country_id', $data['cuisine_country_id']);
        } 

        if (isset($data['user_id'])) {
            $foodRecipe = $foodRecipe->where('user_id', $data['user_id']);
        } 
        
        $foodRecipes = $foodRecipe->paginate(10);

        foreach ($foodRecipes as $recipe) {
            $recipe->image = URL::to('/') . '/storage//' . substr($recipe->image, 7);
        }

        return $foodRecipes;
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
            'way_of_preparing' => $data['way_of_preparing']
        ];

        $ingredients = $data['ingredient'];

        $foodRecipe = FoodRecipe::create($recipeData);
        $foodRecipe->image = URL::to('/') . '/storage//' . substr($foodRecipe->image, 7);

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

    public function getOne(int $id)
    {
        $foodRecipe = FoodRecipe::withCategoryAndCuisineCountryAndUser()->find($id);

        $recipeIngredients = $foodRecipe->ingredients()->get(); 

        $foodRecipe->image = URL::to('/') . '/storage//' . substr($foodRecipe->image, 7);

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
            'way_of_preparing' => $data['way_of_preparing']
        ];

        $foodRecipe->update($recipeData);
        $foodRecipe->image = URL::to('/') . '/storage//' . substr($foodRecipe->image, 7);

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
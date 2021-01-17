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
            $foodRecipe,
            $recipeIngredients,
        ];

        return $recipe;
    }

    public function getOne(int $id)
    {
        $foodRecipe = FoodRecipe::find($id);
        $recipeIngredients = $foodRecipe->ingredients()->get(); 

        $recipe = [
            $foodRecipe,
            $recipeIngredients,
        ];

        return $recipe;
    }

    public function plus(int $id)
    {
        $foodRecipe = FoodRecipe::find($id);
        $user = Auth::user();
        if ($foodRecipe->rates()->where('user_id', $user->id)->count() > 0) {
            return "You rated this recipe before.";
        } else if ($foodRecipe->user_id === $user->id) {
            return "You cannot rate yours recipe.";
        } else {
            $foodRecipe->increment('points');
            $foodRecipe->save();

            $foodRecipe->rates()->create([
                'user_id' => $user->id,
                'rating' => 1,
            ]);

            return $foodRecipe;
        }
    }

    public function minus(int $id)
    {
        $foodRecipe = FoodRecipe::find($id);
        $user = Auth::user();

        if ($foodRecipe->rates()->where('user_id', $user->id)->count() > 0) {
            return "You rated this recipe before.";
        } else if ($foodRecipe->user_id === $user->id) {
            return "You cannot rate yours recipe.";
        } else {
            $foodRecipe->decrement('points');
            $foodRecipe->save();

            $foodRecipe->rates()->create([
                'user_id' => $user->id,
                'rating' => -1,
            ]);

            return $foodRecipe;
        }
    }

    public function update(array $data, int $id) {
        $foodRecipe = FoodRecipe::find($id);

        if ($foodRecipe->user_id != Auth::user()->id) {
            return "Unautorizate";
        }

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
            $foodRecipe,
            $recipeIngredients,
        ];

        return $recipe;
    }

    public function delete(FoodRecipe $recipe) {
        $user = Auth::user();

        if ($recipe->user_id === $user->id) {
            $filename = $recipe->image;
            
            Storage::delete($filename);

            $recipe->delete();

            return 'Success. You have deleted this recipe.';
        }

        return "You cannot delete this.";
    }

}
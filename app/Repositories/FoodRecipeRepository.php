<?php

namespace App\Repositories;

use App\Models\FoodRecipe;
use Auth;

/**
 * Class FoodRecipeRepository
 *
 * @package App\Repositories
 */ 
class FoodRecipeRepository
{
    public function getAll()
    {
        return FoodRecipe::select([
                'Id',
                'user_id',
                'name',
                'image',
                'points',
                'category',
                'cuisine_country',
                'vegetarian',
            ])
            ->get();
    }

    public function store(array $data)
    {
        $recipeData = [
            'user_id' => Auth::user()->id,
            'name' => $data['name'],
            'category' => $data['category'],
            'cuisine_country' => $data['cuisine_country'],
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

        $recipeData = [
            'user_id' => Auth::user()->id,
            'name' => $data['name'],
            'category' => $data['category'],
            'cuisine_country' => $data['cuisine_country'],
            'vegetarian' => $data['vegetarian'],
            'description' => $data['description'],
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

}
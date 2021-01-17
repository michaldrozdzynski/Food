<?php

namespace App\Policies;

use App\Models\User;
use App\Models\FoodRecipe;
use Illuminate\Auth\Access\HandlesAuthorization;

class FoodRecipePolicy
{
    use HandlesAuthorization;

    public function rate(User $user, FoodRecipe $foodRecipe): bool
    {
        if ($foodRecipe->rates()->where('user_id', $user->id)->count() > 0) {
            return false;
        } else if ($foodRecipe->user_id === $user->id) {
            return false;
        } else {
            return true;
        }
    }

    public function update(User $user, FoodRecipe $foodRecipe): bool
    {
        if ($user->id === $foodRecipe->user_id) {
            return true;
        } else {
            return false;
        }
    }

    public function delete(User $user, FoodRecipe $foodRecipe): bool
    {
        if ($user->id === $foodRecipe->user_id) {
            return true;
        } else {
            return false;
        }
    }
}

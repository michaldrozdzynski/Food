<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Foodporn;
use App\Models\FoodpornRate;
use Illuminate\Auth\Access\HandlesAuthorization;

class FoodpornPolicy
{
    use HandlesAuthorization;

    public function rate(User $user, Foodporn $foodporn): bool
    {
        if ($user->id == $foodporn->user_id) {
            return false;
        } else if ($foodporn->rates()->where('user_id', $user->id)->count() > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function delete(User $user, Foodporn $foodporn): bool
    {
        if ($user->id === $foodporn->user_id) {
            return true;
        } else {
            return false;
        }
    }
}

<?php

namespace App\Repositories;

use App\Models\Foodporn;
use App\Models\FoodpornRate;
use App\Models\User;

/**
 * Class FoodpornRepository
 *
 * @package App\Repositories
 */ 
class FoodpornRepository
{
    
    public function getOne(User $user)
    {
            $foodporns = Foodporn::orderBy('created_at', 'DESC')
            ->select([
                'id',
                'user_id',
                'name',
                'image',
                'points',
            ])
            ->withUserName()
            ->where('user_id', '!=', $user->id)
            ->get();  

            foreach ($foodporns as $foodporn) {
                if (FoodpornRate::where('foodporn_id', $foodporn->id)->where('user_id', $user->id)->count() === 0) {
                    return $foodporn;
                }
            }

            return null;
    }

    public function store(array $data): Foodporn
    {
        return Foodporn::create($data);
    }

    public function plus(Foodporn $foodporn, User $user)
    {
        if ($user->id == $foodporn->user_id) {
            return "You cannot rate yours photo.";
        } else if (FoodpornRate::where('foodporn_id', $foodporn->id)->where('user_id', $user->id)->count()) {
            return "You rated this photo before.";
        } else {
            $foodporn->increment('points');
            $foodporn->save();

            FoodpornRate::create([
                'user_id' => $user->id,
                'foodporn_id' => $foodporn->id,
                'rating' => 1,
            ]);

            return $foodporn;
        }
    }

    public function minus(Foodporn $foodporn, User $user)
    {
        if ($user->id == $foodporn->user_id) {
            return "You cannot rate yours photo.";
        } else if (FoodpornRate::where('foodporn_id', $foodporn->id)->where('user_id', $user->id)->count()) {
            return "You rated this photo before.";
        } else {
            $foodporn->decrement('points');
            $foodporn->save();

            FoodpornRate::create([
                'user_id' => $user->id,
                'foodporn_id' => $foodporn->id,
                'rating' => -1,
            ]);

            return $foodporn;
        }
    }

    public function delete(Foodporn $foodporn, User $user): string
    {
        if ($foodporn->user_id === $user->id) {
            $foodporn->delete();

            return 'Success. You have deleted this photo.';
        }
        return "You cannot delete this.";
    }
}

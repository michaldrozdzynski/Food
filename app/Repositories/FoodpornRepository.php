<?php

namespace App\Repositories;

use Auth;
use App\Models\Foodporn;
use App\Models\FoodpornRate;
use App\Models\User;
use Storage;
use URL;

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
                    $foodporn->image = URL::to('/') . '/storage//' . substr($foodporn->image, 7);
                    return $foodporn;
                }
            }

            return null;
    }

    public function store(array $data)//: Foodporn
    {
        $foodporn = Foodporn::create($data);
        $foodporn->image = URL::to('/') . '/storage//' . substr($foodporn->image, 7);

        return $foodporn;
    }

    public function plus(Foodporn $foodporn, User $user)
{
        $foodporn->increment('points');
        $foodporn->save();

        FoodpornRate::create([
            'user_id' => $user->id,
            'foodporn_id' => $foodporn->id,
            'rating' => 1,
        ]);

        return response()->json($foodporn, 200);
    }

    public function minus(Foodporn $foodporn, User $user)
    {
        $foodporn->decrement('points');
        $foodporn->save();

        FoodpornRate::create([
            'user_id' => $user->id,
            'foodporn_id' => $foodporn->id,
            'rating' => -1,
        ]);

        return response()->json($foodporn, 200);     
    }

    public function delete(Foodporn $foodporn, User $user): string
    {
            $filename = $foodporn->image;

            Storage::delete($filename);

            $foodporn->delete();

            return 'Success. You have deleted this photo.';
    }
}

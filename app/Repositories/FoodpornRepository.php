<?php

namespace App\Repositories;

use App\Models\Foodporn;
use App\Models\User;
use Illuminate\Support\Collection;

/**
 * Class FoodpornRepository
 *
 * @package App\Repositories
 */ 
class FoodpornRepository
{
    
    public function getOne()
    {
        return $foodporn = Foodporn::orderBy('created_at', 'DESC')
            ->select([
                'user_id',
                'name',
                'image',
                'points',
            ])
            ->withUserName()
            ->first()
            ->toArray();
        
        
    }
}

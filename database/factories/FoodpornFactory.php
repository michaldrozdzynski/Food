<?php

namespace Database\Factories;

use App\Models\Foodporn;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Storage;

class FoodpornFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Foodporn::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::InRandomOrder()->first();

        $imageUrl = $this->faker->image(Storage::path('public/images/foodporn'), $width = 640, $height = 480, 'foodporn');
        $imgUrl = substr($imageUrl, strlen(Storage::path('')));
    
        return [
            'user_id' => $user->id,
            'name' => $this->faker->word,
            'image' => $imgUrl,
        ];
    }
}

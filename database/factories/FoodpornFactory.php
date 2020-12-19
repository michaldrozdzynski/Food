<?php

namespace Database\Factories;

use App\Models\Foodporn;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

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

        return [
            'user_id' => $user->id,
            'name' => $this->faker->word,
        ];
    }
}

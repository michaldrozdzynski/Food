<?php

namespace Database\Factories;

use App\Models\FoodRecipe;
use App\Models\User;
use App\Models\FoodCategory;
use App\Models\CuisineCountry;
use Illuminate\Database\Eloquent\Factories\Factory;
use Storage;

class FoodRecipeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FoodRecipe::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::InRandomOrder()->first();

        $category = FoodCategory::inRandomOrder()->first();

        $country = CuisineCountry::inRandomOrder()->first();

        $imageUrl = $this->faker->image(Storage::path('public\images\foodrecipe'), $width = 640, $height = 480, 'foodrecipe');
        $imgUrl = substr($imageUrl, strlen(Storage::path('')));

        return [
            'user_id' => $user->id,
            'name' => $this->faker->word,
            'category_id' => $category->id,
            'cuisine_country_id' => $country->id,
            'vegetarian' => $this->faker->boolean,
            'description' => $this->faker->text,
            'image' => $imgUrl,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (FoodRecipe $recipe) {
            $max = $this->faker->numberBetween(3,8);
        
            for ($i = 1; $i<= $max; $i++) {
                $recipe->ingredients()->create([
                    'number' => $i,
                    'name' => $this->faker->word,
                ]);
            }
            
            $max = $this->faker->numberBetween(0,3);
        
            for ($i = 0; $i< $max; $i++) {
                $user = User::InRandomOrder()->first();
                $comment = $recipe->comments()->create([
                    'user_id' => $user->id,
                    'content' => $this->faker->text,
                ]);

                $max2 = $this->faker->numberBetween(0,3);
                
                for ($j = 0; $j < $max2; $j++) {
                    $user = User::InRandomOrder()->first();
                    $recipe->comments()->create([
                        'user_id' => $user->id,
                        'content' => $this->faker->text,
                        'parent_id' => $comment->id,
                    ]);
                }
            }
        });
        
    }
}

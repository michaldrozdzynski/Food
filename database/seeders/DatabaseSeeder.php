<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            FoodCategorySeeder::class,
            CuisineCountrySeeder::class,
        ]);

         \App\Models\User::factory(10)->create();
         \App\Models\Foodporn::factory(10)->create();
         \App\Models\FoodRecipe::factory(10)->create();
         \App\Models\Conversation::factory(10)->create();
    }
}

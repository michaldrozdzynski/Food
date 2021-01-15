<?php

namespace Database\Seeders;

use App\Models\FoodCategory;
use Illuminate\Database\Seeder;

class FoodCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'Breakfast', 'Lunch', 'Appetizers', 'Soups', 'Main dishes', 'Side dishes', 'Desserts', 'Other'
        ];

        foreach ($categories as $category) {
            FoodCategory::create([
                'name' => $category
            ]);
        }
    }
}

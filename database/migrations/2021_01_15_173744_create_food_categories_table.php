<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
        });

        Schema::table('food_recipes', function (Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('food_categories');
        });
    }
}

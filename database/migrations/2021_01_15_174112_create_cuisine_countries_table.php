<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCuisineCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuisine_countries', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
        });

        Schema::table('food_recipes', function (Blueprint $table) {
            $table->foreign('cuisine_country_id')->references('id')->on('cuisine_countries');
        });
    }
}

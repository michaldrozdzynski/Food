<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->group(function () {
    Route::get('/foodporn', 'FoodpornController@index');
    Route::post('/foodporn', 'FoodpornController@store');
    Route::patch('/foodporn/{foodporn}/good', 'FoodpornController@good');
    Route::patch('/foodporn/{foodporn}/bad', 'FoodpornController@bad');
    Route::delete('/foodporn/{foodporn}', 'FoodpornController@destroy');

    Route::get('/foodrecipe', 'FoodRecipeController@index')->withoutMiddleware('auth:api');
    Route::post('/foodrecipe', 'FoodRecipeController@store');
    Route::get('/foodrecipe/{recipe}', 'FoodRecipeController@show')->withoutMiddleware('auth:api');
    Route::patch('/foodrecipe/{recipe}/good', 'FoodRecipeController@good');
    Route::patch('/foodrecipe/{recipe}/bad', 'FoodRecipeController@bad');
    Route::put('/foodrecipe/{recipe}', 'FoodRecipeController@update');
    Route::delete('/foodrecipe/{recipe}', 'FoodRecipeController@destroy');

    Route::get('/comment/{recipe}', 'CommentController@index')->withoutMiddleware('auth:api');
    Route::post('/comment', 'CommentController@store');
    Route::patch('/comment/{comment}/good', 'CommentController@good');
    Route::patch('/comment/{comment}/bad', 'CommentController@bad');
    Route::delete('/comment/{comment}', 'CommentController@destroy');

    Route::get('/conversation', 'ConversationController@index');
    Route::post('/conversation/{user}', 'ConversationController@store');
    Route::get('/conversation/{conversation}', 'ConversationController@show');
    Route::post('/conversation/{conversation}/send', 'ConversationController@send');

    Route::get('/foodcategory', 'CategoryAndCuisineController@getCategory')->withoutMiddleware('auth:api');
    Route::get('/cuisine-country', 'CategoryAndCuisineController@getCuisineCountry')->withoutMiddleware('auth:api');

    Route::get('/user/{user}', 'UserController@show');
    Route::put('/user', 'UserController@update');

    Route::get('/logout', 'UserController@logout');
});

Route::post('/register', 'UserController@register');
Route::post('/login', 'UserController@login');

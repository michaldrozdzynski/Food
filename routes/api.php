<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AuthBasic;

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
    Route::patch('/foodporn/{id}/good', 'FoodpornController@good');
    Route::patch('/foodporn/{id}/bad', 'FoodpornController@bad');
    Route::delete('/foodporn/{id}', 'FoodpornController@destroy');

    Route::get('/foodrecipe', 'FoodRecipeController@index');
    Route::post('/foodrecipe', 'FoodRecipeController@store');
    Route::get('/foodrecipe/{id}', 'FoodRecipeController@show');
    Route::patch('/foodrecipe/{id}/good', 'FoodRecipeController@good');
    Route::patch('/foodrecipe/{id}/bad', 'FoodRecipeController@bad');
    Route::put('/foodrecipe/{id}', 'FoodRecipeController@update');
    Route::delete('/foodrecipe/{recipe}', 'FoodRecipeController@destroy');

    Route::get('/comment/{recipeId}', 'CommentController@index');
    Route::post('/comment', 'CommentController@store');
    Route::patch('/comment/{comment}/good', 'CommentController@good');
    Route::patch('/comment/{comment}/bad', 'CommentController@bad');

    Route::get('/conversation', 'ConversationController@index');
    Route::post('/conversation/{user}', 'ConversationController@store');
    Route::get('/conversation/{conversation}', 'ConversationController@show');
    Route::post('/conversation/{conversation}/send', 'ConversationController@send');

    Route::get('/user/{user}', 'UserController@show');
    Route::put('/user', 'UserController@update');

    Route::get('/logout', 'UserController@logout');
});

Route::post('/register', 'UserController@register');
Route::post('/login', 'UserController@login');

<?php

use Illuminate\Http\Request;
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

Route::get('/foodporn', 'FoodpornController@index');
Route::post('/foodporn', 'FoodpornController@store');
Route::put('/foodporn/{id}/good', 'FoodpornController@good');
Route::put('/foodporn/{id}/bad', 'FoodpornController@bad');
Route::delete('/foodporn/{id}', 'FoodpornController@destroy');

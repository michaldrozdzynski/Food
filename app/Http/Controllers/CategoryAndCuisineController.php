<?php

namespace App\Http\Controllers;

use App\Models\CuisineCountry;
use App\Models\FoodCategory;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CategoryAndCuisineController extends Controller
{
    public function getCategory(): JsonResponse
    {
        return response()->json(FoodCategory::orderBy('id')->get());
    }

    public function getCuisineCountry(): JsonResponse
    {
        return response()->json(CuisineCountry::orderBy('id')->get());
    }
}

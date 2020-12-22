<?php

namespace App\Http\Controllers;

use App\Repositories\FoodRecipeRepository;
use App\Http\Requests\StoreFoodRecipe;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FoodRecipeController extends Controller
{
    private $foodRecipes;

    public function __construct(FoodRecipeRepository $foodRecipeRepository) 
    {
        $this->foodRecipes = $foodRecipeRepository;
    }

    public function index(): JsonResponse
    {
        return response()->json($this->foodRecipes->getAll());
    }

    public function store(StoreFoodRecipe $request): JsonResponse
    {
        return response()->json($this->foodRecipes->store($request->validated()));
    }

    public function show(int $id): JsonResponse
    {
        return response()->json($this->foodRecipes->getOne($id)); 
    }

    public function good(int $id): JsonResponse
    {
        return response()->json($this->foodRecipes->plus($id));
    }

    public function bad(int $id): JsonResponse
    {
        return response()->json($this->foodRecipes->minus($id));
    }

    public function update(StoreFoodRecipe $request, int $id): JsonResponse
    {
        return response()->json($this->foodRecipes->update($request->validated(), $id));
    }

}

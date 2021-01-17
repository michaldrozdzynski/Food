<?php

namespace App\Http\Controllers;

use App\Repositories\FoodRecipeRepository;
use App\Http\Requests\StoreFoodRecipe;
use App\Http\Requests\FilterRecipe;
use App\Models\FoodRecipe;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FoodRecipeController extends Controller
{
    private $foodRecipes;

    public function __construct(FoodRecipeRepository $foodRecipeRepository) 
    {
        $this->foodRecipes = $foodRecipeRepository;
    }

    public function index(FilterRecipe $request): JsonResponse
    {
        $data = $request->validated();

        return response()->json($this->foodRecipes->getAll($data));
    }

    public function store(StoreFoodRecipe $request): JsonResponse
    {
        $data = $request->validated();
        $data['image'] = $request->file('image')->store('images/foodrecipe');

        return response()->json($this->foodRecipes->store($data));
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
        $data = $request->validated();
        $data['image'] = $request->file('image')->store('images/foodrecipe');

        return response()->json($this->foodRecipes->update($data, $id));
    }

    public function destroy(FoodRecipe $recipe): JsonResponse
    {
        return response()->json($this->foodRecipes->delete($recipe));
    }

}

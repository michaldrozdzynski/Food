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
        $data['image'] = $request->file('image')->store('public/images/foodrecipe');

        return response()->json($this->foodRecipes->store($data), 201);
    }

    public function show(FoodRecipe $recipe): JsonResponse
    {
        return response()->json($this->foodRecipes->getOne($recipe)); 
    }

    public function good(FoodRecipe $recipe): JsonResponse
    {
        $this->authorize('rate', $recipe);

        return response()->json($this->foodRecipes->plus($recipe));
    }

    public function bad(FoodRecipe $recipe): JsonResponse
    {
        $this->authorize('rate', $recipe);

        return response()->json($this->foodRecipes->minus($recipe));
    }

    public function update(StoreFoodRecipe $request, FoodRecipe $recipe): JsonResponse
    {
        $this->authorize('update', $recipe);

        $data = $request->validated();
        $data['image'] = $request->file('image')->store('public/images/foodrecipe');

        return response()->json($this->foodRecipes->update($data, $recipe));
    }

    public function destroy(FoodRecipe $recipe): JsonResponse
    {
        $this->authorize('delete', $recipe);
        
        return response()->json($this->foodRecipes->delete($recipe), 204);
    }

}

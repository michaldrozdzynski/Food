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

    public function show(int $id): JsonResponse
    {
        return response()->json($this->foodRecipes->getOne($id)); 
    }

    public function checkRate(FoodRecipe $recipe) {
        if ($recipe->user_id === auth()->user()->id) {
            return response()->json(false);
        } else if ($recipe->rates()->where('user_id', auth()->user()->id)->count() > 0) {
            return (response()->json(false));
        } else {
            return response()->json(true);
        }
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

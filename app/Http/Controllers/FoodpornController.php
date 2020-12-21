<?php

namespace App\Http\Controllers;

use App\Repositories\FoodpornRepository;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Foodporn;
use Auth;
use App\Http\Requests\StoreFoodporn;

class FoodpornController extends Controller
{
    private $foodporns;

    public function __construct(FoodpornRepository $foodpornRepository) 
    {
        $this->foodporns = $foodpornRepository;
    }

    public function index(): JsonResponse
    {   
        return response()->json($this->foodporns->getOne(Auth::user()));
    }

    public function store(StoreFoodporn $request): JsonResponse
    {   
        return response()->json($this->foodporns->store($request->validated()));
    }

    public function good(int $id): JsonResponse
    {
        $foodporn = Foodporn::find($id);

        return response()->json($this->foodporns->plus($foodporn, Auth::user()));
    }

    public function bad(int $id): JsonResponse
    {
        $foodporn = Foodporn::find($id);

        return response()->json($this->foodporns->minus($foodporn, Auth::user()));
    }
    
    public function destroy(int $id): JsonResponse
    {
        $foodporn = Foodporn::find($id);
        
        return response()->json($this->foodporns->delete($foodporn, Auth::user()));
    }
}

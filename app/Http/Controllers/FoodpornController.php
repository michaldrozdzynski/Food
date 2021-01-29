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
        $data = [
            'image' => $request->file('image')->store('public/images/foodporn'),
            'user_id' => Auth::user()->id,
            'name' => $request->name,
        ];

        return response()->json($this->foodporns->store($data), 201);
    }

    public function good(Foodporn $foodporn): JsonResponse
    {
        $this->authorize('rate', $foodporn);

        return $this->foodporns->plus($foodporn, Auth::user());
    }

    public function bad(Foodporn $foodporn): JsonResponse
    {
        $this->authorize('rate', $foodporn);

        return $this->foodporns->minus($foodporn, Auth::user());
    }
    
    public function destroy(Foodporn $foodporn): JsonResponse
    { 
        $this->authorize('delete', $foodporn);

        return response()->json($this->foodporns->delete($foodporn, Auth::user()), 204);
    }
}

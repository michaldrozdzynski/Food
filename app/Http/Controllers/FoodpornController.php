<?php

namespace App\Http\Controllers;

use App\Repositories\FoodpornRepository;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Foodporn;

class FoodpornController extends Controller
{
    private $foodporns;

    public function __construct(FoodpornRepository $foodpornRepository) 
    {
        $this->foodporns = $foodpornRepository;
    }

    public function index(): JsonResponse
    {
        return response()->json($this->foodporns->getOne());
    }
}

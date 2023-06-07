<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            "quantity" => Product::all()->count(),
            "products" => Product::all()->all()
        ]);
    }
}

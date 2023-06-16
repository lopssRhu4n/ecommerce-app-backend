<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    public function __invoke(Request $request, int $id): JsonResponse
    {
        $product = Product::query()->find($id);
        $product->update($request->all());

        return response()->json($product);
    }
}

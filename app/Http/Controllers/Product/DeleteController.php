<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class DeleteController extends Controller
{
    public function __invoke(int $id)
    {
            $product = Product::query()->find($id);

            $product->delete();

            return response()->json([]);
    }
}

<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;

class ShowController extends Controller
{
    public function __invoke(int $id)
    {

        try {
            $category = Category::query()->findOrFail($id);
            $category->products;

            return response()->json($category->toArray(), 200);

        } catch (\Throwable $th) {
            return response()->json(["Error" => $th->getMessage()], $th->getCode());
        }
    }
}

<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{

    public function __invoke(): JsonResponse
    {
      return response()->json(Category::all());
    }

}

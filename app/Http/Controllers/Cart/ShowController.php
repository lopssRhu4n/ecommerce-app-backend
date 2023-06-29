<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Models\Cart;

class ShowController extends Controller
{
    public function __invoke(int $cartId)
    {
        try {
            return response()->json(Cart::query()->findOrFail($cartId)->toArray());
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th->getMessage()], $th->getCode());
        }
    }
}

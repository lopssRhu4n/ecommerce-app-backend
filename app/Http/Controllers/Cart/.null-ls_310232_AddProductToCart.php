<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartProduct;
use Illuminate\Http\Request;

class AddProductToCart extends Controller
{
    public function __invoke(Request $req)
    {
        try {
            $validated = $req->validate([
                'cart_id' => 'required|int',
                'product_id' => 'required|int'
            ]);

            CartProduct::query()->create($validated);

            $cart = Cart::query()->find($validated['cart_id']);

            $products = $cart->products;

            $cartAmount = 0;

            foreach ($products as $product) {
                $cartAmount += $product->price;
            }

            $cart->amount = $cartAmount;
            $cart->save();

            return response()->json(["created" => true, "cart" => $cart, "cart_products" => $cart->products], 201);
        } catch (\Illuminate\Validation\ValidationException $th){
           return response()->json(["Error" => $th->errors()], 400);
        }
    }
}

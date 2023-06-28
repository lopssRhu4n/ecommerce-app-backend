<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;

class CreateController extends Controller
{

    public function __invoke(Request $req)
    {
        try {
             $validated = $req->validate([
                'client_id' => 'required'
            ]);

            $data = [ "client_id" => $validated['client_id'], "amount" => 0, "shipping" => 0, "discount" => 0];

            $cart = Cart::query()->create($data);

            return response()->json(["created" => true, "cart" => $cart->toArray()], 201);
        } catch (\Illuminate\Validation\ValidationException $th){
           return response()->json(["Error" => $th->errors()[0]], 400);
        }
    }

}

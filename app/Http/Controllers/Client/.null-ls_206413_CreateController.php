<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Client;

class CreateController extends Controller
{
    public function __invoke(Request $req): JsonResponse
    {
        try {
            $validated = $req->validate([
                'name' =>  ['required'],
                'cpf' => ['required', 'unique:clients'],
                'birthdate' => ['required'],
                'phone' => ['required'],
            ], ['cpf.unique' => 'CPF already registered.']);

            $clientCollection= Client::query()->create($validated);

            Cart::query()->create(['client_id' => $clientCollection->id, 'amount' => 0, 'shipping' => 0, 'discount' => 0])->toArray();

            $clientCollection->cart;
            $clientData = $clientCollection->toArray();

            return response()->json(['created' => true, 'client' => $clientData], 201);
        } catch (\Illuminate\Validation\ValidationException $th) {
            return response()->json(['Errors' => $th->errors()], 400);
        }
    }
}

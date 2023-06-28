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
                'email' => ['required', 'unique:clients', 'email'],
                'cpf' => ['required', 'unique:clients'],
                'birthdate' => ['required'],
                'phone' => ['required'],
            ], ['cpf.unique' => 'CPF already registered.']);

            $clientData = Client::query()->create($validated)->toArray();

            Cart::query()->create(['client_id' => $clientData['id'], 'amount' => 0, 'shipping' => 0, 'discount' => 0]);

            return response()->json(['created' => true, 'client' => $clientData], 201);
        } catch (\Illuminate\Validation\ValidationException $th) {
            return response()->json(['Errors' => $th->errors()], 400);
        }
    }
}

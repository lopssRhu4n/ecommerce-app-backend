<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateController extends Controller
{
    public function __invoke(Request $req): JsonResponse
    {
        try {

            $userCollection = $this->createUser($req);

            $validated = $req->validate([
                'cpf' => ['required', 'unique:clients'],
                'birthdate' => ['required'],
                'phone' => ['required'],
            ], ['cpf.unique' => 'CPF already registered.']);

            $userCollection
                ->client()
                ->create($validated);

            $userCollection->client->cart;

            return response()->json([
                'created' => true,
                'data' => $userCollection->toArray(),
                'auth_token' => $userCollection->createToken('auth')->plainTextToken,
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $th) {
            return response()->json(['Errors' => $th->errors()], 400);
        }
    }


    public function createUser(Request $req)
    {
        $validatedUserData = $req->validate([
            'name' =>  ['required'],
            'email' => ['required', 'unique:users', 'email'],
            'password' => ['required'],
        ]);

        $validatedUserData['password'] = Hash::make($validatedUserData['password']);

        return User::query()->create($validatedUserData);
    }
}

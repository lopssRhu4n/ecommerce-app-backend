<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class ClientController extends BaseController
{


    public function store(Request $req): JsonResponse
    {
        try {
            $validated = $req->validate([
                'name' =>  ['required'],
                'email' => ['required', 'unique:clients', 'email'],
                'cpf' => ['required', 'unique:clients'],
                'birthdate' => ['required'],
                'phone' => ['required'],
            ], [ 'cpf.unique' => 'CPF already registered.']);

            Client::query()->create(
                [
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'cpf' => $validated['cpf'],
                    'birthdate' => $validated['birthdate'],
                    'phone' => $validated['phone']
                ]
            );

            return response()->json(['created' => true], 201);
        } catch (\Illuminate\Validation\ValidationException $th) {
            return response()->json(['Errors' => $th->errors()], 400);
        }
    }


    public function show(string $id): JsonResponse
    {
        try {
            $client = Client::findOrFail($id);
            return response()->json(['Client' => $client]);
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th], 400);
        }
    }
}

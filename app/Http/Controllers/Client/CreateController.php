<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
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

            $clientData = Client::query()->create(
                [
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'cpf' => $validated['cpf'],
                    'birthdate' => $validated['birthdate'],
                    'phone' => $validated['phone']
                ]
            )->toArray();

            return response()->json(['created' => true, 'client' => $clientData], 201);
        } catch (\Illuminate\Validation\ValidationException $th) {
            return response()->json(['Errors' => $th->errors()], 400);
        }
    }
}

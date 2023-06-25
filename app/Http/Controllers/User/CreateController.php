<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class CreateController extends Controller
{
    public function __invoke(Request $req)
    {

        try {
            $validated = $req->validate([
                'name' => 'required|string',
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $userData = User::query()->create($validated)->toArray();

            return response()->json(['created' => true, 'user' => $userData], 201);
        } catch (\Illuminate\Validation\ValidationException $th) {
            return response()->json(['Errors' => $th->errors()], 400);
        }
    }
}

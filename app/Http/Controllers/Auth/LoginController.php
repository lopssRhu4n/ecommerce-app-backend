<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{

    public function __invoke(Request $req)
    {
        try {
            $credentials = $req->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            $user = User::query()->where('email', $credentials['email'])->first();


            if (!isset($user)) {
                throw ValidationException::withMessages(['user' => 'User not found!']);
            }

            if (!Hash::check($credentials['password'], $user->password)) {
                throw ValidationException::withMessages(['password' => "Passwords don't match!"]);
            }

            $clientData = Client::query()->find($user->id);
            $cartData = $clientData->cart;
            $cartData->products;

            return response()->json(
                [
                    'auth_token' => $user->createToken('auth')->plainTextToken,
                    'client' => $clientData,
                ], 200);
        } catch (\Throwable $err) {
            return response()->json(['Error' => $err->getMessage()], 404);
        }
    }
}

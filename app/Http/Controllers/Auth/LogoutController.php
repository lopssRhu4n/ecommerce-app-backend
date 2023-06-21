<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function __invoke(Request $req)
    {
        try {
            $token = $req->user()->currentAccessToken();


            $token->delete();

            return response()->json(['message' => 'Token was deleted successfully.'], 201);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], $th->getCode());
        }
    }
}

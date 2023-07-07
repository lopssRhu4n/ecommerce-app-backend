<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    public function __invoke(int $id, Request $req)
    {

        try {

            if($id != auth('sanctum')->user()->id){
                return response()->json(['message' => 'Unauthorized.'], 403);
            }

            $user = User::query()->findOrFail($id);
            $user->client->cart->products;
            return response()->json($user->toArray());    //code...

        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], $th->getCode());
        }


    }

}

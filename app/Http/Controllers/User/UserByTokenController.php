<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserByTokenController extends Controller
{
    public function __invoke()
    {
        request()->user()->client->cart->products;

        return response()->json(request()->user());
    }

}

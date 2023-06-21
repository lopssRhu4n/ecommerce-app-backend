<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ShowController extends Controller
{

    public function __invoke(int $id) {

        try {
            $client = Client::query()->where('id', $id)->first();

            return response()->json($client);
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th->getMessage()], $th->getCode());
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function data(){
        return response()->json([
            "clients"=>Client::all(),
            "nb_clients"=>Client::count()
        ]);
    }
}

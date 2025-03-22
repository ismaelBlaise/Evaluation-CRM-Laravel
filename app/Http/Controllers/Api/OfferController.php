<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function data(){
        return response()->json([
            "offers"=>Offer::all(),
            "nb_offers"=>Offer::count()
        ]);
    }
}

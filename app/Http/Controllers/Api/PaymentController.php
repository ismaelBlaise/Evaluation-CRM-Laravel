<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function data(){
        return response()->json([
            "payments"=>Payment::all(),
            "nb_payments"=>Payment::count()
        ]);
    }
}

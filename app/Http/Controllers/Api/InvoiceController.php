<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function data(){
        return response()->json([
            "invoices"=>Invoice::all(),
            "nb_invoices"=>Invoice::count()
        ]);
    }
}

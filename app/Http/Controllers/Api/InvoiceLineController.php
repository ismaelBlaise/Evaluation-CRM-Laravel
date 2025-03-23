<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InvoiceLine;
use Illuminate\Http\Request;

class InvoiceLineController extends Controller
{
    public function data(){
        return response()->json([
            "invoice_lines"=>InvoiceLine::all(),
            "nb_invoice_lines"=>InvoiceLine::count()
        ]);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function data(Request $request)
    {
        // Récupérer le nombre d'éléments par page (10 par défaut)
        $perPage = $request->query('per_page', 10);

        // Retourner les paiements avec pagination
        return response()->json(Payment::paginate($perPage));
    }

    public function nbdata()
    {
        return response()->json([
            "nb_payments" => Payment::count()
        ]);
    }
}

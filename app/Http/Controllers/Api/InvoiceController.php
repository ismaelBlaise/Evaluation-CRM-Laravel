<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Services\Invoice\InvoiceCalculator;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function data(Request $request)
    {
        // Récupérer le nombre d'éléments par page (10 par défaut)
        $perPage = $request->query('per_page', 10);

        return response()->json(Invoice::paginate($perPage));
    }

    public function nbdata()
    {
        return response()->json([
            "nb_invoices" => Invoice::count()
        ]);
    }

    public function invoicePaymentSummary()
    {
        $totalPaid = 0;
        $totalUnpaid = 0;

        
        
        $invoices = Invoice::all();

        foreach ($invoices as $invoice) {
            $invoiceCalculator = new InvoiceCalculator($invoice);
            $amountDue = $invoiceCalculator->getAmountDue(); 
            $totalPayments = $invoice->payments()->sum('amount');  

            if ($amountDue->getBigDecimalAmount() == 0) {
                $totalPaid += $totalPayments;  
            } else {
                $totalUnpaid += $amountDue->getBigDecimalAmount(); 
            }
        }

        return response()->json([
            'total_paid' => $totalPaid,
            'total_unpaid' => $totalUnpaid,
        ]);
    }


}

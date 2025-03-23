<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function data(Request $request)
    {
        
        $perPage = $request->query('per_page', 10);

        return response()->json(Payment::paginate($perPage));
    }

    public function nbdata()
    {
        return response()->json([
            "nb_payments" => Payment::count()
        ]);
    }



    public function monthlyRevenueChart()
    {
        $currentDate = Carbon::now();

        $months = [];
        $revenues = [];

      
        for ($i = 0; $i < 12; $i++) {
            
            $monthStart = $currentDate->copy()->startOfMonth();  
            $monthEnd = $currentDate->copy()->endOfMonth();  

             
            $months[] = $monthStart->format('F Y');  

            $revenue = Payment::whereBetween('payment_date', [$monthStart, $monthEnd])
                            ->sum('amount');   

            $revenues[] = $revenue;

            $currentDate->subMonth();
        }

        return response()->json([
            'months' => $months,
            'revenues' => $revenues
        ]);
    }


}

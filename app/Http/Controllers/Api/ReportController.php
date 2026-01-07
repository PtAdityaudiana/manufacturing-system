<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\ProductionOrder;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function production(Request $request)
    {
        $start = $request->start_date;
        $end   = $request->end_date;

        $productions = collect();
        $totalHarga = 0;

        if ($start && $end) {
            $productions = ProductionOrder::with('product')
                ->whereBetween('production_date', [$start, $end])
                ->orderBy('production_date')
                ->get();

            $totalHarga = $productions->sum(function ($prod) {
                return $prod->qty * $prod->product->price;
            });
        }

        return response()->json([
            'productions' => $productions,
            'total_harga' => $totalHarga
        ]);
    }

    public function productionbyId($id){
        $production = ProductionOrder::with('product')->find($id);
        if(!$production){
            return response()->json([
                'message' => 'Production order not found'
            ], 404);
        }
        $totalHarga = $production->qty * $production->product->price;

        return response()->json([
            'production' => $production,
            'total_harga' => $totalHarga
        ]);
    }
}
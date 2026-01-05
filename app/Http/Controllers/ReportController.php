<?php
namespace App\Http\Controllers;

use App\Models\ProductionOrder;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
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

        return view('operator.report', compact(
            'productions',
            'start',
            'end',
            'totalHarga'
        ));
    }
}

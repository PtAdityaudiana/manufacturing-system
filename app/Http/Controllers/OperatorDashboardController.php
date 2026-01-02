<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductionOrder;
use Illuminate\Support\Facades\DB;


class OperatorDashboardController extends Controller
{
    public function index()
    {
        $todayProduction = ProductionOrder::whereDate('production_date', today())
            ->sum('qty');

        $recentProductions = ProductionOrder::with('product')
            ->latest()
            ->take(5)
            ->get();

        $topProducts = ProductionOrder::select(
                'product_id',
                DB::raw('SUM(qty) as total')
            )
            ->groupBy('product_id')
            ->orderByDesc('total')
            ->with('product')
            ->take(5)
            ->get();

        return view('operator.dashboard', compact(
            'todayProduction',
            'recentProductions',
            'topProducts'
        ));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductionOrder;
use Illuminate\Support\Facades\DB;
use App\Models\RawMaterial;


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

         // total stok
        $materials = RawMaterial::all();

        return view('operator.dashboard', compact(
            'todayProduction',
            'recentProductions',
            'materials'
        ));
    }
}

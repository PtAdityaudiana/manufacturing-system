<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\RawMaterial;
use App\Models\ProductionOrder;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalMaterials = RawMaterial::count();
     
        $totalProductionThisMonth = ProductionOrder::whereMonth('production_date', now()->month)
            ->whereYear('production_date', now()->year)
            ->sum('qty');

        $productionChart = ProductionOrder::select(
                DB::raw('MONTH(production_date) as month'),
                DB::raw('SUM(qty) as total')
            )
            ->whereYear('production_date', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $lowStockMaterials = RawMaterial::all()->filter(function ($material) {
            $in = $material->stockMovements()->in()->sum('qty');
            $out = $material->stockMovements()->out()->sum('qty');
            return ($in - $out) < 10;
        });

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalMaterials',
            'totalProductionThisMonth',
            'productionChart',
            'lowStockMaterials'
        ));
    }
}

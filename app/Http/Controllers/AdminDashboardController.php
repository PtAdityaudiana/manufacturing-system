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

         // low stock
         $lowStockMaterials = RawMaterial::all()
         ->filter(fn ($material) => $material->stock < 10);

         // total stok
         $materials = RawMaterial::all();

         $topProducts = ProductionOrder::select(
            'product_id',
            DB::raw('SUM(qty) as total')
        )
        ->groupBy('product_id')
        ->orderByDesc('total')
        ->with('product')
        ->take(5)
        ->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalMaterials',
            'totalProductionThisMonth',
            'productionChart',
            'lowStockMaterials',
            'materials',
            'topProducts'
        ));
    }
}

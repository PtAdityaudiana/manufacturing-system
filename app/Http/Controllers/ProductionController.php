<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Bom;
use App\Models\ProductionOrder;
use App\Models\StockMovement;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductionController extends Controller
{
    public function index(){
        $productions = ProductionOrder::with('product')
        ->latest()
        ->paginate(10);

        return view('production.index', compact('productions'));
    }

    public function create(){
        $products = Product::all();

        $selectedProduct = null;

        if (request('product_id')) {
            $selectedProduct = Product::with('boms.rawMaterial')
                ->find(request('product_id'));
        }
    
        return view('production.create', compact(
            'products',
            'selectedProduct'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer|min:1',
            'production_date' => 'required|date',
        ]);

        try {
            DB::transaction(function () use ($request) {

                $product = Product::with('boms.rawMaterial')
                    ->findOrFail($request->product_id);

                $qtyProduction = $request->qty;

                // cek stok bahan baku
                foreach ($product->boms as $bom) {
                    $material = $bom->rawMaterial;
                    $requiredQty = $bom->qty_required * $qtyProduction;

                    $stockIn = $material->stockMovements()->in()->sum('qty');
                    $stockOut = $material->stockMovements()->out()->sum('qty');
                    $currentStock = $stockIn - $stockOut;

                    if ($currentStock < $requiredQty) {
                        throw new \Exception(
                            "Stok {$material->name} tidak mencukupi. Dibutuhkan {$requiredQty}, tersedia {$currentStock}"
                        );
                    }
                }

                // simpan order
                $production = ProductionOrder::create([
                    'product_id' => $product->id,
                    'qty' => $qtyProduction,
                    'production_date' => $request->production_date
                ]);

                // kurangi stok bahan baku
                foreach ($product->boms as $bom) {
                    $material = $bom->rawMaterial;
                    $usedQty = $bom->qty_required * $qtyProduction;

                    StockMovement::create([
                        'item_type' => 'raw_material',
                        'item_id' => $material->id,
                        'movement_type' => 'out',
                        'qty' => $usedQty,
                        'description' => "Pemakaian {$material->name} untuk produksi {$product->name} ({$qtyProduction})"
                    ]);
                }
                // tambah stok produk jadi
                StockMovement::create([
                    'item_type' => 'product',
                    'item_id' => $product->id,
                    'movement_type' => 'in',
                    'qty' => $qtyProduction,
                    'description' => "Hasil produksi {$product->name} ({$qtyProduction})"
                ]);

                ActivityLog::create([
                    'user_id' => auth()->id(),
                    'action' => 'CREATE',
                    'description' => "Membuat order produksi #{$production->id} untuk produk {$product->name} sebanyak {$qtyProduction} unit"
                ]);
            });

        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => $e->getMessage()
            ])->withInput();
        }

        return redirect()
            ->route('production.index')
            ->with('success', 'Order produksi berhasil dibuat dan stok diperbarui.');
    }


}

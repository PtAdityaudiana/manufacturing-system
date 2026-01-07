<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Bom;
use App\Models\ProductionOrder;
use App\Models\StockMovement;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class ProductionController extends Controller
{
    public function index()
    {
        return response()->json(
            ProductionOrder::with('product')->latest()->get()
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|numeric|min:1',
            'production_date' => 'required|date'
        ]);

        $product = Product::with('boms.rawMaterial')->find($data['product_id']);

        foreach ($product->boms as $bom) {
            $need = $bom->qty_required * $data['qty'];

            if ($bom->rawMaterial->stock < $need) {
                return response()->json([
                    'status' => 'false',
                    'message' => 'Stok bahan tidak cukup: ' . $bom->rawMaterial->name
                ], 422);
            }
        }

        DB::transaction(function () use ($product, $data) {
            ProductionOrder::create($data);

            foreach ($product->boms as $bom) {
                StockMovement::create([
                    'item_type' => 'raw_material',
                    'item_id' => $bom->rawMaterial->id,
                    'type' => 'out',
                    'qty' => $bom->qty_required * $data['qty']
                ]);
            }
        });

        return response()->json([
            'status' => 'true',
            'message' => 'Produksi berhasil',
            'data' => $data
        ]);
    }

    public function show($id)
    {
        $production = ProductionOrder::with('product')->find($id);

        if (!$production) {
            return response()->json([
                'status' => 'false',
                'message' => 'Data produksi tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'true',
            'message' => 'Data produksi ditemukan',
            'data' => $production
        ]);
    }

    public function showUser($id){
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'false',
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'status' => 'true',
            'message' => 'Operator ditemukan',
            'data' => $user
        ]);
    }

    public function rawMaterialStock(Request $request, RawMaterial $material)
    {
        $request->validate([
            'type' => 'required|in:in,out',
            'qty' => 'required|integer|min:1',
            'description' => 'nullable'
        ]);

        if ($request->type === 'out' && $material->stock < $request->qty) {
            return back()->withErrors('Stok tidak mencukupi');
        }

        StockMovement::create([
            'item_type' => 'raw_material',
            'item_id' => $material->id,
            'movement_type' => $request->type,
            'qty' => $request->qty,
            'description' => $request->description ?? 'Penyesuaian stok'
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'UPDATE',
            'description' => ($request->type === 'in' ? 'Menambah' : 'Mengurangi') .
                " stok bahan baku: {$material->name} sebanyak {$request->qty}"
        ]);

        return response()->json([
            'status' => 'true',
            'message' => 'Stok berhasil diperbarui',
            'data' => $material
        ]);
    }
}

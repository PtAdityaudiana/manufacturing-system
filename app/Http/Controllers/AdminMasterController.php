<?php

namespace App\Http\Controllers;

use App\Models\RawMaterial;
use App\Models\Product;
use App\Models\ActivityLog;
use App\Models\Bom;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminMasterController extends Controller
{
    //raw material
    public function rawMaterialIndex()
    {
        $materials = RawMaterial::all();
        $lowStockMaterials = RawMaterial::all()
        ->filter(fn ($material) => $material->stock < 30);
        return view('admin.raw-materials.index', compact('materials', 'lowStockMaterials'));
    }

    public function rawMaterialCreate()
    {
        return view('admin.raw-materials.create');
    }

    public function rawMaterialStore(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'unit' => 'required',
            'price' => 'required|numeric'
        ]);

        RawMaterial::create($request->only('name', 'unit', 'price'));

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'CREATE',
            'description' => "Menambahkan bahan baku: {$request->name}"
        ]);

        return redirect()->route('admin.raw-materials.index')
            ->with('success', 'Bahan baku berhasil ditambahkan');
    }


    public function rawMaterialStock(Request $request, RawMaterial $material)
    {
        $request->validate([
            'type' => 'required|in:in,out',
            'qty' => 'required|integer|min:1',
            'description' => 'nullable'
        ]);

        // validasi stok saat out
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

        return back()->with('success', 'Stok berhasil diperbarui');
    }


    //prod adn bom
    public function productIndex()
    {
        $products = Product::with('boms.rawMaterial')->get();
        return view('admin.products', compact('products'));
    }

    public function productCreate()
    {
        $materials = RawMaterial::all();
        $products = Product::all();
        return view('admin.products.create', compact('materials', 'products'));
    }

    public function productStore(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'materials' => 'required|array'
        ]);

        DB::transaction(function () use ($request) {

            $product = Product::create([
                'name' => $request->name,
                'price' => $request->price
            ]);

            foreach ($request->materials as $materialId => $qty) {
                if ($qty > 0) {
                    Bom::create([
                        'product_id' => $product->id,
                        'raw_material_id' => $materialId,
                        'qty_required' => $qty
                    ]);
                }
            }
        });

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'CREATE',
            'description' => "Menambahkan produk: {$request->name} beserta BOM"
        ]);

        return redirect()->route('admin.products')
            ->with('success', 'Produk & BOM berhasil dibuat');
    }
}

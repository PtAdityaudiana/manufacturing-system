<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Bom;
use App\Models\Product;
use App\Models\RawMaterial;

class BomSeeder extends Seeder
{
    public function run(): void
    {
        $meja = Product::where('name', 'Meja')->first();
        $kursi = Product::where('name', 'Kursi')->first();

        $kayu = RawMaterial::where('name', 'Kayu')->first();
        $baut = RawMaterial::where('name', 'Baut')->first();
        $cat  = RawMaterial::where('name', 'Cat')->first();

        
        Bom::create([
            'product_id' => $meja->id,
            'raw_material_id' => $kayu->id,
            'qty_required' => 2
        ]);

        Bom::create([
            'product_id' => $meja->id,
            'raw_material_id' => $baut->id,
            'qty_required' => 10
        ]);

        
        Bom::create([
            'product_id' => $kursi->id,
            'raw_material_id' => $kayu->id,
            'qty_required' => 1
        ]);

        Bom::create([
            'product_id' => $kursi->id,
            'raw_material_id' => $baut->id,
            'qty_required' => 8
        ]);

        Bom::create([
            'product_id' => $kursi->id,
            'raw_material_id' => $cat->id,
            'qty_required' => 1
        ]);
    }
}

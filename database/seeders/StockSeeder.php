<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RawMaterial;
use App\Models\StockMovement;

class StockSeeder extends Seeder
{

    public function run(): void
    {
        $materials = RawMaterial::all();

        foreach ($materials as $material) {
            StockMovement::create([
                'item_type' => 'raw_material',
                'item_id' => $material->id,
                'movement_type' => 'in',
                'qty' => 100,
                'description' => 'Stok awal'
            ]);
        }
    }
}

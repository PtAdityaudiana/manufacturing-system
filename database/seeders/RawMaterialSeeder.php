<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RawMaterial;

class RawMaterialSeeder extends Seeder
{
    public function run(): void
    {
        RawMaterial::insert([
            [
                'name' => 'Kayu',
                'unit' => 'Papan',
                'price' => 50000
            ],
            [
                'name' => 'Baut',
                'unit' => 'Pcs',
                'price' => 500
            ],
            [
                'name' => 'Cat',
                'unit' => 'Kaleng',
                'price' => 75000
            ]
        ]);
    }
}

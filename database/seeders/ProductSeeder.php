<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::insert([
            [
                'name' => 'Meja',
                'price' => 750000
            ],
            [
                'name' => 'Kursi',
                'price' => 350000
            ]
        ]);
    }
}

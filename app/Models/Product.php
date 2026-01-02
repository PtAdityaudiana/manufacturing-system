<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'price'
    ];

    public function boms(){
        return $this->hasMany(Bom::class);
    }

    public function productionOrders(){
        return $this->hasMany(ProductionOrder::class);
    }

    public function stockMovements(){
        return $this->hasMany(StockMovement::class, 'item_id')
                    ->where('item_type', 'product');
    }
}

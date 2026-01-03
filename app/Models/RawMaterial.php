<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RawMaterial extends Model
{
    protected $fillable = [
        'name',
        'unit',
        'price'
    ];

    protected $appends = ['stock'];

   public function boms(){
        return $this->hasMany(Bom::class);
   }

   public function materialIns(){
        return $this->hasMany(MaterialIn::class);
   }

   public function stockMovements(){
        return $this->hasMany(StockMovement::class, 'item_id')
                    ->where('item_type', 'raw_material');
   }

   public function getStockAttribute()
    {
        $in = $this->stockMovements()
            ->where('movement_type', 'in')
            ->sum('qty');

        $out = $this->stockMovements()
            ->where('movement_type', 'out')
            ->sum('qty');

        return $in - $out;
    }
}

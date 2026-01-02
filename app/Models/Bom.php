<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bom extends Model
{
    protected $fillable = [
        'product_id',
        'raw_material_id',
        'qty_required'
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function rawMaterial(){
        return $this->belongsTo(RawMaterial::class);
    }
}

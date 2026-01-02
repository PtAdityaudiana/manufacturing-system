<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductionOrder extends Model
{
    protected $fillable = [
        'product_id',
        'qty',
        'production_date'
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }
}

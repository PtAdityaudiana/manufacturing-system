<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    protected $fillable = [
        'item_type',
        'item_id',
        'movement_type',
        'qty',
        'description'
    ];

    public function scopeIn($query)
    {
        return $query->where('movement_type', 'in');
    }

    public function scopeOut($query)
    {
        return $query->where('movement_type', 'out');
    }
}

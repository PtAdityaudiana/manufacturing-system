<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialIn extends Model
{
    protected $fillable = [
        'raw_material_id',
        'qty',
        'date'
    ];

    public function rawMaterial(){
        return $this->belongsTo(RawMaterial::class);
    }
}

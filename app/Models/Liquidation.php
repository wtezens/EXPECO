<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Liquidation extends Model
{
    protected $fillable = [
        'id',
        'correlativo',
        'agency_id',
        'fecha_pago',
    ];

    public function credits(){
        return $this->hasMany('App\Models\Credit');
    }
}

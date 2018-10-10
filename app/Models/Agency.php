<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{

    protected $fillable=[
      'nombre','direccion'
    ];
    /**
     * Cada credito que posee un asociado
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function credits(){
        return $this->hasMany('\App\Models\Credit');
    }
}

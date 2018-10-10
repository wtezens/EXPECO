<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    public $incrementing = false;

    protected $fillable = [
        'id',
        'nombre',
        'cuenta',
        'user_id'
    ];

    /**
     * Cada credito que posee un asociado
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function credits(){
        return $this->hasMany('\App\Models\Credit');
    }

    public function listOfCredits(){
        return $this->credits();
    }
}

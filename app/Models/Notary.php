<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Notary extends Authenticatable
{
    use Notifiable;

    /**
     * @var array
     */
    protected $hidden = ['password', 'remember_token','session_id'];


    /**
     * @var array
     */
    protected $fillable = [
        'nombre', 'email','telefono','direccion','password','estado', 'creado_por'
    ];


    public function credits(){
        return $this->hasMany('\App\Models\Credit');
    }
}

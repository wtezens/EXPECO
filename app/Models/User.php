<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * @var array
     */
    protected $fillable = [
        'usuario', 'nombres', 'apellidos', 'password','estado'
    ];

    /**
     * @var array
     */
    protected $hidden = ['password','remember_token','session_id','estado'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTos
     */
    public function agency(){
        return $this->belongsTo('\App\Models\Agency');
    }


    public function role(){
        return $this->belongsTo('\App\Models\Role');
    }

    public function hasRole(){
        $role=$this->role();

        foreach($role as $name)
        {
            return $name->nombre;
        }
    }
}

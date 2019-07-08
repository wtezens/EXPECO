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


    /**
     * Evaluamos si un usuario posee alguno de los roles enviados en el array
     * @param array $roles
     * @return bool
     */
    public function hasRole(array $roles){
        foreach ($roles as $role){
            if ($this->role->nombre === $role){
                return true;
            }
        }
        return false;
    }
}

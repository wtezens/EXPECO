<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advance extends Model
{
    protected $fillable = [
        'user_id', 'credit_id','clave','cantidad'
    ];

    protected $hidden = [
        'user_id',
        'clave'
    ];

}

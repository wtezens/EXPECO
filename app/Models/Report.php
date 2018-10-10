<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function credits(){
        return $this->belongsToMany('\App\Models\Credit')
            ->withPivot('correlativo')
            ->withTimestamps();
    }
}

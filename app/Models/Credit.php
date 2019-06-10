<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    /*public $incrementing = false;*/

    protected $fillable = [
        'credito_id',
        'partner_id',
        'agency_id',
        'notary_id',
        'liquidation_id',
        'cuenta',
        'monto_credito',
        'monto_ampliacion',
        'monto_cobrado',
        'cantidad_contratos',
        'cantidad_escrituras',
        'tipo_desembolso',
        'tipo_garantia',
        'observaciones',
        'numero_escritura',
        'fecha_escritura',
        'rechazo',
        'timbre_notarial',
        'gasto_papeleria',
        'consulta_electronica',
        'honorario_notario',
        'honorario_registro',
        'diferencia',
        'ajuste_liquidacion',
        'user_id',
        'nuevo'
    ];


    public function agency(){
        return $this->belongsTo('\App\Models\Agency');
    }

    public function notary(){
        return $this->belongsTo('\App\Models\Notary');
    }

    /**
     * Cada uno de los estatus del credito
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function statuses(){
        return $this->belongsToMany('\App\Models\Status')
            ->withTimestamps();
    }

    /**
     * Cada uno de los envios del credito
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function reports(){
        return $this->belongsToMany('\App\Models\Report')
            ->withPivot('correlativo')
            ->withTimestamps();
    }

    /**
     * El respectivo asociado propietario del credito
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function partner(){
        return $this->belongsTo('\App\Models\Partner');
    }

    /**
     * La respectiva liquidación a la que pertenece el credito
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function liquidation(){
        return $this->belongsTo('\App\Models\Liquidation');
    }

    public function advance(){
        return $this->hasOne('\App\Models\Advance');
    }
}

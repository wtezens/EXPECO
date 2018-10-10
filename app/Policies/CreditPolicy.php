<?php

namespace App\Policies;

use App\Models\Credit;
use App\Models\Notary;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CreditPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * @param User $user
     * @param Credit $credit
     * @return bool
     * El colaborador puede actualizar los registros de su respectiva agencia
     */
    public function same_agency(User $user, Credit $credit){
        return $user->agency_id == $credit->agency_id;
    }

    /**
     * @param Notary $notary
     * @param Credit $credit
     * @return bool
     * El notario solo puede actualizar los registros que tiene asignados
     */
    public function assigned(Notary $notary, Credit $credit){
        return $notary->id == $credit->notary_id;
    }


    public function gerencia(User $user,Credit $credit){

        $role = \App\Models\Role::where('id', $user->role_id)->first();

        if($role->nombre=='secretary_of_management'){
            return true;
        }else{
            return false;
        }
    }

    public function jefeAgencia(User $user,Credit $credit){

        $role = \App\Models\Role::where('id', $user->role_id)->first();

        if($role->nombre=='agency_leader'){
            return true;
        }else{
            return false;
        }
    }

    public function contabilidad(User $user, Credit $credit){
        $role = \App\Models\Role::where('id', $user->role_id)->first();

        if($role->nombre=='assistant_accounting'){
            return true;
        }else{
            return false;
        }
    }
}

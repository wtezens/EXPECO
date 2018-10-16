<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        /*if (Auth::guard($guard)->check()) {
            return redirect('/home');
        }*/

        switch ($guard) {
            case 'colaborador':
                if (Auth::guard($guard)->check()) {
                    $role = auth('colaborador')->user()->role()->first();
                    switch ($role->nombre){
                        case 'technical_support':
                            return redirect('/soporte/panel');
                            break;
                        case 'credit_secretary':
                            return redirect('/creditos/panel');
                            break;
                        case 'credit_assistant':
                            return redirect('/asistente/panel');
                            break;
                        case 'assistant_accounting':
                            return redirect('/contabilidad/panel');
                            break;
                        case 'secretary_of_management':
                            return redirect('/gerencia/panel');
                            break;
                        case 'agency_leader':
                            return redirect('/agencias/jefes');
                            break;
                        default:
                            return redirect('/gerentes/panel');
                            break;
                    }
                }
                break;

            default:
                if (Auth::guard($guard)->check()) {
                    return redirect('/notario/panel');
                }
                break;
        }
        return $next($request);
    }
}

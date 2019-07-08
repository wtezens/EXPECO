<?php

namespace App\Http\Controllers\Gerentes;

use Auth;
use App\Models\Advance;
use App\Http\Controllers\Controller;
use App\Http\Requests\NewAnticipoRequest;
use Illuminate\Http\Request;

class GerentesController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:colaborador','role:general_manager']);
    }

    public function home(){
        return view('dashboards.gerentes')->with('PageTitle','Gerencia');
    }


    /**
     * Crear nuevo anticipo
     * @param NewAnticipoRequest $request
     * @return int
     */
    public function store(NewAnticipoRequest $request){
        try{
            $anticipo = Advance::create([
                'user_id'=>session('id'),
                'clave'=>bcrypt($request->clave),
            ]);

            if(request()->wantsJson()){
                return array('estatus'=>'ok','anticipo'=>$anticipo);
            }
        }
        catch (\Illuminate\Database\QueryException $e){
            $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                if(request()->wantsJson()){
                    return array('estatus'=>'duplicate key');
                }
            }else if($error_code==1366){
                if(request()->wantsJson()){
                    return array('estatus'=>'incorrect type value');
                }
            }
            else{
                if(request()->wantsJson()){
                    return $e;
                }
            }
        }
        catch (\Exception $e){
            if(request()->wantsJson()){
                return $e;
            }
        }
    }

    public function show(){
        return Advance::where('user_id',session('id'))->get();
    }
}

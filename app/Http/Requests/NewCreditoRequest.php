<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewCreditoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * validaciones para ingresar un nuevo credito
     * @actor Creditos
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //'expediente'        => 'required|numeric|unique:creditos,idexpediente',
            'expediente'        => 'min:3|max:10',
            'cif'               => 'required|numeric',
            'cif'               => 'min:3|max:6',
            'notario'           => 'required|numeric',
            'montoCredito'      => 'required|numeric',
            'montoAmpliacion'   => 'required|numeric',
            'gastosCobrados'    => 'required|numeric',
            'contratos'         => 'required|numeric',
            'escrituras'        => 'required|numeric',
            'desembolso'        => 'required|string',
            'garantia'          => 'required|string',
            'nuevo'             => 'boolean'
        ];
    }
}
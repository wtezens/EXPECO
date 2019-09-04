<?php

namespace App\Http\Requests\Historicos;

use Illuminate\Foundation\Http\FormRequest;

class HistoricosRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'notario' => 'required|numeric',
            'agencia' => 'required|numeric',
            'credito' => 'nullable|numeric|unique:credits,credito_id',
            'cif'     => 'nullable|numeric|unique:partners,id',
            'cif'     => 'min:3|max:6',
            'cuenta_ahorro' => 'nullable|numeric|unique:partners,cuenta',
            'cuenta_ahorro' => 'nullable|min:9|max:10',
            'monto_prestamo' => 'nullable|numeric',
            'monto_ampliacion' => 'nullable|numeric',
            'gasto_cobrado' => 'nullable|numeric',
            'contratos' => 'nullable|numeric',
            'escrituras' => 'nullable|numeric',
            'registrado' => 'nullable|string',
            'desembolso' => 'nullable|string',
            'numero_de_escritura' => 'nullable|numeric',
            'fecha_de_escrituracion' => 'date|nullable',
            'timbre_notarial' => 'nullable|numeric',
            'gasto_papeleria' => 'nullable|numeric',
            'consulta_electronica' => 'nullable|numeric',
            'honorario_notario' => 'nullable|numeric',
            'honorario_registro' => 'nullable|numeric',
            'diferencia' => 'nullable|numeric',
            'ajuste_liquidacion' => 'nullable|numeric',
            'fecha_creacion' => 'nullable|date',
            'estatus_1' => 'nullable|date',
            'estatus_2' => 'nullable|date',
            'estatus_3' => 'nullable|date',
            'estatus_4' => 'nullable|date',
            'estatus_5' => 'nullable|date',
            'estatus_6' => 'nullable|date',
            'estatus_7' => 'nullable|date',
            'estatus_8' => 'nullable|date',
            'estatus_9' => 'nullable|date',
            'estatus_10' => 'nullable|date',

            'cantidad_anticipo' => 'nullable|numeric'
        ];
    }
}

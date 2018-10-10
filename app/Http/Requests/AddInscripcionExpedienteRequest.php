<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddInscripcionExpedienteRequest extends FormRequest
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
     * Validaciones para añadir Inscripción del Expediente Gastos
     * @actor Notarios
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'consultas'=>'required|numeric',
            'monto_registro'=>'required|numeric',
            'diferencia'=>'required|numeric'
        ];
    }
}

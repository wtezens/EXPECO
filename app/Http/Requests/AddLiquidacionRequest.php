<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddLiquidacionRequest extends FormRequest
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
     * reglas de validacion expedientes a liquidar
     * @actor Notarios
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'datos'=>'required|array',
            'datos.*'=>'numeric',
            'agencia'=>'required|numeric',
            'liquidacion'=>'required|numeric'
        ];
    }
}

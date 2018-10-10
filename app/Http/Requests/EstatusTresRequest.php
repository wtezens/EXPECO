<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EstatusTresRequest extends FormRequest
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
     * validación añadir estatus tres envio a revision
     * @actor Notarios
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'escritura'=>'required|numeric',
            'fecha_escritura'=>'required|date'
        ];
    }
}

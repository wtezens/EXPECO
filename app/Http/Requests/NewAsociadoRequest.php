<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewAsociadoRequest extends FormRequest
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
     * validaciones para crear un nuevo asociado
     * @actor Soporte || Creditos
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'asociado.cif'   => 'required|numeric|unique:partners,id',
            'asociado.cif'   => 'min:3|max:6',
            'asociado.nombre'=> 'required|string|max:65',
            'asociado.cuenta'=> 'numeric|unique:partners,cuenta',
            'asociado.cuenta'=> 'min:9|max:10',
            'asociado.sin_cuenta'=>'boolean'
        ];
    }
}

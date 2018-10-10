<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddDesembolsoRequest extends FormRequest
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
     * Validaciones para añadir desembolsos
     * @actor Creditos
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'credito'=>'required|numeric|unique:credits,credito_id',
            'fecha'=>'required|date',
            'gastos'=>'required|numeric',
            'honorarios'=>'required|numeric',
            'timbres'=>'required|numeric'
        ];
    }
}

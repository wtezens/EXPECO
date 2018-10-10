<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewAnticipoRequest extends FormRequest
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
     * Generar una nueva autorización de anticipo
     * @actor Gerente General || Gerente Financiero
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'clave'=>'required|string|max:30'
        ];
    }
}

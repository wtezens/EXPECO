<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCreditoCuentaRequest extends FormRequest
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
     * validaciones para ingreso de numero de cuenta
     * @actor Soporte || Creditos
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cuenta'=>'required|numeric|unique:partners,cuenta',
            'cuenta'=>'min:9|max:10'
        ];
    }
}

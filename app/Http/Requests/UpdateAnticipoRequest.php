<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAnticipoRequest extends FormRequest
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
            'clave'         => 'required|string|max:30',
            'expediente'    => 'required|numeric',
            'expediente'    => 'min:1|max:10',
            'monto'         => 'required|numeric'
        ];
    }
}

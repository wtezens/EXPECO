<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewNotaryRequest extends FormRequest
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
                'email'     => 'required|email',
                'nombre'    => 'required|string|min:2|max:30',
                'password'  => 'required|string|min:6|',
                'direccion' => 'required|string',
                'telefono'  => 'required|string'
        ];
    }
}

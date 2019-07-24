<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewUserRequest extends FormRequest
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
               'nombre'    => 'required|string|min:2|max:25',
               'apellido'  => 'required|string|min:2|max:25',
               'role'      => 'required|numeric',
               'password'  => 'required|string|min:6|'
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddRechazoExpediente extends FormRequest
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
     * validaciones para ingreso de razón de rechazo
     * @actor Notarios
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'rechazo'=>'required|string|min:10|max:200'
        ];
    }
}

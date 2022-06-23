<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDetingcamaraRequest extends FormRequest
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
            'trazabilidad_id' => 'required',
            'dettrazabilidad_id' => 'required',
            'peso' => 'required',
            'cantidad' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'trazabilidad_id.required' => 'Seleccione Producto.',
    		'dettrazabilidad_id.required' => 'Seleccione Clasificación.',
    		'peso.required' => 'Ingrese Peso.',
    		'cantidad.required' => 'Ingrese Cantidad.',
        ];
    }
}

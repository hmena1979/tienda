<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDetenvasadoRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'trazabilidad_id' => 'required',
            'dettrazabilidad_id' => 'required',
            'peso' => 'required',
            'cantidad' => 'required',
            'equipoenvasado_id' => 'required',
            'hora' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'trazabilidad_id.required' => 'Seleccione Producto.',
    		'dettrazabilidad_id.required' => 'Seleccione Clasificación.',
    		'peso.required' => 'Ingrese Peso.',
    		'cantidad.required' => 'Ingrese Cantidad.',
    		'equipoenvasado_id.required' => 'Seleccione Equipo de envasado.',
    		'hora.required' => 'Ingrese Hora de carga.',
        ];
    }
}

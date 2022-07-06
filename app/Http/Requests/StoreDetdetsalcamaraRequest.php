<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDetdetsalcamaraRequest extends FormRequest
{
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
            'productoterminado_id' => 'required',
            'cantidad' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'productoterminado_id.required' => 'Seleccione Lote.',
    		'cantidad.required' => 'Ingrese Cantidad.',
        ];
    }
}

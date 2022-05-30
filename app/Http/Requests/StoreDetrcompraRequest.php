<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDetrcompraRequest extends FormRequest
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
                'detdestino_id' => 'required',
                // 'ccosto_id' => 'required',
                'monto' => 'required',
            ];
    }

    public function messages()
    {
        return [
            'detdestino_id.required' => 'Ingrese Detalle de Destino.',
    		'ccosto_id.required' => 'Ingrese Centro de Costo.',
    		'monto.required' => 'Ingrese Monto.',
        ];
    }
}

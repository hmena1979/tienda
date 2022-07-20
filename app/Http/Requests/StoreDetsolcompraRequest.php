<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDetsolcompraRequest extends FormRequest
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
            'producto_id' => 'required',
            'cantidad' => 'required',
            // 'glosa' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'producto_id.required' => 'Seleccione Producto.',
            'cantidad.required' => 'Ingrese Cantidad.',
            // 'glosa.required' => 'Ingrese Glosa.',
        ];
    }
}

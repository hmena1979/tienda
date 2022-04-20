<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreConsumoRequest extends FormRequest
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
            'destino_id' => 'required',
            'detdestino_id' => 'required',
            'ccosto_id' => 'required',
            'fecha' => 'required',
            'tc' => 'required',
            'detalle' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'destino_id.required' => 'Seleccione Destino.',
            'detdestino_id.required' => 'Seleccione Detalle.',
            'ccosto_id.required' => 'Seleccione Centro de Costo.',
            'tc.required' => 'Igrese Tipo de Cambio.',
            'fecha.required' => 'Igrese fecha.',
            'detalle.required' => 'Igrese Recibido por.',
            'vencimiento.required_if' => 'Ingrese Vencimiento del Crédito.',
            'mediopago.required_if' => 'Ingrese Medio de Pago.',
            'cuenta_id.required_if' => 'Ingrese Cuenta.',
            'numerooperacion.required_if' => 'Ingrese Número de Operación.',
            'pagacon.required_if' => 'Ingrese con cuanto Paga el Cliente.',
            'detraccion_codigo.required_if' => 'Seleccione Código de detracción.',
            'detraccion_tasa.required_if' => 'Ingrese Tasa de detracción.',
            'detraccion_monto.required_if' => 'Ingrese Monto de detracción.',
        ];
    }
}

<?php

namespace App\Http\Requests;

use App\Models\Cliente;
use Illuminate\Foundation\Http\FormRequest;

class StoreRventaRequest extends FormRequest
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
            'tipocomprobante_codigo' => 'required',
            'fecha' => 'required',
            'tc' => 'required',
            'mediopago' => 'required_if:fpago,1',
            'cuenta_id' => 'required_if:fpago,1',
            'numerooperacion' => 'required_if:fpago,1',
            'pagacon' => 'required_if:mediopago,008',
            'dias' => 'required_if:fpago,2',
            'vencimiento' => 'required_if:fpago,2',
            'detraccion_codigo' => 'required_if:detraccion,1',
            'detraccion_tasa' => 'required_if:detraccion,1',
            'detraccion_monto' => 'required_if:detraccion,1',
            'cliente_id' => ['required',function($attribute, $value, $fail){
                $cliente = Cliente::find($value);
                if ($this->request->get('tipocomprobante_codigo') == '01') {
                    if ($cliente->tipdoc_id == '0' || $cliente->tipdoc_id == '6') {
                        if ($cliente->numdoc == '00000000') {
                            $fail(__('No se puede emitir Factura en Cliente sin RUC'));
                        }
                    } else {
                        $fail(__('No se puede emitir Factura en Cliente sin RUC'));
                    }
                    // if (!strpos('0_6', $cliente->tipdoc_id)){
                    //     $fail(__('No se puede emitir Factura en Cliente sin RUC'));
                    // }
                }
            }]
        ];
    }

    public function messages()
    {
        return [
            'tipocomprobante_codigo.required' => 'Seleccione Tipo de Comprobante.',
            'cliente_id.required' => 'Seleccione Cliente.',
            'tc.required' => 'Igrese Tipo de Cambio.',
            'fecha.required' => 'Igrese fecha.',
            'dias.required_if' => 'Ingrese D??as de Cr??dito.',
            'vencimiento.required_if' => 'Ingrese Vencimiento del Cr??dito.',
            'mediopago.required_if' => 'Ingrese Medio de Pago.',
            'cuenta_id.required_if' => 'Ingrese Cuenta.',
            'numerooperacion.required_if' => 'Ingrese N??mero de Operaci??n.',
            'pagacon.required_if' => 'Ingrese con cuanto Paga el Cliente.',
            'detraccion_codigo.required_if' => 'Seleccione C??digo de detracci??n.',
            'detraccion_tasa.required_if' => 'Ingrese Tasa de detracci??n.',
            'detraccion_monto.required_if' => 'Ingrese Monto de detracci??n.',
        ];
    }
}

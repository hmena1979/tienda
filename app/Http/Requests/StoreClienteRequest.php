<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClienteRequest extends FormRequest
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
        if ($this->request->get('tipdoc_id') == '6' || $this->request->get('tipdoc_id') == '0') {
            return [
                'numdoc' => 'required|unique:clientes',
                'razsoc' => 'required',
                'nomcomercial' => 'required'
            ];
        } else {
            return [
                'numdoc' => 'required|unique:clientes',
                'ape_pat' => 'required',
                'nombres' => 'required',
                'razsoc' => 'required',
                'nomcomercial' => 'required'
            ];
        }        
    }

    public function messages()
    {
        return [
            'numdoc.required' => 'Ingrese Número de documento.',
    		'numdoc.unique' => 'Número de documento ya fue Ingresado.',
    		'ape_pat.required' => 'Ingrese Apellido Paterno.',
    		'nombres.required' => 'Ingrese Nombres.',
    		'razsoc.required' => 'Ingrese Razón Social.',
    		'nomcomercial.required' => 'Ingrese Nombre Comercial.'
        ];
    }
}

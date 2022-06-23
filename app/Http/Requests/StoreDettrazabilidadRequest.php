<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDettrazabilidadRequest extends FormRequest
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
            'mpd_id' => 'required',
            'codigo' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'mpd_id.required' => 'Seleccione Materia Prima / Destino.',
    		'codigo.required' => 'Ingrese Código.',
        ];
    }
}

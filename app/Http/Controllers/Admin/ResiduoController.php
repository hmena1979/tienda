<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Lote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\Residuo;

class ResiduoController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
		$this->middleware('can:admin.residuos.index')->only('index');
		$this->middleware('can:admin.residuos.create')->only('create','store');
		$this->middleware('can:admin.residuos.edit')->only('edit','update');
    }

    public function index($periodo = '000000')
    {
        if($periodo == '000000'){
            $periodo = session('periodo');
        }
        $residuos = Residuo::where('empresa_id', session('empresa'))
            ->where('periodo', $periodo)
            ->get();
        return view('admin.residuos.index',compact('residuos','periodo'));
    }

    public function change(Request $request)
    {
        $periodo = $request->input('mes').$request->input('año');
        $residuos = Residuo::where('empresa_id', session('empresa'))
            ->where('periodo', $periodo)
            ->get();
        return view('admin.residuos.index',compact('residuos','periodo'));
    }

    public function create()
    {
        $lotes = Lote::where('empresa_id',session('empresa'))->OrderBy('lote','desc')->take(20)->pluck('lote','lote');
        return view('admin.residuos.create', compact('lotes'));
    }

    public function store(Request $request)
    {
        $rules = [
            'lote' => 'required',
            'especie' => 'required',
            'cliente_id' => 'required',
            'emision' => 'required',
            'guiamps' => 'required',
            'guiahl' => 'required',
            'guiatrasporte' => 'required',
            'peso' => 'required',
            'ticket_balanza' => ['required',
                function($attribute, $value, $fail) {
                    $contador = Residuo::where('ticket_balanza',$value)
                        ->where('empresa_id',session('empresa'))
                        ->count();
                    if ($contador > 0) {
                        $fail(__('Ya se encuentra registrado'));
                    }
                }],
        ];
        $messages = [
            'lote.required' => 'Seleccione Lote',
            'especie.required' => 'Ingrese Especie',
            'cliente_id.required' => 'Seleccione Cliente',
    		'ticket_balanza.required' => 'Ingrese Número de Reporte de Pesaje.',
            'emision.required' => 'Ingrese Fecha de Emisión',
            'guiamps.required' => 'Ingrese Guía MPS',
            'guiahl.required' => 'Ingrese Guía HL',
            'guiatrasporte.required' => 'Ingrese Guía Transportista',
    		'peso.required' => 'Ingrese Total Kg.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            $parte = Residuo::create($request->all());
            return redirect()->route('admin.residuos.index')->with('store', 'Registro agregado');
        }
    }

    public function show(Residuo $residuo)
    {
        //
    }

    public function edit(Residuo $residuo)
    {
        $lotes = Lote::where('empresa_id',session('empresa'))->OrderBy('lote','desc')->take(20)->pluck('lote','lote');
        $clientes = Cliente::where('id',$residuo->cliente_id)->get()->pluck('numdoc_razsoc','id');
        return view('admin.residuos.edit', compact('residuo','lotes','clientes'));
    }

    public function update(Request $request, Residuo $residuo)
    {
        $rules = [
            'lote' => 'required',
            'especie' => 'required',
            'cliente_id' => 'required',
            'emision' => 'required',
            'guiamps' => 'required',
            'guiahl' => 'required',
            'guiatrasporte' => 'required',
            'peso' => 'required',
            'ticket_balanza' => ['required',
                Rule::unique('residuos')->where(function ($query) use ($residuo) {
                    return $query->where('id','<>',$residuo->id)
                        ->whereNull('deleted_at')
                        ->where('empresa_id',session('empresa'));
                }),
            ],
        ];

        $messages = [
            'lote.required' => 'Seleccione Lote',
            'especie.required' => 'Ingrese Especie',
            'cliente_id.required' => 'Seleccione Cliente',
    		'ticket_balanza.required' => 'Ingrese Número de Reporte de Pesaje.',
    		'ticket_balanza.unique' => 'Número de Reporte de Pesaje ya se encuentra registrado.',
            'emision.required' => 'Ingrese Fecha de Emisión',
            'guiamps.required' => 'Ingrese Guía MPS',
            'guiahl.required' => 'Ingrese Guía HL',
            'guiatrasporte.required' => 'Ingrese Guía Transportista',
    		'peso.required' => 'Ingrese Total Kg.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            $residuo->update($request->all());
            return redirect()->route('admin.residuos.index')->with('update', 'Registro Actualizado');
        }
    }

    public function destroy(Residuo $residuo)
    {
        $residuo->delete();
        return redirect()->route('admin.residuos.index')->with('destroy', 'Registro Eliminado');
    }
}

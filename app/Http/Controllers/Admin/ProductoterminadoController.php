<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dettrazabilidad;
use App\Models\Pproceso;
use App\Models\Productoterminado;
use App\Models\Trazabilidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProductoterminadoController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
		$this->middleware('can:admin.productoterminados.index')->only('index');
		$this->middleware('can:admin.productoterminados.create')->only('create','store');
		$this->middleware('can:admin.productoterminados.edit')->only('edit','update');
    }

    public function index()
    {
        $productoterminados = Productoterminado::where('empresa_id',session('empresa'))->get();    
        return view('admin.productoterminados.index',compact('productoterminados'));
    }

    public function create()
    {
        $pprocesos = Pproceso::where('empresa_id',session('empresa'))->pluck('nombre','id');
        return view('admin.productoterminados.create',compact('pprocesos'));
    }

    public function store(Request $request)
    {
        $rules = [
            'lote' => 'required',
            'pproceso_id' => 'required',
            'trazabilidad_id' => 'required',
            'dettrazabilidad_id' => [
                'required',
                Rule::unique('productoterminados')->where(function ($query) use ($request) {
                    return $query->where('lote',$request->input('lote'))
                        ->where('empresa_id',session('empresa'));
                }),
            ],
            'empaque' => 'required',
            'vencimiento' => 'required',
            'entradas' => 'required',
        ];

        $messages = [
    		'lote.required' => 'Ingrese Lote.',
    		'pproceso_id.required' => 'Seleccione Producto.',
    		'trazabilidad_id.required' => 'Seleccione Trazabilidad.',
    		'dettrazabilidad_id.required' => 'Seleccione Código.',
            'dettrazabilidad_id.unique' => 'Código ya fue ingresado.',
    		'empaque.required' => 'Ingrese Fecha de Empaque.',
    		'vencimiento.required' => 'Ingrese Fecha de Vencimiento.',
    		'entradas.required' => 'Ingrese Cantidad de Sacos.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            $data = $request->all();
            $data = array_merge($data,[
                'salidas' => 0,
                'saldo' => $request->input('entradas'),
            ]);
            Productoterminado::create($data);
            return redirect()->route('admin.productoterminados.index')->with('store', 'Registro agregado');
        }
    }

    public function show(Productoterminado $productoterminado)
    {
        //
    }

    public function edit(Productoterminado $productoterminado)
    {
        $pprocesos = Pproceso::where('empresa_id',session('empresa'))->pluck('nombre','id');
        $trazabililidad = Trazabilidad::where('pproceso_id',$productoterminado->pproceso_id)->pluck('nombre','id');
        $dettrazabililidad = Dettrazabilidad::where('trazabilidad_id',$productoterminado->trazabilidad_id)->pluck('codigo','id');
        return view('admin.productoterminados.edit', compact('productoterminado','pprocesos','trazabililidad','dettrazabililidad'));
    }

    public function update(Request $request, Productoterminado $productoterminado)
    {
        $rules = [
            'lote' => 'required',
            'pproceso_id' => 'required',
            'trazabilidad_id' => 'required',
            'dettrazabilidad_id' => [
                'required',
                Rule::unique('productoterminados')->where(function ($query) use ($request, $productoterminado) {
                    return $query->where('id','<>',$productoterminado->id)->where('lote',$request->input('lote'))
                        ->where('empresa_id',session('empresa'));
                }),
            ],
            'empaque' => 'required',
            'vencimiento' => 'required',
            'entradas' => 'required',
        ];

        $messages = [
    		'lote.required' => 'Ingrese Lote.',
    		'pproceso_id.required' => 'Seleccione Producto.',
    		'trazabilidad_id.required' => 'Seleccione Trazabilidad.',
    		'dettrazabilidad_id.required' => 'Seleccione Código.',
    		'dettrazabilidad_id.unique' => 'Código ya fue ingresado.',
    		'empaque.required' => 'Ingrese Fecha de Empaque.',
    		'vencimiento.required' => 'Ingrese Fecha de Vencimiento.',
    		'entradas.required' => 'Ingrese Cantidad de Sacos.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            $data = $request->all();
            $data = array_merge($data,[
                'saldo' => $request->input('entradas'),
            ]);
            $productoterminado->update($data);
            return redirect()->route('admin.productoterminados.index')->with('update', 'Registro Actualizado');
        }
    }

    public function destroy(Productoterminado $productoterminado)
    {
        if ($productoterminado->parte_id == 0) {
            $productoterminado->delete();
            return redirect()->route('admin.productoterminados.index')->with('destroy', 'Registro Eliminado');
        }
    }
}

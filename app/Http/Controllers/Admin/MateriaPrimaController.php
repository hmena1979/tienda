<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Acopiador;
use App\Models\Camara;
use App\Models\Chofer;
use App\Models\Cliente;
use App\Models\Embarcacion;
use App\Models\Empacopiadora;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Models\Materiaprima;
use App\Models\Producto;
use App\Models\Transportista;

class MateriaPrimaController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
		$this->middleware('can:admin.materiaprimas.index')->only('index');
		$this->middleware('can:admin.materiaprimas.create')->only('create','store');
		$this->middleware('can:admin.materiaprimas.edit')->only('edit','update');
		// $this->middleware('can:admin.categorias.permission')->only('editpermission','updatepermission');
		// $this->middleware('can:admin.categorias.password')->only('editpassword','updatepassword');
    }

    public function index()
    {
        $materiaprimas = Materiaprima::where('empresa_id',session('empresa'))->orderBy('ingplanta')->get();
        return view('admin.materiaprimas.index',compact('materiaprimas'));
    }

    public function create()
    {
        $embarcacion = Embarcacion::where('empresa_id',session('empresa'))
            ->orderBy('nombre')->get()->pluck('nombre_matricula','id');
        $transportistas = Transportista::where('empresa_id',session('empresa'))
            ->orderBy('nombre')->pluck('nombre','id');
        $chofer = Chofer::orderBy('nombre')->pluck('nombre','id');
        $camara = Camara::orderBy('marca')->pluck('marca','id');
        $empAcopiadora = Empacopiadora::where('empresa_id',session('empresa'))->orderBy('nombre')->pluck('nombre','id');
        $producto = Producto::where('empresa_id',session('empresa'))->where('grupo',3)->orderBy('nombre')->pluck('nombre','id');
        return view('admin.materiaprimas.create',
        compact('transportistas','chofer','camara','empAcopiadora','producto','embarcacion'));
    }

    public function store(Request $request)
    {
        $rules = [
            'cliente_id' => 'required',
            'transportista_id' => 'required',
            'chofer_id' => 'required',
            'empacopiadora_id' => 'required',
            'acopiador_id' => 'required',
            'embarcacion_id' => 'required',
            'lote' => 'required',
            'guia' => 'required',
            'cajas' => 'required',
            'pplanta' => 'required',
            'fpartida' => 'required',
            'fllegada' => 'required',
            'ingplanta' => 'required',
            'hdescarga' => 'required',
            'precio' => 'required',
            'lugar' => 'required',
            'producto_id' => 'required',
            // 'destare' => 'required',
            // 'observaciones' => 'required',
        ];
        $messages = [
    		'cliente_id.required' => 'Seleccione Proveedor.',
    		'transportista_id.required' => 'Seleccione Empresa Transportista.',
    		'chofer_id.required' => 'Seleccione Chofer.',
    		'empacopiadora_id.required' => 'Seleccione Empresa Acopiadora.',
    		'acopiador_id.required' => 'Seleccione Acopiador.',
    		'embarcacion_id.required' => 'Seleccione Embarcación .',
    		'lote.required' => 'Ingrese Lote.',
    		'guia.required' => 'Ingrese Guía.',
    		'cajas.required' => 'Ingrese Cajas Declaradas.',
    		'pplanta.required' => 'Ingrese Peso Planta.',
    		'fpartida.required' => 'Ingrese Fecha de Partida.',
    		'fllegada.required' => 'Ingrese Fecha de Llegada.',
    		'ingplanta.required' => 'Ingrese Ingreso a Planta.',
    		'hdescarga.required' => 'Ingrese Hora Desgarga.',
            'precio.required' => 'Ingrese Precio',
    		'lugar.required' => 'Ingrese Lugar.',
    		'producto_id.required' => 'Ingrese Tipo de Producto .',
    		'destare.required' => 'Ingrese Destare.',
    		'observaciones.required' => 'Ingrese Observaciones.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            Materiaprima::create($request->all());
            return redirect()->route('admin.materiaprimas.index')->with('store', 'Materia Prima Agregada');
        }
    }

    public function show(Materiaprima $materiaprima)
    {
        //
    }

    public function edit(Materiaprima $materiaprima)
    {
        $clientes = Cliente::where('id',$materiaprima->cliente_id)->get()->pluck('numdoc_razsoc','id');
        $embarcacion = Embarcacion::where('empresa_id',session('empresa'))
            ->orderBy('nombre')
            ->get()
            ->pluck('nombre_matricula','id');
        $transportistas = Transportista::where('empresa_id',session('empresa'))
            ->orderBy('nombre')
            ->pluck('nombre','id');
        $chofer = Chofer::where('id',$materiaprima->chofer_id)->get()->pluck('nombre_licencia','id');
        $camara = Camara::where('id',$materiaprima->camara_id)->get()->pluck('marca_placa','id');
        $empAcopiadora = Empacopiadora::where('empresa_id',session('empresa'))
            ->orderBy('nombre')
            ->pluck('nombre','id');
        $acopiador = Acopiador::where('id',$materiaprima->acopiador_id)->pluck('nombre','id');
        $producto = Producto::where('empresa_id',session('empresa'))
            ->where('grupo',3)
            ->orderBy('nombre')
            ->pluck('nombre','id');
        return view('admin.materiaprimas.edit',
            compact(
                'materiaprima',
                'clientes',
                'embarcacion',
                'empAcopiadora',
                'acopiador',
                'transportistas',
                'chofer',
                'camara',
                'producto',
            )
        );
    }

    public function update(Request $request, Materiaprima $materiaprima)
    {
        $rules = [
            'cliente_id' => 'required',
            'transportista_id' => 'required',
            'chofer_id' => 'required',
            'empacopiadora_id' => 'required',
            'acopiador_id' => 'required',
            'embarcacion_id' => 'required',
            'lote' => 'required',
            'guia' => 'required',
            'cajas' => 'required',
            'pplanta' => 'required',
            'fpartida' => 'required',
            'fllegada' => 'required',
            'ingplanta' => 'required',
            'hdescarga' => 'required',
            'precio' => 'required',
            'lugar' => 'required',
            'producto_id' => 'required',
        ];
        $messages = [
    		'cliente_id.required' => 'Seleccione Proveedor.',
    		'transportista_id.required' => 'Seleccione Empresa Transportista.',
    		'chofer_id.required' => 'Seleccione Chofer.',
    		'empacopiadora_id.required' => 'Seleccione Empresa Acopiadora.',
    		'acopiador_id.required' => 'Seleccione Acopiador.',
    		'embarcacion_id.required' => 'Seleccione Embarcación .',
    		'lote.required' => 'Ingrese Lote.',
    		'guia.required' => 'Ingrese Guía.',
    		'cajas.required' => 'Ingrese Cajas Declaradas.',
    		'pplanta.required' => 'Ingrese Peso Planta.',
    		'fpartida.required' => 'Ingrese Fecha de Partida.',
    		'fllegada.required' => 'Ingrese Fecha de Llegada.',
    		'ingplanta.required' => 'Ingrese Ingreso a Planta.',
    		'hdescarga.required' => 'Ingrese Hora Desgarga.',
            'precio.required' => 'Ingrese Precio',
    		'lugar.required' => 'Ingrese Lugar.',
    		'producto_id.required' => 'Ingrese Tipo de Producto .',
    		'destare.required' => 'Ingrese Destare.',
    		'observaciones.required' => 'Ingrese Observaciones.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            $materiaprima->update($request->all());
            return redirect()->route('admin.materiaprimas.index')->with('update', 'Materia Prima Actualizada');
        }
    }

    public function destroy(Materiaprima $materiaprima)
    {
        $materiaprima->delete();
        return redirect()->route('admin.embarcaciones.index')->with('destroy', 'Materia Prima Eliminada');
    }
}

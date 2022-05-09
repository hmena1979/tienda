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
use App\Models\Muelle;
use App\Models\Producto;
use App\Models\Rcompra;
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
        $muelles = Muelle::where('empresa_id',session('empresa'))
            ->orderBy('nombre')->pluck('nombre','id');
        $transportistas = Transportista::where('empresa_id',session('empresa'))
            ->orderBy('nombre')->pluck('nombre','id');
        $chofer = Chofer::orderBy('nombre')->pluck('nombre','id');
        $camara = Camara::orderBy('marca')->pluck('marca','id');
        $empAcopiadora = Empacopiadora::where('empresa_id',session('empresa'))->orderBy('nombre')->pluck('nombre','id');
        $producto = Producto::where('empresa_id',session('empresa'))->where('grupo',3)->orderBy('nombre')->pluck('nombre','id');
        return view('admin.materiaprimas.create',
        compact('transportistas','chofer','camara','empAcopiadora','producto','embarcacion','muelles'));
    }

    public function store(Request $request)
    {
        $rules = [
            'lote' => 'required',
            'remitente_guia' => 'required',
            'transportista_guia' => 'required',
            'transportista_id' => 'required',
            'ticket_balanza' => 'required',
            'cliente_id' => 'required',
            'embarcacion_id' => 'required',
            'muelle_id' => 'required',
            'empacopiadora_id' => 'required',
            'acopiador_id' => 'required',
            'transportista_id' => 'required',
            'chofer_id' => 'required',
            'camara_id' => 'required',
            'fpartida' => 'required',
            'fllegada' => 'required',
            'ingplanta' => 'required',
            'hinicio' => 'required',
            'hfin' => 'required',
            'cajas' => 'required',
            'lugar' => 'required',
            'producto_id' => 'required',
        ];
        $messages = [
    		'lote.required' => 'Ingrese Lote.',
    		'remitente_guia.required' => 'Ingrese Guía Remitente.',
    		'transportista_guia.required' => 'Ingrese Guía Transportista.',
    		'transportista_id.required' => 'Seleccione Empresa Transportista.',
    		'ticket_balanza.required' => 'Ingrese Ticket Balanza.',
    		'cliente_id.required' => 'Seleccione Proveedor.',
    		'embarcacion_id.required' => 'Seleccione Embarcación.',
    		'muelle_id.required' => 'Seleccione Muelle.',
    		'empacopiadora_id.required' => 'Seleccione Empresa Acopiadora.',
    		'acopiador_id.required' => 'Seleccione Acopiador.',
    		'transportista_id.required' => 'Seleccione Transportista.',
    		'chofer_id.required' => 'Seleccione Chofer.',
    		'camara_id.required' => 'Seleccione Camara.',
    		'fpartida.required' => 'Ingrese Fecha de Partida.',
    		'fllegada.required' => 'Ingrese Fecha de Llegada.',
    		'ingplanta.required' => 'Ingrese Ingreso a Planta.',
    		'hinicio.required' => 'Ingrese Hora Inicio',
    		'hfin.required' => 'Ingrese Hora Fin.',
    		'cajas.required' => 'Ingrese Cajas Declaradas.',
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
        if ($materiaprima->rcompra_id) {
            $rcompra = Rcompra::where('lote',$materiaprima->lote)
                ->where('cliente_id',$materiaprima->cliente_id)
                ->get()->pluck('serie_numero','id');
        } else {
            $rcompra = [];
        }
        $embarcacion = Embarcacion::where('empresa_id',session('empresa'))
            ->orderBy('nombre')->get()->pluck('nombre_matricula','id');
        $muelles = Muelle::where('empresa_id',session('empresa'))
            ->orderBy('nombre')->pluck('nombre','id');
        $transportistas = Transportista::where('empresa_id',session('empresa'))
            ->orderBy('nombre')->pluck('nombre','id');
        $chofer = Chofer::where('id',$materiaprima->chofer_id)->get()->pluck('nombre_licencia','id');
        $camara = Camara::where('id',$materiaprima->camara_id)->get()->pluck('marca_placa','id');
        $empAcopiadora = Empacopiadora::where('empresa_id',session('empresa'))->orderBy('nombre')->pluck('nombre','id');
        $acopiador = Acopiador::where('id',$materiaprima->acopiador_id)->pluck('nombre','id');
        $producto = Producto::where('empresa_id',session('empresa'))->where('grupo',3)->orderBy('nombre')->pluck('nombre','id');

        return view('admin.materiaprimas.edit',
            compact(
                'materiaprima',
                'clientes',
                'rcompra',
                'embarcacion',
                'muelles',
                'transportistas',
                'chofer',
                'camara',
                'empAcopiadora',
                'acopiador',
                'producto',
            )
        );
    }

    public function update(Request $request, Materiaprima $materiaprima)
    {
        $rules = [
            'lote' => 'required',
            'remitente_guia' => 'required',
            'transportista_guia' => 'required',
            'transportista_id' => 'required',
            'ticket_balanza' => 'required',
            'cliente_id' => 'required',
            'embarcacion_id' => 'required',
            'muelle_id' => 'required',
            'empacopiadora_id' => 'required',
            'acopiador_id' => 'required',
            'transportista_id' => 'required',
            'chofer_id' => 'required',
            'camara_id' => 'required',
            'fpartida' => 'required',
            'fllegada' => 'required',
            'ingplanta' => 'required',
            'hinicio' => 'required',
            'hfin' => 'required',
            'cajas' => 'required',
            'lugar' => 'required',
            'producto_id' => 'required',
        ];
        $messages = [
    		'lote.required' => 'Ingrese Lote.',
    		'remitente_guia.required' => 'Ingrese Guía Remitente.',
    		'transportista_guia.required' => 'Ingrese Guía Transportista.',
    		'transportista_id.required' => 'Seleccione Empresa Transportista.',
    		'ticket_balanza.required' => 'Ingrese Ticket Balanza.',
    		'cliente_id.required' => 'Seleccione Proveedor.',
    		'embarcacion_id.required' => 'Seleccione Embarcación.',
    		'muelle_id.required' => 'Seleccione Muelle.',
    		'empacopiadora_id.required' => 'Seleccione Empresa Acopiadora.',
    		'acopiador_id.required' => 'Seleccione Acopiador.',
    		'transportista_id.required' => 'Seleccione Transportista.',
    		'chofer_id.required' => 'Seleccione Chofer.',
    		'camara_id.required' => 'Seleccione Camara.',
    		'fpartida.required' => 'Ingrese Fecha de Partida.',
    		'fllegada.required' => 'Ingrese Fecha de Llegada.',
    		'ingplanta.required' => 'Ingrese Ingreso a Planta.',
    		'hinicio.required' => 'Ingrese Hora Inicio',
    		'hfin.required' => 'Ingrese Hora Fin.',
    		'cajas.required' => 'Ingrese Cajas Declaradas.',
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

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Acopiador;
use App\Models\Camara;
use App\Models\Chofer;
use App\Models\Cliente;
use App\Models\Detmateriaprima;
use App\Models\Embarcacion;
use App\Models\Empacopiadora;
use App\Models\Lote;
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

    public function index($periodo = '000000')
    {
        if($periodo == '000000'){
            $periodo = session('periodo');
        }
        $materiaprimas = Materiaprima::where('empresa_id',session('empresa'))
            ->where('periodo',$periodo)
            ->orderBy('ingplanta','desc')->get();
        return view('admin.materiaprimas.index',compact('materiaprimas','periodo'));
    }

    public function change(Request $request)
    {
        $periodo = $request->input('mes').$request->input('año');
        $materiaprimas = Materiaprima::where('empresa_id',session('empresa'))
            ->where('periodo',$periodo)
            ->orderBy('ingplanta','desc')->get();
        return view('admin.materiaprimas.index',compact('materiaprimas','periodo'));
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
        $lotes = Lote::where('empresa_id',session('empresa'))->OrderBy('lote','desc')->take(15)->pluck('lote','lote');
        return view('admin.materiaprimas.create',
        compact('transportistas','chofer','camara','empAcopiadora','producto','embarcacion','muelles','lotes'));
    }

    public function store(Request $request)
    {
        // return $request->embarcacion_id;
        $rules = [
            'lote' => 'required',
            'remitente_guia' => 'required',
            'transportista_guia' => 'required',
            // 'transportista_id' => 'required',
            'ticket_balanza' => 'required',
            // 'cliente_id' => 'required',
            // 'embarcacion_id' => 'required',
            // 'muelle_id' => 'required',
            // 'empacopiadora_id' => 'required',
            // 'acopiador_id' => 'required',
            // 'transportista_id' => 'required',
            // 'chofer_id' => 'required',
            // 'camara_id' => 'required',
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
            $data = $request->except('embarcacion_id');
            $embarcacion = json_encode($request->input('embarcacion_id'));
            $data = array_merge($data,[
                'embarcacion_id' => $embarcacion,
            ]);
            $materiaprima = Materiaprima::create($data);
            return redirect()->route('admin.materiaprimas.edit', $materiaprima)->with('store', 'Materia Prima Agregada');
        }
    }

    public function show(Materiaprima $materiaprima)
    {
        //
    }

    public function edit(Materiaprima $materiaprima)
    {
        $clientes = Cliente::where('id',$materiaprima->cliente_id)->get()->pluck('numdoc_razsoc','id');
        if (!empty($materiaprima->lote) && !empty($materiaprima->cliente_id)) {
            $rcompra = Rcompra::where('lote',$materiaprima->lote)
                ->where('cliente_id',$materiaprima->cliente_id)
                ->get()->pluck('serie_numero','id');
        } else {
            $rcompra = [];
        }
        // return $materiaprima->lote.' | '.$materiaprima->cliente_id;
        // return $$rcompra;
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
        $lotes = Lote::where('empresa_id',session('empresa'))->OrderBy('lote','desc')->take(15)->pluck('lote','lote');
        // $lotes->prepend('','');
        // return $lotes;
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
                'lotes',
            )
        );
    }

    public function update(Request $request, Materiaprima $materiaprima)
    {
        $rules = [
            'lote' => 'required',
            'remitente_guia' => 'required',
            'transportista_guia' => 'required',
            // 'transportista_id' => 'required',
            'ticket_balanza' => 'required',
            'cliente_id' => 'required',
            // 'embarcacion_id' => 'required',
            // 'muelle_id' => 'required',
            // 'empacopiadora_id' => 'required',
            // 'acopiador_id' => 'required',
            // 'transportista_id' => 'required',
            // 'chofer_id' => 'required',
            // 'camara_id' => 'required',
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
            $data = $request->except('embarcacion_id');
            $embarcacion = json_encode($request->input('embarcacion_id'));
            $data = array_merge($data,[
                'embarcacion_id' => $embarcacion,
            ]);
            $materiaprima->update($data);
            return redirect()->route('admin.materiaprimas.index')->with('update', 'Materia Prima Actualizada');
        }
    }

    public function destroy(Materiaprima $materiaprima)
    {
        if($materiaprima->detmateriaprimas->count() > 0) {
            return redirect()->route('admin.materiaprimas.index')->with('message', 'Se ha producido un error, No se puede eliminar, Ya contiene pesos')->with('typealert', 'danger');
        }
        $materiaprima->delete();
        return redirect()->route('admin.materiaprimas.index')->with('destroy', 'Materia Prima Eliminada');
    }

    public function tablaitem(Materiaprima $materiaprima)
    {
        return view('admin.materiaprimas.detalle',compact('materiaprima'));
    }

    public function aedet (Request $request, $envio)
    {
        if ($request->ajax()) {
            $det = json_decode($envio);
            if ($det->tipo == 1) {
                $pesada = Detmateriaprima::where('materiaprima_id',$det->id)->count();
                Detmateriaprima::create([
                    'materiaprima_id' => $det->id,
                    'pesada' => $pesada + 1,
                    'pesobruto' => $det->pesobruto,
                    'tara' => $det->tara,
                    'pesoneto' => $det->pesoneto,
                ]);
                $suma = Detmateriaprima::where('materiaprima_id',$det->id)->sum('pesoneto');
                Materiaprima::where('id', $det->id)->update([
                    'pplanta' => $suma,
                    'batch' => $pesada + 1,
                ]);
                $result = [
                    'pplanta' => $suma,
                    'batch' => $pesada + 1,
                ];
            } else {
                $detalle = Detmateriaprima::findOrFail($det->id);
                $detalle->update([
                    'pesobruto' => $det->pesobruto,
                    'tara' => $det->tara,
                    'pesoneto' => $det->pesoneto,
                ]);
                $suma = Detmateriaprima::where('materiaprima_id',$det->id)->sum('pesoneto');
                Materiaprima::where('id', $det->id)->update([
                    'pplanta' => $suma,
                ]);
                $pesada = Detmateriaprima::where('materiaprima_id',$det->id)->count();
                $result = [
                    'pplanta' => $suma,
                    'batch' => $pesada,
                ];
            }
            // return true;
            return response()->json($result);
        }
    }

    public function detmateriaprima(Detmateriaprima $detmateriaprima)
    {
        return response()->json($detmateriaprima);
    }

    public function destroyitem(Detmateriaprima $detmateriaprima)
    {
        $materiaprima_id = $detmateriaprima->materiaprima_id;
        $detmateriaprima->delete();
        $pesada = Detmateriaprima::where('materiaprima_id',$materiaprima_id)->count();
        $suma = Detmateriaprima::where('materiaprima_id',$materiaprima_id)->sum('pesoneto');
        Materiaprima::where('id', $materiaprima_id)->update([
            'pplanta' => $suma,
            'batch' => $pesada,
        ]);
        $result = [
            'pplanta' => $suma,
            'batch' => $pesada,
        ];
        return response()->json($result);
    }
}

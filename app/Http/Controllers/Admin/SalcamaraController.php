<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDetdetsalcamaraRequest;
use App\Models\Detdetsalcamara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

use App\Models\Salcamara;
use App\Models\Detsalcamara;
use App\Models\Supervisor;
use App\Models\Lote;
use App\Models\Productoterminado;
use App\Models\Transportista;
use App\Models\Trazabilidad;

class SalcamaraController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
		$this->middleware('can:admin.salcamaras.index')->only('index');
		$this->middleware('can:admin.salcamaras.create')->only('create','store');
		$this->middleware('can:admin.salcamaras.edit')->only('edit','update');
		$this->middleware('can:admin.salcamaras.aprobar')->only('aprobar','abrir');
    }

    public function index($periodo = '000000')
    {
        if($periodo == '000000'){
            $periodo = session('periodo');
        }
        $salcamaras = Salcamara::where('empresa_id', session('empresa'))
            ->where('periodo', $periodo)
            ->get();    
        return view('admin.salcamaras.index',compact('salcamaras','periodo'));
    }

    public function change(Request $request)
    {
        $periodo = $request->input('mes').$request->input('año');
        $salcamaras = Salcamara::where('empresa_id', session('empresa'))
            ->where('periodo', $periodo)
            ->get();    
        return view('admin.salcamaras.index',compact('salcamaras','periodo'));
    }

    public function create()
    {
        $lotes = Lote::where('empresa_id',session('empresa'))->OrderBy('lote','desc')->take(20)->pluck('lote','lote');
        $supervisores = Supervisor::where('empresa_id',session('empresa'))->where('activo',1)->OrderBy('nombre')->pluck('nombre','id');
        $transportistas = Transportista::where('empresa_id',session('empresa'))
            ->orderBy('nombre')->pluck('nombre','id');
        return view('admin.salcamaras.create', compact('lotes','supervisores','transportistas'));
    }

    public function store(Request $request)
    {
        $rules = [
            'fecha' => 'required',
            'numero' => ['required',
                function($attribute, $value, $fail) {
                    $contador = Salcamara::where('numero',$value)
                        ->where('empresa_id',session('empresa'))
                        ->count();
                    if ($contador > 0) {
                        $fail(__('Ya se encuentra registrado'));
                    }
                }],
            'supervisor_id' => 'required',
        ];
        if ($request->input('motivo') == 1) {
            $rules = array_merge($rules,[
                'contenedor' => 'required',
                'precinto' => 'required',
                'transportista_id' => 'required',
                'placas' => 'required',
                'grt' => 'required',
                'gr' => 'required',
            ]);
        }
        $messages = [
            'fecha.required' => 'Ingrese fecha',
            'supervisor_id.required' => 'Seleccione Supervisor',
    		'numero.required' => 'Ingrese Número.',
    		'contenedor.required' => 'Ingrese Contenedor.',
    		'precinto.required' => 'Ingrese Precinto.',
    		'transportista_id.required' => 'Seleccione Transportista.',
    		'placas.required' => 'Ingrese Placa.',
    		'grt.required' => 'Ingrese Guía de Remisión Transportista.',
    		'gr.required' => 'Ingrese Guía de Remisión Remitente.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            $salcamara = Salcamara::create($request->all());
            return redirect()->route('admin.salcamaras.edit',$salcamara)->with('store', 'Registro agregado');
        }
    }

    public function show(Salcamara $salcamara)
    {
        //
    }

    public function edit(Salcamara $salcamara, $detsalcamara = 'A')
    {
        if ($detsalcamara == 'A'){
            $detsalcamara = Detsalcamara::where('salcamara_id',$salcamara->id)->first();
        } else {
            $detsalcamara = Detsalcamara::findOrFail($detsalcamara);
        }
        $lotes = Lote::where('empresa_id',session('empresa'))->OrderBy('lote','desc')->take(20)->pluck('lote','lote');
        $supervisores = Supervisor::where('empresa_id',session('empresa'))->where('activo',1)->OrderBy('nombre')->pluck('nombre','id');
        $trazabilidad = Trazabilidad::whereRelation('pproceso','empresa_id','=',session('empresa'))->pluck('nombre','id');
        $transportistas = Transportista::where('empresa_id',session('empresa'))
            ->orderBy('nombre')->pluck('nombre','id');
        return view('admin.salcamaras.edit', compact('salcamara','lotes','supervisores','trazabilidad','transportistas','detsalcamara'));
    }

    public function update(Request $request, Salcamara $salcamara)
    {
        $rules = [
            'fecha' => 'required',
            'supervisor_id' => 'required',
            'numero' => [
                'required',
                Rule::unique('salcamaras')->where(function ($query) use ($salcamara) {
                    return $query->where('id','<>',$salcamara->id)
                        ->whereNull('deleted_at')
                        ->where('empresa_id',session('empresa'));
                }),
            ],
        ];

        $messages = [
    		'fecha.required' => 'Ingrese fecha',
            'supervisor_id.required' => 'Seleccione Supervisor',
    		'numero.required' => 'Ingrese Número.',
    		'numero.unique' => 'Ya fue registrado.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            $salcamara->update($request->all());
            return redirect()->route('admin.salcamaras.index')->with('update', 'Registro Actualizado');
        }
    }

    public function destroy(Salcamara $salcamara)
    {
        if (Detsalcamara::where('salcamara_id',$salcamara->id)->count() > 0) {
            return back()->with('message', 'Se ha producido un error, Ya contiene detalles')->with('typealert', 'danger');
        }
        $salcamara->delete();
        return redirect()->route('admin.salcamaras.index')->with('destroy', 'Registro Eliminado');
    }
    
    // public function tablaitem(Request $request, Salcamara $salcamara)
    // {
    //     if ($request->ajax()) {
    //         return view('admin.ingcamaras.detalle',compact('salcamara'));
    //     }
    // }

    public function aedetsalcamara(Request $request)
    {
        if ($request->ajax()) {
            if ($request->input('tipoSalcamara') == 1) {
                Detsalcamara::create([ 
                    'salcamara_id' => $request->input('salcamara_id'),
                    'dettrazabilidad_id' => $request->input('dettrazabilidad_id'),
                ]);
                return 1;
            } else {
                $detsalcamara = Detsalcamara::findOrFail($request->input('iddetsalcamara'));
                $detsalcamara->update([
                    'dettrazabilidad_id' => $request->input('dettrazabilidad_id'),
                ]);
                return 1;
            }
        }
    }

    public function tablaitem(Request $request, $detsalcamara)
    {
        if ($request->ajax()) {
            $detsalcamara = Detsalcamara::find($detsalcamara);
            return view('admin.salcamaras.detalle',compact('detsalcamara'));
        }
    }

    public function addeditdet(StoreDetdetsalcamaraRequest $request)
    {
        if ($request->ajax()) {
            if ($request->input('tipodet') == 1){
                Detdetsalcamara::create([
                    'detsalcamara_id' => $request->input('detsalcamara_id'),
                    'productoterminado_id' => $request->input('productoterminado_id'),
                    'lote' => $request->input('lote'),
                    'cantidad' => $request->input('cantidad'),
                    'peso' => $request->input('peso'),
                ]);
                $productoTerminado = Productoterminado::findOrFail($request->input('productoterminado_id'));
                $productoTerminado->update([
                    'salidas' => $productoTerminado->salidas + $request->input('cantidad'),
                    'saldo' => $productoTerminado->saldo - $request->input('cantidad'),
                ]);
                $detdetSalCamaras = Detdetsalcamara::where('detsalcamara_id',$request->input('detsalcamara_id'))->get();
                $cantidad = $detdetSalCamaras->sum('cantidad');
                $detSalCamara = Detsalcamara::findOrFail($request->input('detsalcamara_id'));
                $lotes = '';
                foreach ($detdetSalCamaras as $det) {
                    $lotes .= $det->lote . ' ';
                }
                $detSalCamara->update([
                    'lotes' => $lotes,
                    'cantidad' => $cantidad,
                    'peso' => 20,
                    'total' => $cantidad * 20,
                ]);
                $detSalCamaras = Detsalcamara::where('salcamara_id',$detSalCamara->salcamara_id)->get();
                $salCamara = Salcamara::findOrFail($detSalCamara->salcamara_id);
                $salCamara->update([
                    'sacos' => $detSalCamaras->sum('cantidad'),
                    'pesoneto' => $detSalCamaras->sum('total'),
                ]);

            } else {
                Detdetsalcamara::where('id',$request->input('iddet'))->update([
                    'detsalcamara_id' => $request->input('detsalcamara_id'),
                    'productoterminado_id' => $request->input('productoterminado_id'),
                    'lote' => $request->input('lote'),
                    'cantidad' => $request->input('cantidad'),
                ]);
            }
            return true;
        }
    }

    public function detdetsalcamara(Request $request, Detdetsalcamara $detdetsalcamara)
    {
        if ($request->ajax()) {
            return response()->json($detdetsalcamara);
        }
    }

    public function detsalcamara(Request $request, Detsalcamara $detsalcamara)
    {
        if ($request->ajax()) {
            return response()->json($detsalcamara);
        }
    }

    public function destroydetsalcamara(Request $request, Detsalcamara $detsalcamara)
    {
        if ($request->ajax()) {
            $detsalcamara->delete();
        }
    }

    public function destroyitem(Request $request, Detdetsalcamara $detdetsalcamara)
    {
        if ($request->ajax()) {
            $productoterminado_id = $detdetsalcamara->productoterminado_id;
            $cantidad = $detdetsalcamara->cantidad;
            $detsalcamara_id = $detdetsalcamara->detsalcamara_id;
            $detdetsalcamara->delete();
            $productoTerminado = Productoterminado::findOrFail($productoterminado_id);
                $productoTerminado->update([
                    'salidas' => $productoTerminado->salidas - $cantidad,
                    'saldo' => $productoTerminado->saldo + $cantidad,
                ]);
                $detdetSalCamaras = Detdetsalcamara::where('detsalcamara_id',$detsalcamara_id)->get();
                $cantidad = $detdetSalCamaras->sum('cantidad');
                $detSalCamara = Detsalcamara::findOrFail($detsalcamara_id);
                $lotes = '';
                foreach ($detdetSalCamaras as $det) {
                    $lotes .= $det->lote . ' ';
                }
                $detSalCamara->update([
                    'lotes' => $lotes,
                    'cantidad' => $cantidad,
                    'peso' => 20,
                    'total' => $cantidad * 20,
                ]);
                $detSalCamaras = Detsalcamara::where('salcamara_id',$detSalCamara->salcamara_id)->get();
                $salCamara = Salcamara::findOrFail($detSalCamara->salcamara_id);
                $salCamara->update([
                    'sacos' => $detSalCamaras->sum('cantidad'),
                    'pesoneto' => $detSalCamaras->sum('total'),
                ]);
            
        }
    }

    public function aprobar(Salcamara $salcamara)
    {
        $salcamara->update([
            'user_id' => Auth::user()->id,
            'estado' => 2,
        ]);
        return redirect()->route('admin.salcamaras.edit',$salcamara)->with('update', 'Guía de Salida a Cámaras Aprobada');
    }

    public function abrir(Salcamara $salcamara)
    {
        $salcamara->update([
            'user_id' => null,
            'estado' => 1,
        ]);
        return redirect()->route('admin.salcamaras.edit',$salcamara)->with('update', 'Puede editar Guía de Salida a Cámaras');
    }

    
    public function listdetalle(Request $request, Detsalcamara $detsalcamara)
    {
        if($request->ajax()){
            $saldos = Productoterminado::where('empresa_id',session('empresa'))
                ->where('dettrazabilidad_id',$detsalcamara->dettrazabilidad_id)
                ->where('saldo','>',0)
                ->orderBy('lote')
                ->get();
            return response()->json($saldos);
        }
    }

    public function productoterminado(Request $request, Productoterminado $productoterminado)
    {
        if ($request->ajax()) {
            return response()->json($productoterminado);
        }
    }
}

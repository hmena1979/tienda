<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDetingcamaraRequest;
use App\Models\Detingcamara;
use App\Models\Ingcamara;
use App\Models\Lote;
use App\Models\Supervisor;
use App\Models\Trazabilidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class IngcamaraController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
		$this->middleware('can:admin.ingcamaras.index')->only('index');
		$this->middleware('can:admin.ingcamaras.create')->only('create','store');
		$this->middleware('can:admin.ingcamaras.edit')->only('edit','update');
		$this->middleware('can:admin.ingcamaras.aprobar')->only('aprobar','abrir');
    }

    public function index($periodo = '000000')
    {
        if($periodo == '000000'){
            $periodo = session('periodo');
        }
        $ingcamaras = Ingcamara::where('empresa_id', session('empresa'))
            ->where('periodo', $periodo)
            ->get();    
        return view('admin.ingcamaras.index',compact('ingcamaras','periodo'));
    }

    public function change(Request $request)
    {
        $periodo = $request->input('mes').$request->input('año');
        $ingcamaras = Ingcamara::where('empresa_id', session('empresa'))
            ->where('periodo', $periodo)
            ->get();    
        return view('admin.ingcamaras.index',compact('ingcamaras','periodo'));
    }

    public function create()
    {
        $lotes = Lote::where('empresa_id',session('empresa'))->OrderBy('lote','desc')->take(20)->pluck('lote','lote');
        $supervisores = Supervisor::where('empresa_id',session('empresa'))->where('activo',1)->OrderBy('nombre')->pluck('nombre','id');
        return view('admin.ingcamaras.create', compact('lotes','supervisores'));
    }

    public function store(Request $request)
    {
        $rules = [
            'fecha' => 'required',
            'fproduccion' => 'required',
            'lote' => 'required',
            'supervisor_id' => 'required',
            'numero' => ['required',
                function($attribute, $value, $fail) {
                    $contador = Ingcamara::where('numero',$value)
                        ->where('empresa_id',session('empresa'))
                        ->count();
                    if ($contador > 0) {
                        $fail(__('Ya se encuentra registrado'));
                    }
                }],
        ];
        $messages = [
            'fecha.required' => 'Ingrese fecha',
            'fproduccion.required' => 'Ingrese fecha de producción',
            'lote.required' => 'Seleccione Lote',
            'supervisor_id.required' => 'Seleccione Supervisor',
    		'numero.required' => 'Ingrese Número.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            $ingcamara = Ingcamara::create($request->all());
            return redirect()->route('admin.ingcamaras.edit',$ingcamara)->with('store', 'Registro agregado');
        }
    }

    public function show(Ingcamara $ingcamara)
    {
        //
    }

    public function edit(Ingcamara $ingcamara)
    {
        $lotes = Lote::where('empresa_id',session('empresa'))->OrderBy('lote','desc')->take(20)->pluck('lote','lote');
        $supervisores = Supervisor::where('empresa_id',session('empresa'))->where('activo',1)->OrderBy('nombre')->pluck('nombre','id');
        $trazabilidad = Trazabilidad::whereRelation('pproceso','empresa_id','=',session('empresa'))->pluck('nombre','id');
        return view('admin.ingcamaras.edit', compact('ingcamara','lotes','supervisores','trazabilidad'));
    }

    public function update(Request $request, Ingcamara $ingcamara)
    {
        $rules = [
            'fecha' => 'required',
            'fproduccion' => 'required',
            'lote' => 'required',
            'supervisor_id' => 'required',
            'numero' => [
                'required',
                Rule::unique('ingcamaras')->where(function ($query) use ($ingcamara) {
                    return $query->where('id','<>',$ingcamara->id)
                        ->whereNull('deleted_at')
                        ->where('empresa_id',session('empresa'));
                }),
            ],
        ];

        $messages = [
    		'fecha.required' => 'Ingrese fecha',
            'fproduccion.required' => 'Ingrese fecha de producción',
            'lote.required' => 'Seleccione Lote',
            'supervisor_id.required' => 'Seleccione Supervisor',
    		'numero.required' => 'Ingrese Número.',
    		'numero.unique' => 'Ya fue registrado.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            $ingcamara->update($request->all());
            return redirect()->route('admin.ingcamaras.index')->with('update', 'Registro Actualizado');
        }
    }

    public function destroy(Ingcamara $ingcamara)
    {
        if (Detingcamara::where('ingcamara_id',$ingcamara->id)->count() > 0) {
            return back()->with('message', 'Se ha producido un error, Ya contiene detalles')->with('typealert', 'danger');
        }
        $ingcamara->delete();
        return redirect()->route('admin.ingcamaras.index')->with('destroy', 'Registro Eliminado');
    }

    public function tablaitem(Request $request, Ingcamara $ingcamara)
    {
        if ($request->ajax()) {
            return view('admin.ingcamaras.detalle',compact('ingcamara'));
        }
    }

    public function additem(StoreDetingcamaraRequest $request)
    {
        if ($request->ajax()) {
            if ($request->input('tipodet') == 1){
                Detingcamara::create([
                    'ingcamara_id' => $request->input('ingcamara_id'),
                    'dettrazabilidad_id' => $request->input('dettrazabilidad_id'),
                    'peso' => $request->input('peso'),
                    'cantidad' => $request->input('cantidad'),
                    'total' => $request->input('total'),
                ]);
            } else {
                Detingcamara::where('id',$request->input('iddet'))->update([
                    'ingcamara_id' => $request->input('ingcamara_id'),
                    'dettrazabilidad_id' => $request->input('dettrazabilidad_id'),
                    'peso' => $request->input('peso'),
                    'cantidad' => $request->input('cantidad'),
                    'total' => $request->input('total'),
                ]);
            }
            return true;
        }
    }

    public function detingcamara(Request $request, Detingcamara $detingcamara)
    {
        if ($request->ajax()) {
            $det = [
                'id' => $detingcamara->id ,
                'envasado_id' => $detingcamara->envasado_id,
                'trazabilidad_id' => $detingcamara->dettrazabilidad->trazabilidad->id,
                'dettrazabilidad_id' => $detingcamara->dettrazabilidad_id,
                'peso' => $detingcamara->peso,
                'cantidad' => $detingcamara->cantidad,
                'total' => $detingcamara->total,
            ];
            return response()->json($det);
        }
    }

    public function destroyitem(Request $request, Detingcamara $detingcamara)
    {
        if ($request->ajax()) {
            $detingcamara->delete();
        }
    }

    public function aprobar(Ingcamara $ingcamara)
    {
        $ingcamara->update([
            'user_id' => Auth::user()->id,
            'estado' => 2,
        ]);
        return redirect()->route('admin.ingcamaras.edit',$ingcamara)->with('update', 'Guía de Ingreso a Cámaras Aprobada');
    }

    public function abrir(Ingcamara $ingcamara)
    {
        $ingcamara->update([
            'user_id' => null,
            'estado' => 1,
        ]);
        return redirect()->route('admin.ingcamaras.edit',$ingcamara)->with('update', 'Puede editar Guía de Ingreso a Cámaras');
    }
}

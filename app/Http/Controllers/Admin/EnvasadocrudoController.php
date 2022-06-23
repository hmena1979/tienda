<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreDetenvasadoRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

use App\Models\Envasado;
use App\Models\Detenvasado;
use App\Models\Equipoenvasado;
use App\Models\Lote;
use App\Models\Supervisor;
use App\Models\Trazabilidad;
use App\Models\Dettrazabilidad;

class EnvasadocrudoController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
		$this->middleware('can:admin.envasadocrudos.index')->only('index');
		$this->middleware('can:admin.envasadocrudos.create')->only('create','store');
		$this->middleware('can:admin.envasadocrudos.edit')->only('edit','update');
		$this->middleware('can:admin.envasadocrudos.aprobar')->only('aprobar','abrir');
    }

    public function index($periodo = '000000')
    {
        if($periodo == '000000'){
            $periodo = session('periodo');
        }
        $envasados = Envasado::where('tipo',2)
            ->where('empresa_id', session('empresa'))
            ->where('periodo', $periodo)
            ->get();    
        return view('admin.envasadocrudos.index',compact('envasados','periodo'));
    }

    public function change(Request $request)
    {
        $periodo = $request->input('mes').$request->input('año');
        $envasados = Envasado::where('tipo',2)
            ->where('empresa_id', session('empresa'))
            ->where('periodo', $periodo)
            ->get();    
        return view('admin.envasadocrudos.index',compact('envasados','periodo'));
    }

    public function create()
    {
        $lotes = Lote::where('empresa_id',session('empresa'))->OrderBy('lote','desc')->take(20)->pluck('lote','lote');
        $supervisores = Supervisor::where('empresa_id',session('empresa'))->where('activo',1)->OrderBy('nombre')->pluck('nombre','id');
        $tipo = 2;
        return view('admin.envasadocrudos.create', compact('lotes','supervisores','tipo'));
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
                    $contador = Envasado::where('numero',$value)
                        ->where('empresa_id',session('empresa'))
                        ->where('tipo', 2)
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
            $envasado = Envasado::create($request->all());
            return redirect()->route('admin.envasadocrudos.edit',$envasado)->with('store', 'Registro agregado');
        }
    }

    public function show(Envasado $envasado)
    {
        //
    }

    public function edit(Envasado $envasado)
    {
        $lotes = Lote::where('empresa_id',session('empresa'))->OrderBy('lote','desc')->take(20)->pluck('lote','lote');
        $supervisores = Supervisor::where('empresa_id',session('empresa'))->where('activo',1)->OrderBy('nombre')->pluck('nombre','id');
        $equipos = Equipoenvasado::where('empresa_id',session('empresa'))->where('activo',1)->OrderBy('nombre')->pluck('nombre','id');
        $trazabilidad = Trazabilidad::whereRelation('pproceso','empresa_id','=',session('empresa'))->pluck('nombre','id');
        return view('admin.envasadocrudos.edit', compact('envasado','lotes','supervisores','equipos','trazabilidad'));
    }

    public function update(Request $request, Envasado $envasado)
    {
        $rules = [
            'fecha' => 'required',
            'fproduccion' => 'required',
            'lote' => 'required',
            'supervisor_id' => 'required',
            'numero' => [
                'required',
                Rule::unique('envasados')->where(function ($query) use ($envasado) {
                    return $query->where('id','<>',$envasado->id)
                        ->whereNull('deleted_at')
                        ->where('tipo', 2)
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
            $envasado->update($request->all());
            return redirect()->route('admin.envasadocrudos.index')->with('update', 'Registro Actualizado');
        }
    }

    public function destroy(Envasado $envasado)
    {
        if (Detenvasado::where('envasado_id',$envasado->id)->count() > 0) {
            return back()->with('message', 'Se ha producido un error, Ya contiene detalles')->with('typealert', 'danger');
        }
        $envasado->delete();
        return redirect()->route('admin.envasadocrudos.index')->with('destroy', 'Registro Eliminado');
    }

    public function tablaitem(Request $request, Envasado $envasado)
    {
        if ($request->ajax()) {
            return view('admin.envasadocrudos.detalle',compact('envasado'));
        }
    }

    public function additem(StoreDetenvasadoRequest $request)
    {
        if ($request->ajax()) {
            if ($request->input('tipodet') == 1){
                Detenvasado::create([
                    'envasado_id' => $request->input('envasado_id'),
                    'dettrazabilidad_id' => $request->input('dettrazabilidad_id'),
                    'peso' => $request->input('peso'),
                    'cantidad' => $request->input('cantidad'),
                    'total' => $request->input('total'),
                    'equipoenvasado_id' => $request->input('equipoenvasado_id'),
                    'hora' => $request->input('hora'),
                ]);
            } else {
                Detenvasado::where('id',$request->input('iddet'))->update([
                    'envasado_id' => $request->input('envasado_id'),
                    'dettrazabilidad_id' => $request->input('dettrazabilidad_id'),
                    'peso' => $request->input('peso'),
                    'cantidad' => $request->input('cantidad'),
                    'total' => $request->input('total'),
                    'equipoenvasado_id' => $request->input('equipoenvasado_id'),
                    'hora' => $request->input('hora'),
                ]);
            }
            return true;
        }
    }

    public function detenvasado(Request $request, Detenvasado $detenvasado)
    {
        if ($request->ajax()) {
            $det = [
                'id' => $detenvasado->id ,
                'envasado_id' => $detenvasado->envasado_id,
                'trazabilidad_id' => $detenvasado->dettrazabilidad->trazabilidad->id,
                'dettrazabilidad_id' => $detenvasado->dettrazabilidad_id,
                'peso' => $detenvasado->peso,
                'cantidad' => $detenvasado->cantidad,
                'total' => $detenvasado->total,
                'equipoenvasado_id' => $detenvasado->equipoenvasado_id,
                'hora' => $detenvasado->hora,
            ];
            return response()->json($det);
        }
    }

    public function destroyitem(Request $request, Detenvasado $detenvasado)
    {
        if ($request->ajax()) {
            $detenvasado->delete();
        }
    }

    public function aprobar(Envasado $envasado)
    {
        $envasado->update([
            'user_id' => Auth::user()->id,
            'estado' => 2,
        ]);
        return redirect()->route('admin.envasadocrudos.edit',$envasado)->with('update', 'Planilla de Envasado Crudo Aprobada');
    }

    public function abrir(Envasado $envasado)
    {
        $envasado->update([
            'user_id' => null,
            'estado' => 1,
        ]);
        return redirect()->route('admin.envasadocrudos.edit',$envasado)->with('update', 'Puede editar Planilla de Envasado Crudo');
    }
}

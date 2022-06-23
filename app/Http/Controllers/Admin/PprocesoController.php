<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreDettrazabilidadRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\Pproceso;
use App\Models\Trazabilidad;
use App\Models\Dettrazabilidad;
use App\Models\Mpd;

class PprocesoController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
		$this->middleware('can:admin.pprocesos.index')->only('index');
		$this->middleware('can:admin.pprocesos.create')->only('create','store');
		$this->middleware('can:admin.pprocesos.edit')->only('edit','update');
    }

    public function index()
    {
        $pprocesos = Pproceso::where('empresa_id',session('empresa'))->orderBy('nombre')->get();
        return view('admin.pprocesos.index',compact('pprocesos'));
    }

    public function create()
    {
        return view('admin.pprocesos.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'nombre' => ['required',
                function($attribute, $value, $fail) {
                    $contador = Pproceso::where('nombre',$value)
                        ->where('empresa_id',session('empresa'))
                        ->count();
                    if ($contador > 0) {
                        $fail(__('Ya se encuentra registrado'));
                    }
                }]
                
        ];
        $messages = [
    		'nombre.required' => 'Ingrese Nombre.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            $pproceso = Pproceso::create($request->all());
            return redirect()->route('admin.pprocesos.edit',$pproceso)->with('store', 'Registro agregado');
        }
    }

    public function show(Pproceso $pproceso)
    {
        //
    }

    public function edit(Pproceso $pproceso, $trazabilidad = 99999)
    {
        if ($trazabilidad == 99999){
            $trazabilidad = Trazabilidad::where('pproceso_id',$pproceso->id)->first();
        } else {
            $trazabilidad = Trazabilidad::findOrFail($trazabilidad);
        }
        $mpds = Mpd::pluck('nombre','id');
        return view('admin.pprocesos.edit', compact('pproceso','trazabilidad','mpds'));
    }

    public function update(Request $request, Pproceso $pproceso)
    {
        $rules = [
            'nombre' => [
                'required',
                Rule::unique('pprocesos')->where(function ($query) use ($pproceso) {
                    return $query->where('id','<>',$pproceso->id)
                        ->whereNull('deleted_at')
                        ->where('empresa_id',session('empresa'));
                }),
            ],
        ];

        $messages = [
    		'nombre.required' => 'Ingrese Nombre.',
    		'nombre.unique' => 'Ya fue registrado.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            $pproceso->update(['nombre' => $request->input('nombre')]);
            return redirect()->route('admin.pprocesos.index')->with('update', 'Registro Actualizado');
        }
    }

    public function destroy(Pproceso $pproceso)
    {
         // Error si tiene detalles
         if($pproceso->trazabilidads()->count() > 0){
            return redirect()->route('admin.pprocesos.index')->with('message', 'Se ha producido un error, No se puede eliminar, Contiene detalles')->with('typealert', 'danger');
        }
        $pproceso->delete();
        return redirect()->route('admin.pprocesos.index')->with('destroy', 'Registro Eliminado');
    }

    public function aetrazabilidad(Request $request)
    {
        if ($request->ajax()) {
            if ($request->input('tipoTrazabilidad') == 1) {
                Trazabilidad::create([ 
                    'pproceso_id' => $request->input('pproceso_id'),
                    'nombre' => $request->input('nombreTrazabilidad'),
                ]);
                return 1;
            } else {
                $trazabilidad = Trazabilidad::findOrFail($request->input('idtrazabilidad'));
                $trazabilidad->update([
                    'nombre' => $request->input('nombreTrazabilidad'),
                ]);
                return 1;
            }
        }
    }

    public function tablaitem(Request $request, $trazabilidad)
    {
        if ($request->ajax()) {
            $trazabilidad = Trazabilidad::find($trazabilidad);
            return view('admin.pprocesos.detalle',compact('trazabilidad'));
        }
    }

    public function addeditdet(StoreDettrazabilidadRequest $request)
    {
        if ($request->ajax()) {
            if ($request->input('tipodet') == 1){
                Dettrazabilidad::create([
                    'trazabilidad_id' => $request->input('trazabilidad_id'),
                    'mpd_id' => $request->input('mpd_id'),
                    'calidad' => $request->input('calidad'),
                    'sobrepeso' => $request->input('sobrepeso'),
                    'envase' => $request->input('envase'),
                    'peso' => $request->input('peso'),
                    'codigo' => $request->input('codigo'),
                    'precio' => $request->input('precio'),
                ]);
            } else {
                Dettrazabilidad::where('id',$request->input('iddet'))->update([
                    'mpd_id' => $request->input('mpd_id'),
                    'calidad' => $request->input('calidad'),
                    'sobrepeso' => $request->input('sobrepeso'),
                    'envase' => $request->input('envase'),
                    'codigo' => $request->input('codigo'),
                    'peso' => $request->input('peso'),
                    'precio' => $request->input('precio'),
                ]);
            }
            return true;
        }
    }

    public function dettrazabilidad(Request $request, Dettrazabilidad $dettrazabilidad)
    {
        if ($request->ajax()) {
            return response()->json($dettrazabilidad);
        }
    }

    public function trazabilidad(Request $request, Trazabilidad $trazabilidad)
    {
        if ($request->ajax()) {
            return response()->json($trazabilidad);
        }
    }

    public function destroytrazabilidad(Request $request, Trazabilidad $trazabilidad)
    {
        if ($request->ajax()) {
            $trazabilidad->delete();
        }
    }

    public function destroyitem(Request $request, Dettrazabilidad $dettrazabilidad)
    {
        if ($request->ajax()) {
            $dettrazabilidad->delete();
        }
    }

    
    public function listdetalle(Request $request, $trazabilidad)
    {
        if($request->ajax()){
            $dettrazabilidad = Dettrazabilidad::where('trazabilidad_id',$trazabilidad)
                ->get();
            return response()->json($dettrazabilidad);
        }
    }
}

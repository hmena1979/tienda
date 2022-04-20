<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Acopiador;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

use App\Models\Empacopiadora;

class EmpAcopiadoraController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
		$this->middleware('can:admin.empacopiadoras.index')->only('index');
		$this->middleware('can:admin.empacopiadoras.create')->only('create','store');
		$this->middleware('can:admin.empacopiadoras.edit')->only('edit','update');
    }

    public function index()
    {
        $empacopiadoras = Empacopiadora::where('empresa_id',session('empresa'))->orderBy('nombre')->get();
        return view('admin.empacopiadoras.index',compact('empacopiadoras'));
    }

    public function create()
    {
        return view('admin.empacopiadoras.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'nombre' => ['required',
                function($attribute, $value, $fail) {
                    $contador = Empacopiadora::where('nombre',$value)
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
            $empacopiadora = Empacopiadora::create($request->all());
            return redirect()->route('admin.empacopiadoras.edit',$empacopiadora)->with('store', 'Empresa Acopiadora Agregado');
        }
    }

    public function show(Empacopiadora $empacopiadora)
    {
        //
    }

    public function edit(Empacopiadora $empacopiadora)
    {
        return view('admin.empacopiadoras.edit', compact('empacopiadora'));
    }

    public function update(Request $request, Empacopiadora $empacopiadora)
    {
        $rules = [
            'nombre' => [
                'required',
                Rule::unique('empacopiadoras')->where(function ($query) use ($empacopiadora) {
                    return $query->where('id','<>',$empacopiadora->id)
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
            $empacopiadora->update(['nombre' => $request->input('nombre')]);
            return redirect()->route('admin.empacopiadoras.index')->with('update', 'Empresa Acopiadora Actualizado');
        }
    }

    public function destroy(Empacopiadora $empacopiadora)
    {
        //
    }

    public function aedet (Request $request, $envio) {
        if ($request->ajax()) {
            $det = json_decode($envio);
            if ($det->tipo == 1) {
                $conteo = Acopiador::where('empacopiadora_id',$det->id)->where('nombre',$det->nombre)->count();
                if ($conteo) {
                    return 2;
                }
                Acopiador::create([
                    'empacopiadora_id' => $det->id,
                    'nombre' => $det->nombre,
                ]);
            } else {
                $acopiador = Acopiador::findOrFail($det->id);
                $conteo = Acopiador::where('empacopiadora_id',$acopiador->empacopiadora_id)
                    ->where('id','<>',$det->id)
                    ->where('nombre',$det->nombre)
                    ->count();
                if ($conteo > 0) {
                    return 2;
                }
                $acopiador->update([
                    'nombre' => $det->nombre,
                ]);
            }
            return 1;
        }
    }

    public function acopiador(Request $request, Acopiador $acopiador)
    {
        if ($request->ajax()) {
            return $acopiador->nombre;
        }
    }

    public function listdetalle(Request $request, $empacopiadora)
    {
        if($request->ajax()){
            $acopiador = Acopiador::select('id','nombre')
                ->where('empacopiadora_id', $empacopiadora)
                ->get();
            return response()->json($acopiador);
        }
    }

    public function tablaitem(Request $request, Empacopiadora $empacopiadora)
    {
        if ($request->ajax()) {
            return view('admin.empacopiadoras.detalle',compact('empacopiadora'));
        }
    }

    public function destroyitem (Request $request, Acopiador $acopiador)
    {
        $acopiador->delete();
    }
}

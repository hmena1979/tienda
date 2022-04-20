<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Destino;
use App\Models\Detdestino;

class DestinoController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
		$this->middleware('can:admin.destinos.index')->only('index');
		$this->middleware('can:admin.destinos.create')->only('create','store');
		$this->middleware('can:admin.destinos.edit')->only('edit','update');
    }

    public function index()
    {
        $destinos = Destino::where('empresa_id',session('empresa'))->orderBy('nombre')->get();
        return view('admin.destinos.index',compact('destinos'));
    }

    public function create()
    {
        return view('admin.destinos.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'nombre' => ['required',
                function($attribute, $value, $fail) {
                    $contador = Destino::where('nombre',$value)
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
            $destino = Destino::create($request->all());
            return redirect()->route('admin.destinos.edit',$destino)->with('store', 'Destino Agregado');
        }
    }

    public function show(Destino $destino)
    {
        //
    }

    public function edit(Destino $destino)
    {
        return view('admin.destinos.edit', compact('destino'));
    }

    public function update(Request $request, Destino $destino)
    {
        $rules = [
            'nombre' => [
                'required',
                Rule::unique('destinos')->where(function ($query) use ($destino) {
                    return $query->where('id','<>',$destino->id)
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
            $destino->update(['nombre' => $request->input('nombre')]);
            return redirect()->route('admin.destinos.index')->with('update', 'Destino Actualizado');
        }
    }

    public function destroy(Destino $destino)
    {
        //
    }

    public function aedet (Request $request, $envio) {
        if ($request->ajax()) {
            $det = json_decode($envio);
            if ($det->tipo == 1) {
                $conteo = Detdestino::where('destino_id',$det->id)->where('nombre',$det->nombre)->count();
                if ($conteo) {
                    return 2;
                }
                Detdestino::create([
                    'destino_id' => $det->id,
                    'nombre' => $det->nombre,
                ]);
            } else {
                $detdestino = Detdestino::findOrFail($det->id);
                $conteo = Detdestino::where('destino_id',$detdestino->destino_id)
                    ->where('id','<>',$det->id)
                    ->where('nombre',$det->nombre)
                    ->count();
                if ($conteo > 0) {
                    return 2;
                }
                $detdestino->update([
                    'nombre' => $det->nombre,
                ]);
            }
            return 1;
        }
    }

    public function detdestino(Request $request, Detdestino $detdestino)
    {
        if ($request->ajax()) {
            return $detdestino->nombre;
        }
    }

    public function listdetalle(Request $request, $destino)
    {
        if($request->ajax()){
            $detdestino = Detdestino::select('id','nombre')
                ->where('destino_id',$destino)
                ->get();
            return response()->json($detdestino);
        }
    }

    public function tablaitem(Request $request, Destino $destino)
    {
        if ($request->ajax()) {
            return view('admin.destinos.detalle',compact('destino'));
        }
    }

    public function destroyitem (Request $request, Detdestino $detdestino)
    {
        $detdestino->delete();
    }
}

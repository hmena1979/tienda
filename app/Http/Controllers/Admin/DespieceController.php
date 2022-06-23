<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Despiece;
use App\Models\Detdespiece;

class DespieceController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
		$this->middleware('can:admin.despieces.index')->only('index');
		$this->middleware('can:admin.despieces.create')->only('create','store');
		$this->middleware('can:admin.despieces.edit')->only('edit','update');
    }
    
    public function index()
    {
        $despieces = Despiece::where('empresa_id',session('empresa'))->orderBy('nombre')->get();
        return view('admin.despieces.index',compact('despieces'));
    }

    public function create()
    {
        return view('admin.despieces.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'nombre' => ['required',
                function($attribute, $value, $fail) {
                    $contador = Despiece::where('nombre',$value)
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
            $destino = Despiece::create($request->all());
            return redirect()->route('admin.despieces.edit',$destino)->with('store', 'Despiece Agregado');
        }
    }

    public function show(Despiece $despiece)
    {
        //
    }

    public function edit(Despiece $despiece)
    {
        return view('admin.despieces.edit', compact('despiece'));
    }

    public function update(Request $request, Despiece $despiece)
    {
        $rules = [
            'nombre' => [
                'required',
                Rule::unique('despieces')->where(function ($query) use ($despiece) {
                    return $query->where('id','<>',$despiece->id)
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
            $despiece->update(['nombre' => $request->input('nombre')]);
            return redirect()->route('admin.despieces.index')->with('update', 'Despiece Actualizado');
        }
    }

    public function destroy(Despiece $despiece)
    {
        // Error si tiene detalles
        if($despiece->detdespieces()->count() > 0){
            return redirect()->route('admin.despieces.index')->with('message', 'Se ha producido un error, No se puede eliminar, Contiene detalles')->with('typealert', 'danger');
        }
        $despiece->delete();
        return redirect()->route('admin.despieces.index')->with('destroy', 'Registro Eliminado');
    }

    public function aedet (Request $request, $envio) {
        if ($request->ajax()) {
            $det = json_decode($envio);
            if ($det->tipo == 1) {
                $conteo = Detdespiece::where('despiece_id',$det->id)->where('nombre',$det->nombre)->count();
                if ($conteo) {
                    return 2;
                }
                Detdespiece::create([
                    'despiece_id' => $det->id,
                    'nombre' => $det->nombre,
                    'porcentaje' => $det->porcentaje,
                ]);
            } else {
                $detdespiece = Detdespiece::findOrFail($det->id);
                $conteo = Detdespiece::where('despiece_id',$detdespiece->despiece_id)
                    ->where('id','<>',$det->id)
                    ->where('nombre',$det->nombre)
                    ->count();
                if ($conteo > 0) {
                    return 2;
                }
                $detdespiece->update([
                    'nombre' => $det->nombre,
                    'porcentaje' => $det->porcentaje,
                ]);
            }
            return 1;
        }
    }

    public function detdespiece(Request $request, Detdespiece $detdespiece)
    {
        if ($request->ajax()) {
            return response()->json($detdespiece);
        }
    }

    public function listdetalle(Request $request, $despiece)
    {
        if($request->ajax()){
            $detdespiece = Detdespiece::select('id','nombre','porcentaje')
                ->where('destino_id',$despiece)
                ->get();
            return response()->json($detdespiece);
        }
    }

    public function tablaitem(Request $request, Despiece $despiece)
    {
        if ($request->ajax()) {
            return view('admin.despieces.detalle',compact('despiece'));
        }
    }

    public function destroyitem (Request $request, Detdespiece $detdespiece)
    {
        $detdespiece->delete();
    }
}

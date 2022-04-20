<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Camara;
use App\Models\Chofer;
use App\Models\Transportista;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TransportistaController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
		$this->middleware('can:admin.transportistas.index')->only('index');
		$this->middleware('can:admin.transportistas.create')->only('create','store');
		$this->middleware('can:admin.transportistas.edit')->only('edit','update');
    }

    public function index()
    {
        $transportistas = Transportista::where('empresa_id',session('empresa'))->orderBy('nombre')->get();
        return view('admin.transportistas.index',compact('transportistas'));
    }

    public function create()
    {
        return view('admin.transportistas.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'ruc' => 'required',
            'nombre' => ['required',
                function($attribute, $value, $fail) {
                    $contador = Transportista::where('nombre',$value)
                        ->where('empresa_id',session('empresa'))
                        ->count();
                    if ($contador > 0) {
                        $fail(__('Ya se encuentra registrado'));
                    }
                }]
                
        ];
        $messages = [
    		'ruc.required' => 'Ingrese RUC.',
    		'nombre.required' => 'Ingrese Nombre.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            $transportista = Transportista::create($request->all());
            return redirect()->route('admin.transportistas.edit',$transportista)->with('store', 'Transportista Agregado');
        }
    }

    public function show(Transportista $transportista)
    {
        //
    }

    public function edit(Transportista $transportista)
    {
        return view('admin.transportistas.edit', compact('transportista'));
    }

    public function update(Request $request, Transportista $transportista)
    {
        $rules = [
            'ruc' => 'required',
            'nombre' => [
                'required',
                Rule::unique('transportistas')->where(function ($query) use ($transportista) {
                    return $query->where('id','<>',$transportista->id)
                        ->whereNull('deleted_at')
                        ->where('empresa_id',session('empresa'));
                }),
            ],
        ];

        $messages = [
            'ruc.required' => 'Ingrese RUC.',
    		'nombre.required' => 'Ingrese Nombre.',
    		'nombre.unique' => 'Ya fue registrado.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            $transportista->update(['nombre' => $request->input('nombre')]);
            return redirect()->route('admin.transportistas.index')->with('update', 'Transportista Actualizado');
        }
    }

    public function destroy(Transportista $transportista)
    {
        //
    }

    public function aedet (Request $request, $envio)
    {
        if ($request->ajax()) {
            $det = json_decode($envio);
            if ($det->tipo == 1) {
                $conteo = Chofer::where('transportista_id',$det->id)->where('nombre',$det->nombre)->count();
                if ($conteo) {
                    return 2;
                }
                Chofer::create([
                    'transportista_id' => $det->id,
                    'licencia' => $det->licencia,
                    'nombre' => $det->nombre,
                ]);
            } else {
                $chofer = Chofer::findOrFail($det->id);
                $conteo = Chofer::where('transportista_id',$chofer->transportista_id)
                    ->where('id','<>',$det->id)
                    ->where('nombre',$det->nombre)
                    ->count();
                if ($conteo > 0) {
                    return 2;
                }
                $chofer->update([
                    'licencia' => $det->licencia,
                    'nombre' => $det->nombre,
                ]);
            }
            return 1;
        }
    }

    public function chofer(Request $request, Chofer $chofer)
    {
        if ($request->ajax()) {
            return response()->json($chofer);
        }
    }

    public function listdetalle(Request $request, $transportista)
    {
        if($request->ajax()){
            $chofer = Chofer::select('id','nombre')
                ->where('transportista_id',$transportista)
                ->get();
            return response()->json($chofer);
        }
    }

    public function tablaitem(Request $request, Transportista $transportista)
    {
        if ($request->ajax()) {
            return view('admin.transportistas.detalle',compact('transportista'));
        }
    }

    public function destroyitem (Request $request, Chofer $chofer)
    {
        $chofer->delete();
    }

    //Camara
    public function aedetcamara (Request $request, $envio)
    {
        if ($request->ajax()) {
            $det = json_decode($envio);
            if ($det->tipo == 1) {
                $conteo = Camara::where('transportista_id',$det->id)->where('placa',$det->placa)->count();
                if ($conteo) {
                    return 2;
                }
                Camara::create([
                    'transportista_id' => $det->id,
                    'marca' => $det->marca,
                    'placa' => $det->placa,
                ]);
            } else {
                $camara = Camara::findOrFail($det->id);
                $conteo = Camara::where('transportista_id',$camara->transportista_id)
                    ->where('id','<>',$det->id)
                    ->where('placa',$det->placa)
                    ->count();
                if ($conteo > 0) {
                    return 2;
                }
                $camara->update([
                    'marca' => $det->marca,
                    'placa' => $det->placa,
                ]);
            }
            return 1;
        }
    }

    public function camara(Request $request, Camara $camara)
    {
        if ($request->ajax()) {
            return response()->json($camara);
        }
    }

    public function listdetallecamara(Request $request, $transportista)
    {
        if($request->ajax()){
            $camara = Camara::select('id','marca','placa')
                ->where('transportista_id',$transportista)
                ->get();
            return response()->json($camara);
        }
    }

    public function tablaitemcamara(Request $request, Transportista $transportista)
    {
        if ($request->ajax()) {
            return view('admin.transportistas.detallecamara',compact('transportista'));
        }
    }

    public function destroyitemcamara (Request $request, Camara $camara)
    {
        $camara->delete();
    }
}

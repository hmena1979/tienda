<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

use App\Models\Embarque;
use App\Models\Transportista;

class EmbarqueController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
		$this->middleware('can:admin.embarques.index')->only('index');
		$this->middleware('can:admin.embarques.create')->only('create','store');
		$this->middleware('can:admin.embarques.edit')->only('edit','update');
    }

    public function index($periodo = '000000')
    {
        if($periodo == '000000'){
            $periodo = session('periodo');
        }
        $embarques = Embarque::where('empresa_id', session('empresa'))
            ->where('periodo', $periodo)
            ->get();    
        return view('admin.embarques.index',compact('embarques','periodo'));
    }

    public function change(Request $request)
    {
        $periodo = $request->input('mes').$request->input('año');
        $embarques = Embarque::where('empresa_id', session('empresa'))
            ->where('periodo', $periodo)
            ->get();    
        return view('admin.embarques.index',compact('embarques','periodo'));
    }

    public function create()
    {
        $transportistas = Transportista::where('empresa_id',session('empresa'))
            ->orderBy('nombre')->pluck('nombre','id');
        $countries = Country::orderBy('nombre')->pluck('nombre','id');
        $stuffing = Country::orderBy('nombre')->pluck('nombre','id');
        $ffw = Country::orderBy('nombre')->pluck('nombre','id');
        $agaduana = Country::orderBy('nombre')->pluck('nombre','id');
        $release = Country::orderBy('nombre')->pluck('nombre','id');
        $pi2 = Country::orderBy('nombre')->pluck('nombre','id');
        $py = Country::orderBy('nombre')->pluck('nombre','id');
        $payt = Country::orderBy('nombre')->pluck('nombre','id');
        return view('admin.embarques.create',
            compact('transportistas','countries','stuffing','ffw','agaduana','release','pi2','py','payt'));
    }

    public function store(Request $request)
    {
        $rules = [
            'lote' => ['required',
                function($attribute, $value, $fail) {
                    $contador = Embarque::where('lote',$value)
                        ->where('empresa_id',session('empresa'))
                        ->count();
                    if ($contador > 0) {
                        $fail(__('Ya se encuentra registrado'));
                    }
                }],
            'cliente_id' => 'required',
        ];
        $messages = [
    		'lote.required' => 'Ingrese Lote.',
            'cliente_id.required' => 'Seleccione Lote',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            $embarque = Embarque::create($request->all());
            return redirect()->route('admin.embarques.edit',$embarque)->with('store', 'Registro agregado');
        }
    }

    public function show(Embarque $embarque)
    {
        //
    }

    public function edit(Embarque $embarque)
    {
        $transportistas = Transportista::where('empresa_id',session('empresa'))
            ->orderBy('nombre')->pluck('nombre','id');
        return view('admin.embarques.edit', compact('embarque','transportistas'));
    }

    public function update(Request $request, Embarque $embarque)
    {
        $rules = [
            'lote' => [
                'required',
                Rule::unique('embarques')->where(function ($query) use ($embarque) {
                    return $query->where('id','<>',$embarque->id)
                        ->whereNull('deleted_at')
                        ->where('empresa_id',session('empresa'));
                }),
            ],
            'cliente_id' => 'required',
        ];
        $messages = [
    		'lote.required' => 'Ingrese Número.',
    		'lote.unique' => 'Lote ya fue ingresado.',
    		'transportista_id.required' => 'Seleccione Transportista.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            $embarque->update($request->all());
            // return redirect()->route('admin.salcamaras.index')->with('update', 'Registro Actualizado');
            return redirect()->route('admin.embarques.edit',$embarque)->with('update', 'Registro Actualizado');
        }
    }

    public function destroy(Embarque $embarque)
    {
        $embarque->delete();
        return redirect()->route('admin.embarques.index')->with('destroy', 'Registro Eliminado');
    }
}

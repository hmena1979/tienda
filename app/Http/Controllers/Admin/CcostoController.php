<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Ccosto;

class CcostoController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
		$this->middleware('can:admin.ccostos.index')->only('index');
		$this->middleware('can:admin.ccostos.create')->only('create','store');
		$this->middleware('can:admin.ccostos.edit')->only('edit','update');
    }

    public function index()
    {
        $ccostos = Ccosto::where('empresa_id',session('empresa'))->orderBy('nombre')->get();
        return view('admin.ccostos.index',compact('ccostos'));
    }

    public function create()
    {
        return view('admin.ccostos.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'nombre' => ['required',
                function($attribute, $value, $fail) {
                    $contador = Ccosto::where('nombre',$value)
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
            Ccosto::create($request->all());
            return redirect()->route('admin.ccostos.index')->with('store', 'Centro de Costo Agregado');
        }
    }

    public function show(Ccosto $ccosto)
    {
        //
    }

    public function edit(Ccosto $ccosto)
    {
        return view('admin.ccostos.edit', compact('ccosto'));
    }

    public function update(Request $request, Ccosto $ccosto)
    {
        $rules = [
            'nombre' => [
                'required',
                Rule::unique('ccostos')->where(function ($query) use ($ccosto) {
                    return $query->where('id','<>',$ccosto->id)
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
            $ccosto->update(['nombre' => $request->input('nombre')]);
            return redirect()->route('admin.ccostos.index')->with('update', 'Centro de Costo Actualizado');
        }
    }

    public function destroy(Ccosto $ccosto)
    {
        // $ccosto->delete();
        return redirect()->route('admin.ccostos.index')->with('destroy', 'Centro de Costo Eliminado');
    }
}

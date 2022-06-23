<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contrata;
use App\Models\Parte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ContrataController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
		$this->middleware('can:admin.contratas.index')->only('index');
		$this->middleware('can:admin.contratas.create')->only('create','store');
		$this->middleware('can:admin.contratas.edit')->only('edit','update');
    }

    public function index()
    {
        $contratas = Contrata::where('empresa_id',session('empresa'))->get();    
        return view('admin.contratas.index',compact('contratas'));
    }

    public function create()
    {
        return view('admin.contratas.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'nombre' => ['required',
                function($attribute, $value, $fail) {
                    $contador = Contrata::where('nombre',$value)
                        ->where('empresa_id',session('empresa'))
                        ->count();
                    if ($contador > 0) {
                        $fail(__('Ya se encuentra registrado'));
                    }
                }],           
        ];
        $messages = [
    		'nombre.required' => 'Ingrese Nombre.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            Contrata::create($request->all());
            return redirect()->route('admin.contratas.index')->with('store', 'Registro agregado');
        }
    }

    public function show(Contrata $contrata)
    {
        //
    }

    public function edit(Contrata $contrata)
    {
        return view('admin.contratas.edit', compact('contrata'));
    }

    public function update(Request $request, Contrata $contrata)
    {
        $rules = [
            'nombre' => [
                'required',
                Rule::unique('contratas')->where(function ($query) use ($contrata) {
                    return $query->where('id','<>',$contrata->id)
                        ->whereNull('deleted_at')
                        ->where('empresa_id',session('empresa'));
                }),
            ],
        ];

        $messages = [
    		'nombre.required' => 'Ingrese Nombre.',
    		'nombre.unique' => 'Ya fue registrado.',
    		'cargo.required' => 'Ingrese cargo.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            $contrata->update($request->all());
            return redirect()->route('admin.contratas.index')->with('update', 'Registro Actualizado');
        }
    }

    public function destroy(Contrata $contrata)
    {
        if (Parte::where('contrata_id',$contrata->id)->count() > 0) {
            return back()->with('message', 'Se ha producido un error, Contrata ya esta contenido en un Parte de Producción')->with('typealert', 'danger');
        }
        $contrata->delete();
        return redirect()->route('admin.contratas.index')->with('destroy', 'Registro Eliminado');
    }
}

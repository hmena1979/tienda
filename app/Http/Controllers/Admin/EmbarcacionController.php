<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Embarcacion;

class EmbarcacionController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
		$this->middleware('can:admin.embarcaciones.index')->only('index');
		$this->middleware('can:admin.embarcaciones.create')->only('create','store');
		$this->middleware('can:admin.embarcaciones.edit')->only('edit','update');
		// $this->middleware('can:admin.categorias.permission')->only('editpermission','updatepermission');
		// $this->middleware('can:admin.categorias.password')->only('editpassword','updatepassword');
    }

    public function index()
    {
        $embarcaciones = Embarcacion::where('empresa_id',session('empresa'))->orderBy('nombre')->get();
        return view('admin.embarcaciones.index',compact('embarcaciones'));
    }

    public function create()
    {
        return view('admin.embarcaciones.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'nombre' => 'required',
            'matricula' => 'required',
            'protocolo' => 'required',
            'capacidad' => 'required',
        ];
        $messages = [
    		'nombre.required' => 'Ingrese Nombre.',
    		'matricula.required' => 'Ingrese Matrícula.',
    		'protocolo.required' => 'Ingrese Protoc. Sanipes.',
    		'capacidad.required' => 'Ingrese Capacidad.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            Embarcacion::create($request->all());
            return redirect()->route('admin.embarcaciones.index')->with('store', 'Embarcación Agregada');
        }
    }

    public function show(Embarcacion $embarcacion)
    {
        //
    }

    public function edit(Embarcacion $embarcacione)
    {
        return view('admin.embarcaciones.edit', compact('embarcacione'));
    }

    public function update(Request $request, Embarcacion $embarcacione)
    {
        $rules = [
            'nombre' => 'required',
            'matricula' => 'required',
            'protocolo' => 'required',
            'capacidad' => 'required',
        ];
        $messages = [
    		'nombre.required' => 'Ingrese Nombre.',
    		'matricula.required' => 'Ingrese Matrícula.',
    		'protocolo.required' => 'Ingrese Protoc. Sanipes.',
    		'capacidad.required' => 'Ingrese Capacidad.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            $embarcacione->update($request->all());
            return redirect()->route('admin.embarcaciones.index')->with('update', 'Embarcación Actualizada');
        }
    }

    public function destroy(Embarcacion $embarcacione)
    {
        $embarcacione->delete();
        return redirect()->route('admin.embarcaciones.index')->with('destroy', 'Embarcación Eliminada');
    }
}

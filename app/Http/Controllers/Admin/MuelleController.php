<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Muelle;

class MuelleController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
		$this->middleware('can:admin.muelles.index')->only('index');
		$this->middleware('can:admin.muelles.create')->only('create','store');
		$this->middleware('can:admin.muelles.edit')->only('edit','update');
    }

    public function index()
    {
        $muelles = Muelle::where('empresa_id',session('empresa'))->orderBy('nombre')->get();
        return view('admin.muelles.index',compact('muelles'));
    }

    public function create()
    {
        return view('admin.muelles.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'nombre' => 'required',
            'protocolo' => 'required',
        ];
        $messages = [
    		'nombre.required' => 'Ingrese Nombre.',
    		'protocolo.required' => 'Ingrese Protoc. Sanipes.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            Muelle::create($request->all());
            return redirect()->route('admin.muelles.index')->with('store', 'Muelle Agregado');
        }
    }

    public function show(Muelle $muelle)
    {
        //
    }

    public function edit(Muelle $muelle)
    {
        return view('admin.muelles.edit', compact('muelle'));
    }

    public function update(Request $request, Muelle $muelle)
    {
        $rules = [
            'nombre' => 'required',
            'protocolo' => 'required',
        ];
        $messages = [
    		'nombre.required' => 'Ingrese Nombre.',
    		'protocolo.required' => 'Ingrese Protoc. Sanipes.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            $muelle->update($request->all());
            return redirect()->route('admin.muelles.index')->with('update', 'Muelle Actualizado');
        }
    }

    public function destroy(Muelle $muelle)
    {
        $muelle->delete();
        return redirect()->route('admin.muelles.index')->with('destroy', 'Muelles Eliminado');
    }
}

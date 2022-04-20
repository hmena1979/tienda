<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Catproducto;

class CatproductoController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
		$this->middleware('can:admin.catproductos.index')->only('index');
		$this->middleware('can:admin.catproductos.create')->only('create','store');
		$this->middleware('can:admin.catproductos.edit')->only('edit','update');
    }

    public function index($module = 1)
    {
        $cats = Catproducto::where('modulo', $module)->orderBy('nombre','Asc')->get();
        
        $data = [
            'cats' => $cats,
            'module'=>$module
        ];
    	return view('admin.catproductos.index', $data);
    }

    public function create($module)
    {
        $data = [
            'module'=>$module,
        ];
        return view('admin.catproductos.create', $data);
    }

    public function store(Request $request)
    {
        $rules = [
            'nombre' => 'required'
        ];
        $messages = [
    		'nombre.required' => 'Ingrese Nombre.'
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            Catproducto::create($request->all());
            return redirect()->route('admin.catproductos.index',$request->input('modulo'))->with('store', 'Categoria Agregada');
        }
    }

    public function show(Catproducto $catproducto)
    {
        //
    }

    public function edit(Catproducto $catproducto)
    {
        return view('admin.catproductos.edit', compact('catproducto'));
    }

    public function update(Request $request, Catproducto $catproducto)
    {
        $rules = [
            'nombre' => 'required'
        ];
        $messages = [
    		'nombre.required' => 'Ingrese Nombre.'
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            $catproducto->update($request->all());
            return redirect()->route('admin.catproductos.index',$request->input('modulo'))->with('update', 'Categoria Actualizada');
        }
    }

    public function destroy(Catproducto $catproducto)
    {
        //
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Umedida;

class UMedidaController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
		$this->middleware('can:admin.umedidas.index')->only('index');
		$this->middleware('can:admin.umedidas.create')->only('create','store');
		$this->middleware('can:admin.umedidas.edit')->only('edit','update');
		// $this->middleware('can:admin.categorias.permission')->only('editpermission','updatepermission');
		// $this->middleware('can:admin.categorias.password')->only('editpassword','updatepassword');
    }

    public function index()
    {
        $umedidas = Umedida::all();
        return view('admin.umedidas.index', compact('umedidas'));
    }

    public function create()
    {
        return view('admin.umedidas.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'codigo' => 'required|unique:umedidas',
            'nombre' => 'required'
        ];
        $messages = [
    		'codigo.required' => 'Ingrese Código.',
            'codigo.unique' => 'Código de Unidad de Medida ya existe.',
    		'nombre.required' => 'Ingrese Nombre.'
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            Umedida::create($request->all());
            return redirect()->route('admin.umedidas.index')->with('store', 'Unidad de Medida Agregada');
        }
    }

    public function show($id)
    {
        //
    }

    public function edit(Umedida $umedida)
    {
        return view('admin.umedidas.edit', compact('umedida'));
    }

    public function update(Request $request, Umedida $umedida)
    {
        $rules = [
            'codigo' => "required|unique:umedidas,codigo,$umedida->id",
            'nombre' => "required"
        ];
        $messages = [
    		'codigo.required' => 'Ingrese Código.',
    		'codigo.unique' => 'Código de Unidad de Medida ya existe.',
    		'nombre.unique' => 'Ingrese Nombre.'
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            $umedida->update($request->all());
            return redirect()->route('admin.umedidas.index')->with('update', 'Unidad de Medida Actualizada');
        }
    }

    public function destroy(Umedida $umedida)
    {
        $umedida->delete();
        return redirect()->route('admin.umedidas.index')->with('destroy', 'Unidad de Medida Eliminada');
    }
}

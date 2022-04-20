<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Detraccion;

class DetraccionController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
		$this->middleware('can:admin.detraccions.index')->only('index');
		$this->middleware('can:admin.detraccions.create')->only('create','store');
		$this->middleware('can:admin.detraccions.edit')->only('edit','update');
		// $this->middleware('can:admin.categorias.permission')->only('editpermission','updatepermission');
		// $this->middleware('can:admin.categorias.password')->only('editpassword','updatepassword');
    }

    public function index()
    {
        $detraccions = Detraccion::get();
        return view('admin.detraccions.index', compact('detraccions'));
    }

    public function create()
    {
        return view('admin.detraccions.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'codigo' => 'required|unique:detraccions',
            'nombre' => 'required|unique:detraccions',
            'tasa' => 'required'
        ];
        $messages = [
    		'codigo.required' => 'Ingrese Código.',
            'codigo.unique' => 'Código de Detracción ya existe.',
    		'nombre.required' => 'Ingrese Nombre.',
    		'nombre.unique' => 'Nombre de Detracción ya existe.',
    		'tasa.required' => 'Ingrese Tasa.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            Detraccion::create($request->all());
            return redirect()->route('admin.detraccions.index')->with('store', 'Detracción Agregada');
        }
    }

    public function show(Detraccion $detraccion)
    {
        //
    }

    public function edit(Detraccion $detraccion)
    {
        return view('admin.detraccions.edit', compact('detraccion'));
    }

    public function update(Request $request, Detraccion $detraccion)
    {
        $rules = [
            'codigo' => "required|unique:detraccions,codigo,$detraccion->id",
            'nombre' => "required|unique:detraccions,nombre,$detraccion->id",
            'tasa' => 'required'
        ];
        $messages = [
    		'codigo.required' => 'Ingrese Código.',
            'codigo.unique' => 'Código de Detracción ya existe.',
    		'nombre.required' => 'Ingrese Nombre.',
    		'nombre.unique' => 'Nombre de Detracción ya existe.',
    		'tasa.required' => 'Ingrese Tasa.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            $detraccion->update($request->all());
            return redirect()->route('admin.detraccions.index')->with('update', 'Detracción Actualizada');
        }
    }

    public function destroy(Detraccion $detraccion)
    {
        $detraccion->delete();
        return redirect()->route('admin.detraccions.index')->with('destroy', 'Detracción Eliminada');
    }

    public function tasa($codigo)
    {
        $tasa = Detraccion::where('codigo',$codigo)->value('tasa');
        return $tasa;
    }
}

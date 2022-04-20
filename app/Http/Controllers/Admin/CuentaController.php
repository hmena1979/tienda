<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Models\Cuenta;
use App\Models\Categoria;

class CuentaController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
		$this->middleware('can:admin.cuentas.index')->only('index');
		$this->middleware('can:admin.cuentas.create')->only('create','store');
		$this->middleware('can:admin.cuentas.edit')->only('edit','update');
		// $this->middleware('can:admin.categorias.permission')->only('editpermission','updatepermission');
		// $this->middleware('can:admin.categorias.password')->only('editpassword','updatepassword');
    }

    public function index()
    {
        if(session('principal') == 1){
            $cuentas = Cuenta::where('empresa_id',Auth::user()->empresa)->get();
        }else{
            $cuentas = Cuenta::where('empresa_id',Auth::user()->empresa)->where('sede_id',Auth::user()->sede)->get();
        }
        
        return view('admin.cuentas.index',compact('cuentas'));
    }

    public function create()
    {
        $moneda = Categoria::where('modulo', 4)->pluck('nombre','codigo');
        return view('admin.cuentas.create', compact('moneda'));
    }

    public function store(Request $request)
    {
        $rules = [
            'nombre' => 'required|unique:cuentas'
        ];
        
        $messages = [
    		'nombre.required' => 'Ingrese Nombre.',
    		'nombre.unique' => 'Nombre ya fue Ingresado.'
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            Cuenta::create($request->all());
            return redirect()->route('admin.cuentas.index')->with('store', 'Cuenta Agregada');
        }
    }

    public function show(Cuenta $cuenta)
    {
        //
    }

    public function edit(Cuenta $cuenta)
    {
        $moneda = Categoria::where('modulo', 4)->pluck('nombre','codigo');
        return view('admin.cuentas.edit', compact('cuenta','moneda'));
    }

    public function update(Request $request, Cuenta $cuenta)
    {
        $rules = [
            'nombre' => "required|unique:cuentas,nombre,$cuenta->id"
        ];
        
        $messages = [
    		'nombre.required' => 'Ingrese Nombre.',
    		'nombre.unique' => 'Nombre ya fue Ingresado.'
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            $cuenta->update($request->all());
            return redirect()->route('admin.cuentas.index')->with('update', 'Cuenta Actualizada');
        }
    }

    public function destroy(Cuenta $cuenta)
    {
        $cuenta->delete();
        return redirect()->route('admin.cuentas.index')->with('destroy', 'Cuenta Eliminada');
    }

    public function moneda(Request $request, $moneda)
    {
    	if($request->ajax()){
    		$cuentas = Cuenta::select('id','nombre')->where('moneda',$moneda)->get();
    		return response()->json($cuentas);
    	}
    }
}

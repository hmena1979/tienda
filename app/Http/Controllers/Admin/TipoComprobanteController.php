<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\TipoComprobante;

class TipoComprobanteController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
		$this->middleware('can:admin.tipocomprobantes.index')->only('index');
		$this->middleware('can:admin.tipocomprobantes.create')->only('create','store');
		$this->middleware('can:admin.tipocomprobantes.edit')->only('edit','update');
		// $this->middleware('can:admin.categorias.permission')->only('editpermission','updatepermission');
		// $this->middleware('can:admin.categorias.password')->only('editpassword','updatepassword');
    }

    public function index()
    {
        $tipocomprobantes = TipoComprobante::all();
        return view('admin.tipocomprobantes.index', compact('tipocomprobantes'));
    }

    public function create()
    {
        return view('admin.tipocomprobantes.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'codigo' => 'required|unique:tipo_comprobantes',
            'nombre' => 'required|unique:tipo_comprobantes'
        ];
        $messages = [
    		'codigo.required' => 'Ingrese Código.',
            'codigo.unique' => 'Código ya se encuentra registrado.',
    		'nombre.required' => 'Ingrese Nombre.',
    		'nombre.unique' => 'Nombre ya se encuentra registrado.'
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            TipoComprobante::create($request->all());
            return redirect()->route('admin.tipocomprobantes.index')->with('store', 'Tipo de Documento Agregado');
        }
    }

    public function show(TipoComprobante $tipocomprobante)
    {
        //
    }

    public function edit(TipoComprobante $tipocomprobante)
    {
        return view('admin.tipocomprobantes.edit', compact('tipocomprobante'));
    }

    public function update(Request $request, TipoComprobante $tipocomprobante)
    {
        $rules = [
            'codigo' => "required|unique:tipo_comprobantes,codigo,$tipocomprobante->id",
            'nombre' => "required|unique:tipo_comprobantes,nombre,$tipocomprobante->id"
        ];
        $messages = [
    		'codigo.required' => 'Ingrese Código.',
            'codigo.unique' => 'Código ya se encuentra registrado.',
    		'nombre.required' => 'Ingrese Nombre.',
    		'nombre.unique' => 'Nombre ya se encuentra registrado.'
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            $tipocomprobante->update($request->all());
            return redirect()->route('admin.tipocomprobantes.index')->with('update', 'Tipo de Comprobante Actualizado');
        }
    }

    public function destroy(TipoComprobante $tipocomprobante)
    {
        $tipocomprobante->delete();
        return redirect()->route('admin.tipocomprobantes.index')->with('destroy', 'Tipo de Comprobante Eliminado');
    }

    public function search($codigo)
    {
        $tipo = TipoComprobante::where('codigo',$codigo)->value('tipo');
        return $tipo;
    }
}

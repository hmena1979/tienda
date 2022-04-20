<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Categoria;

class CategoriaController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
		$this->middleware('can:admin.categorias.index')->only('index');
		$this->middleware('can:admin.categorias.create')->only('create','store');
		$this->middleware('can:admin.categorias.edit')->only('edit','update');
		// $this->middleware('can:admin.categorias.permission')->only('editpermission','updatepermission');
		// $this->middleware('can:admin.categorias.password')->only('editpassword','updatepassword');
    }

    public function index($module = 1)
    {
        $cats = Categoria::where('modulo', $module)->orderBy('nombre','Asc')->get();
        //(0)Tipo documento / (1)Tipo paciente / (2)Sexo / (3)Estado civil
        switch ($module){
            case '1':
                $titulo = 'Código Sunat';
                break;
            default:
                $titulo = 'Código';
                break;
        }
        
        $data = [
            'cats' => $cats,
            'module'=>$module,
            'titulo'=>$titulo
        ];
    	return view('admin.categorias.index', $data);
    }

    public function create($module)
    {
        switch ($module){
            case '1':
                $titulo = 'Código Sunat';
                break;
            default:
                $titulo = 'Código';
                break;
        }
        $data = [
            'module'=>$module,
            'titulo'=>$titulo
        ];
        return view('admin.categorias.create', $data);
    }

    public function store(Request $request)
    {
        $rules = [
            'codigo' => 'required',
            'nombre' => 'required'
        ];
        $messages = [
    		'codigo.required' => 'Ingrese Código.',
    		'nombre.required' => 'Ingrese Nombre.'
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            Categoria::create($request->all());
            return redirect()->route('admin.categorias.index',$request->input('modulo'))->with('store', 'Categoria Agregada');
        }
    }

    public function edit(Categoria $categoria)
    {
        switch ($categoria->modulo){
            case '1':
                $titulo = 'Código Sunat';
                break;
            default:
                $titulo = 'Código';
                break;
        }
        return view('admin.categorias.edit', compact('categoria','titulo'));
    }

    public function update(Request $request, Categoria $categoria)
    {
        $rules = [
            'codigo' => 'required',
            'nombre' => 'required'
        ];
        $messages = [
    		'codigo.required' => 'Ingrese Código.',
    		'nombre.required' => 'Ingrese Nombre.'
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            $categoria->update($request->all());
            return redirect()->route('admin.categorias.index',$request->input('modulo'))->with('update', 'Categoria Actualizada');
        }
    }

    public function destroy(Categoria $categoria)
    {
        $categoria->delete();
        return redirect()->route('admin.categorias.index',$categoria->modulo)->with('destroy', 'Registro Eliminado');
    }
    
}

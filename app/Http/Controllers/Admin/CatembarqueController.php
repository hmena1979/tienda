<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Catembarque;

class CatembarqueController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
		$this->middleware('can:admin.catembarques.index')->only('index');
		$this->middleware('can:admin.catembarques.create')->only('create','store');
		$this->middleware('can:admin.catembarques.edit')->only('edit','update');
    }

    public function index($module = 1)
    {
        $cats = Catembarque::where('modulo', $module)->orderBy('nombre','Asc')->get();
        
        $data = [
            'cats' => $cats,
            'module'=>$module
        ];
    	return view('admin.catembarques.index', $data);
    }

    public function create($module)
    {
        $data = [
            'module'=>$module,
        ];
        return view('admin.catembarques.create', $data);
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
            Catembarque::create($request->all());
            return redirect()->route('admin.catembarques.index',$request->input('modulo'))->with('store', 'Categoria Agregada');
        }
    }

    public function show(Catembarque $catembarque)
    {
        //
    }

    public function edit(Catembarque $catembarque)
    {
        return view('admin.catembarques.edit', compact('catembarque'));
    }

    public function update(Request $request, Catembarque $catembarque)
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
            $catembarque->update($request->all());
            return redirect()->route('admin.catembarques.index',$request->input('modulo'))->with('update', 'Categoria Actualizada');
        }
    }

    public function destroy(Catembarque $catembarque)
    {
        //
    }
}

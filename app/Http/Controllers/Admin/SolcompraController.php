<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\Solcompra;
use App\Models\Destino;
use App\Models\User;

class SolcompraController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
		$this->middleware('can:admin.solcompras.index')->only('index');
		$this->middleware('can:admin.solcompras.create')->only('create','store');
		$this->middleware('can:admin.solcompras.edit')->only('edit','update');
		// $this->middleware('can:admin.categorias.permission')->only('editpermission','updatepermission');
		// $this->middleware('can:admin.categorias.password')->only('editpassword','updatepassword');
    }

    public function index($periodo = '000000')
    {
        if($periodo == '000000'){
            $periodo = session('periodo');
        }
        
        $solcompras = Solcompra::with(['user'])
            ->select('id','user_id','fecha','estado','observaciones') 
            ->where('periodo',$periodo)
            ->where('empresa_id',session('empresa'))
            ->where('sede_id',session('sede'))
            ->get();

        $estados = [
            1 => 'PENDIENTE',
            2 => 'SOLICITADO',
            3 => 'RECEPCIONADO',
            4 => 'ATENDIDO',
            5 => 'RECHAZADO',
            6 => 'FINALIZADO',
        ];
        $colores = [
            1 => 'negro',
            2 => 'negrita',
            3 => 'azul',
            4 => 'verde',
            5 => 'rojo',
            6 => 'verde negrita',
        ];
        return view('admin.solcompras.index',compact('solcompras','periodo','estados','colores'));
    }

    public function change(Request $request)
    {
        $periodo = $request->input('mes').$request->input('año');
        $solcompras = Solcompra::with(['user'])
            ->select('id','user_id','fecha','estado','observaciones') 
            ->where('periodo',$periodo)
            ->where('empresa_id',session('empresa'))
            ->where('sede_id',session('sede'))
            ->get();
        $estados = [
            1 => 'PENDIENTE',
            2 => 'SOLICITADO',
            3 => 'RECEPCIONADO',
            4 => 'ATENDIDO',
            5 => 'RECHAZADO',
            6 => 'FINALIZADO',
        ];
        $colores = [
            1 => 'negro',
            2 => 'negrita',
            3 => 'azul',
            4 => 'verde',
            5 => 'rojo',
            6 => 'verde negrita',
        ];

        return view('admin.solcompras.index',compact('solcompras','periodo','estados','colores'));
    }

    public function create()
    {
        $users = User::where('id',Auth::user()->id)->pluck('name','id');
        $destinos = Destino::where('empresa_id',session('empresa'))->orderBy('nombre')->pluck('nombre','id');
        // $lotes = Lote::OrderBy('lote','desc')->take(15)->pluck('lote','lote');
        return view('admin.solcompras.create', compact('users','destinos'));
    }

    public function store(Request $request)
    {
        $rules = [
            'fecha' => 'required',
        ];
        $messages = [
    		'fecha.required' => 'Ingrese fecha.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            $solcompra = Solcompra::create($request->except('destino_id'));
            return redirect()->route('admin.solcompras.edit',$solcompra)->with('store', 'Registro Agregado, Ingrese los productos');
        }
    }

    public function show(Solcompra $solcompra)
    {
        //
    }

    public function edit(Solcompra $solcompra)
    {
        $users = User::where('id',$solcompra->user_id)->pluck('name','id');
        $destinos = Destino::where('empresa_id',session('empresa'))->orderBy('nombre')->pluck('nombre','id');
        // $detdestinos = Detdestino::where('destino_id',$destino)->orderBy('nombre')->pluck('nombre','id');
        // $lotes = Lote::where('empresa_id',session('empresa'))->OrderBy('lote','desc')->take(15)->pluck('lote','lote');
        
        return view('admin.solcompras.edit',
            compact('solcompra','users','destinos'));
    }

    public function update(Request $request, Solcompra $solcompra)
    {
        $rules = [
            'fecha' => 'required',
        ];
        $messages = [
    		'fecha.required' => 'Ingrese fecha.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            $solcompra->update($request->except('destino_id','procesa'));
            return redirect()->route('admin.solcompras.index')->with('store', 'Registro Actualizado');
        }
    }

    public function destroy(Solcompra $solcompra)
    {
        if($solcompra->detsolcompras()->count() > 0){
            return redirect()->route('admin.solcompras.index')->with('message', 'Se ha producido un error, No se puede eliminar, Pedido ya contiene productos')->with('typealert', 'danger');
        }
        $solcompra->delete();

        return redirect()->route('admin.solcompras.index')->with('destroy', 'Registro Eliminado');
    }

    public function tablaitem(Solcompra $solcompra)
    {
        return view('admin.solcompras.detalle',compact('solcompra'));
    }
}

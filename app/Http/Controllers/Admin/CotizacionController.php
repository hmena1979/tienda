<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreDetcotizacionRequest;
use App\Models\Cotizacion;
use App\Models\Detcotizacion;
use App\Models\Categoria;
use App\Models\Cliente;
use Illuminate\Support\Facades\Storage;

class CotizacionController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
		$this->middleware('can:admin.cotizacions.index')->only('index');
		$this->middleware('can:admin.cotizacions.create')->only('create','store');
		$this->middleware('can:admin.cotizacions.edit')->only('edit','update');
		// $this->middleware('can:admin.categorias.permission')->only('editpermission','updatepermission');
		// $this->middleware('can:admin.categorias.password')->only('editpassword','updatepassword');
    }
    public function index($periodo = '000000')
    {
        if($periodo == '000000'){
            $periodo = session('periodo');
        }
        $cotizacions = Cotizacion::with(['cliente'])
            ->select('id','fecha','cliente_id','moneda','numero','contacto','total')
            ->where('periodo',$periodo)
            ->where('empresa_id',session('empresa'))
            ->where('sede_id',session('sede'))
            ->get();
        return view('admin.cotizacions.index',compact('cotizacions','periodo'));
    }

    public function change(Request $request)
    {
        $periodo = $request->input('mes').$request->input('año');
        $cotizacions = Cotizacion::with(['cliente'])
            ->select('id','fecha','cliente_id','moneda','numero','contacto','total')
            ->where('periodo',$periodo)
            ->where('empresa_id',session('empresa'))
            ->where('sede_id',session('sede'))
            ->get();

        return view('admin.cotizacions.index', compact('cotizacions','periodo'));
    }

    public function create()
    {
        $tipdoc = Categoria::where('modulo', 1)->orderBy('codigo')->pluck('nombre','codigo');
        return view('admin.cotizacions.create',compact('tipdoc'));
    }

    public function store(Request $request)
    {
        $rules = [
            'fecha' => 'required',
            'cliente_id' => 'required',
            'numero' => 'required',
        ];
        $messages = [
    		'fecha.required' => 'Ingrese fecha.',
    		'cliente_id.required' => 'Seleccione Proveedor.',
    		'numero.required' => 'Ingrese número.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            $cotizacion = Cotizacion::create($request->all());
            return redirect()->route('admin.cotizacions.edit',$cotizacion)->with('store', 'Cotización Agregada, Ingrese los productos');
        }
    }

    public function show(Cotizacion $cotizacion)
    {
        //
    }

    public function edit(Cotizacion $cotizacion)
    {
        $tipdoc = Categoria::where('modulo', 1)->orderBy('codigo')->pluck('nombre','codigo');
        $clientes = Cliente::where('id',$cotizacion->cliente_id)->get()->pluck('numdoc_razsoc','id');
        return view('admin.cotizacions.edit',
            compact('cotizacion','tipdoc','clientes'));
    }

    public function update(Request $request, Cotizacion $cotizacion)
    {
        $rules = [
            'fecha' => 'required',
            'cliente_id' => 'required',
            'numero' => 'required',
        ];
        $messages = [
    		'fecha.required' => 'Ingrese fecha.',
    		'cliente_id.required' => 'Seleccione Proveedor.',
    		'numero.required' => 'Ingrese número.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            if($request->hasFile('file')){
                if($cotizacion->file) {
                    Storage::disk('cotizaciones')->delete($cotizacion->file);
                }
                $archivo = $request->file('file');
                Storage::disk('cotizaciones')->makeDirectory($request->input('cliente_id'));
                $file = Storage::disk('cotizaciones')->put($request->input('cliente_id'), $archivo);
            } else {
                $file = $cotizacion->file;
            }
            $data = $request->except('file');
            $data = array_merge($data,[
                'file' => $file,
            ]);
            $cotizacion->update($data);
            return redirect()->route('admin.cotizacions.index')->with('update', 'Cotización Actualizada');
        }
    }

    public function destroy(Cotizacion $cotizacion)
    {
        if($cotizacion->detcotizacions->count() > 0){
            return redirect()->route('admin.cotizacions.index')->with('message', 'Se ha producido un error, No se puede eliminar, Cotización ya contiene productos')->with('typealert', 'danger');
        }
        $cotizacion->delete();

        return redirect()->route('admin.cotizacions.index')->with('destroy', 'Registro Eliminado');
    }

    public function tablaitem(Cotizacion $cotizacion)
    {
        $total = $cotizacion->total;
        return view('admin.cotizacions.detalle',compact('cotizacion','total'));
    }

    public function additem(StoreDetcotizacionRequest $request)
    {
        if ($request->ajax()) {
            Detcotizacion::create($request->all());
            $suma = Detcotizacion::where('cotizacion_id',$request->input('cotizacion_id'))->sum('subtotal');
            Cotizacion::where('id',$request->input('cotizacion_id'))->update(['total' => $suma]);
            return true;
        }
    }

    public function destroyitem(Detcotizacion $detcotizacion){
        $idCotizacion = $detcotizacion->cotizacion_id;
        $detcotizacion->delete();
        $suma = Detcotizacion::where('cotizacion_id',$idCotizacion)->sum('subtotal');
        Cotizacion::where('id',$idCotizacion)->update(['total' => $suma]);
        return 1;
    }
}

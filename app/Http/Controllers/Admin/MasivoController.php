<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cuenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Masivo;
use App\Models\Rcompra;

class MasivoController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
		$this->middleware('can:admin.masivos.index')->only('index');
		$this->middleware('can:admin.masivos.create')->only('create','store');
		$this->middleware('can:admin.masivos.edit')->only('edit','update');
    }

    public function index($periodo = '000000')
    {
        if($periodo == '000000'){
            $periodo = session('periodo');
        }
        $estado = [1=>'PENDIENTE', 2=>'APROBADO', 3=>'GENERADO'];
        $masivos = Masivo::where('periodo',$periodo)
            ->where('empresa_id',session('empresa'))
            ->where('sede_id',session('sede'))
            ->get();
        return view('admin.masivos.index', compact('masivos','periodo','estado'));
    }

    public function change(Request $request)
    {
        $periodo = $request->input('mes').$request->input('año');
        $estado = [1=>'PENDIENTE', 2=>'APROBADO', 3=>'GENERADO'];
        $masivos = Masivo::where('periodo',$periodo)
            ->where('empresa_id',session('empresa'))
            ->where('sede_id',session('sede'))
            ->get();
        return view('admin.masivos.index', compact('masivos','periodo','estado'));
    }

    public function create()
    {
        $cuentas = Cuenta::where('empresa_id',session('empresa'))
            ->where('sede_id',session('sede'))
            ->pluck('nombre','id');


        return view('admin.masivos.create', compact('cuentas'));
    }

    public function store(Request $request)
    {
        $rules = [
            'cuenta_id' => 'required',
            'fecha' => 'required',
            'tc' => 'required',
            'glosa' => 'required'
        ];
        
        $messages = [
    		'cuenta_id.required' => 'Seleccione Cuenta.',
    		'fecha.required' => 'Ingrese Fecha.',
    		'tc.required' => 'Ingrese Tipo de Cambio.',
    		'glosa.required' => 'Ingrese Glosa.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            $masivo = Masivo::create($request->all());
            return redirect()->route('admin.masivos.edit',$masivo)->with('store', 'Registro Agregado, Ingrese detalle');
        }
    }

    public function show(Masivo $masivo)
    {
        //
    }

    public function edit(Masivo $masivo)
    {
        $cuentas = Cuenta::where('empresa_id',session('empresa'))
            ->where('sede_id',session('sede'))
            ->pluck('nombre','id');

        return view('admin.masivos.edit', compact('masivo','cuentas'));
    }

    public function update(Request $request, Masivo $masivo)
    {
        //
    }

    public function destroy(Masivo $masivo)
    {
        //
    }

    public function tablaitem(Masivo $masivo)
    {
        return view('admin.masivos.detalle',compact('masivo'));
    }

    public function pendientes()
    {
    	// if($request->ajax()){
    		$rcompras = Rcompra::with(['cliente'])
                ->select('id','cliente_id','vencimiento','moneda','tipocomprobante_codigo','serie','numero','saldo')
                ->where('saldo','>',0)
                ->get();
            return view('admin.masivos.pendientes',compact('rcompras'));
    	// }
    }
}

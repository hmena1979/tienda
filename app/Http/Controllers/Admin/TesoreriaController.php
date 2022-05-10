<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Models\Tesoreria;
use App\Models\Dettesor;
use App\Models\Cuenta;
use App\Models\Categoria;
use App\Models\Rcompra;

class TesoreriaController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
		$this->middleware('can:admin.tesorerias.index')->only('index');
		$this->middleware('can:admin.tesorerias.create')->only('create','store');
		$this->middleware('can:admin.tesorerias.edit')->only('edit','update','detstore');
		// $this->middleware('can:admin.categorias.permission')->only('editpermission','updatepermission');
		// $this->middleware('can:admin.categorias.password')->only('editpassword','updatepassword');
    }

    public function index($periodo = '000000',$cuenta = 0)
    {
        if(session('principal') == 1){
            $cuentas = Cuenta::select('id','nombre')
                ->where('empresa_id',Auth::user()->empresa)
                ->get();
        }else{
            $cuentas = Cuenta::select('id','nombre')
                ->where('empresa_id',Auth::user()->empresa)
                ->where('sede_id',Auth::user()->sede)
                ->get();
        }
        if ($cuentas->count() == 0) {
            return "Agregue primero una cuenta";
        }
        if($periodo == '000000'){
            $periodo = session('periodo');
        }
        if($cuenta == 0){
            $cuenta = $cuentas[0]->id;
        }
        $tesorerias = Tesoreria::with(['mediopagos'])
            ->select('id','cuenta_id','tipo','edit','fecha','mediopago','numerooperacion','glosa','monto')
            ->where('periodo',$periodo)
            ->where('cuenta_id',$cuenta)
            ->get();
        return view('admin.tesorerias.index', compact('tesorerias','cuentas','periodo','cuenta'));
    }

    public function change(Request $request)
    {
        $periodo = $request->input('mes').$request->input('año');
        if(session('principal') == 1){
            $cuentas = Cuenta::select('id','nombre')
                ->where('empresa_id',Auth::user()->empresa)
                ->get();
        }else{
            $cuentas = Cuenta::select('id','nombre')
                ->where('empresa_id',Auth::user()->empresa)
                ->where('sede_id',Auth::user()->sede)
                ->get();
        }
        $cuenta = $request->input('cuenta');
        $tesorerias = Tesoreria::with(['mediopagos'])
            ->select('id','cuenta_id','tipo','edit','fecha','mediopago','numerooperacion','glosa','monto')
            ->where('periodo',$periodo)
            ->where('cuenta_id',$cuenta)
            ->get();
            return view('admin.tesorerias.index', compact('tesorerias','cuentas','periodo','cuenta'));
    }

    public function create($cuenta)
    {
        $moneda = Categoria::where('modulo', 4)->pluck('nombre','codigo');
        // $clientes = Cliente::where('id',$rcompra->cliente_id)->get()->pluck('numdoc_razsoc','id');
        $tipooperacion = Categoria::where('modulo', 7)->pluck('nombre','codigo');
        $mediopago = Categoria::where('modulo', 5)->pluck('nombre','codigo');

        if(session('principal') == 1){
            $cuentas = Cuenta::where('empresa_id',Auth::user()->empresa)
                ->pluck('nombre','id');
        }else{
            $cuentas = Cuenta::where('empresa_id',Auth::user()->empresa)
                ->where('sede_id',Auth::user()->sede)
                ->pluck('nombre','id');
        }

        return view('admin.tesorerias.create',
            compact('moneda','tipooperacion',
            'mediopago','cuentas','cuenta'));
    }

    public function store(Request $request)
    {
        $rules = [
            'fecha' => 'required',
            'tc' => 'required',
            'mediopago' => 'required',
            'numerooperacion' => 'required',
            'glosa' => 'required'
        ];
        
        $messages = [
    		'fecha.required' => 'Ingrese Fecha.',
    		'tc.required' => 'Ingrese Tipo de Cambio.',
    		'mediopago.required' => 'Ingrese Medio Pago.',
    		'numerooperacion.required' => 'Ingrese Número Operación.',
    		'glosa.required' => 'Ingrese Glosa.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            $tesoreria = Tesoreria::create($request->all());
            return redirect()->route('admin.tesorerias.edit',$tesoreria)->with('store', 'Registro Agregado, Ingrese detalle');
        }
    }

    public function show(Tesoreria $tesoreria)
    {
        //
    }

    public function edit(Tesoreria $tesoreria)
    {
        $moneda = Categoria::where('modulo', 4)->pluck('nombre','codigo');
        // $clientes = Cliente::where('id',$rcompra->cliente_id)->get()->pluck('numdoc_razsoc','id');
        $tipooperacion = Categoria::where('modulo', 7)->pluck('nombre','codigo');
        $mediopago = Categoria::where('modulo', 5)->pluck('nombre','codigo');

        if(session('principal') == 1){
            $cuentas = Cuenta::where('empresa_id',Auth::user()->empresa)
                ->pluck('nombre','id');
        }else{
            $cuentas = Cuenta::where('empresa_id',Auth::user()->empresa)
                ->where('sede_id',Auth::user()->sede)
                ->pluck('nombre','id');
        }

        return view('admin.tesorerias.edit',
            compact('tesoreria','moneda','tipooperacion',
            'mediopago','cuentas'));
    }

    public function update(Request $request, Tesoreria $tesoreria)
    {
        //
    }

    public function detstore(Request $request, Tesoreria $tesoreria){
        $rules = [
            'cliente_id' => 'required',
            'documento' => 'required',
            'montpen' => 'required',
            'montusd' => 'required'
        ];
        
        $messages = [
    		'cliente_id.required' => 'Elija Proveedor.',
    		'documento.required' => 'Elija Documento.',
    		'montpen.required' => 'Ingrese Monto en Soles.',
    		'montusd.required' => 'Ingrese Monto en Dólares.'
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->with('message', 'Se ha producido un error: Ingrese Proveedor, Nro Documento y Monto')->with('typealert', 'danger')->withinput();
        }else{
            $r = Rcompra::find($request->input('documento'));
            $monto = $r->moneda == 'PEN'? $request->input('montpen') : $request->input('montusd');
            $pagado = $r->pagado + $monto;
            $saldo = $r->saldo - $monto;
            $r->update([
                'pagado' => $pagado,
                'saldo' => $saldo
            ]);
            if($r->tipocomprobante_codigo == '07'){
                $montoPen = $request->input('montpen') * -1;
                $montoUsd = $request->input('montusd') * -1;
            }else{
                $montoPen = $request->input('montpen');
                $montoUsd = $request->input('montusd');
            }
            $r->dettesors()->create([
                'tesoreria_id' => $tesoreria->id,
                'montopen' => $montoPen,
                'montousd' => $montoUsd
            ]);
            if($tesoreria->cuenta->moneda = 'PEN'){
                $Total = $tesoreria->dettesors->sum('montopen');
            }else{
                $Total = $tesoreria->dettesors->sum('montousd');
            }
            $tesoreria->update(['monto' => $Total]);

            return redirect()->route('admin.tesorerias.edit',$tesoreria)->with('store', 'Registro Agregado, Ingrese detalle');
        }
    }

    public function destroy(Tesoreria $tesoreria)
    {
        foreach($tesoreria->dettesors as $dettesor){
            if($dettesor->dettesorable->moneda == 'PEN'){
                $monto = $dettesor->montopen;
            }else{
                $monto = $dettesor->montousd;
            }
            $pagado = $dettesor->dettesorable->pagado - $monto;
            $saldo = $dettesor->dettesorable->saldo + $monto;
            $dettesor->dettesorable->update([
                'pagado' => $pagado,
                'saldo' => $saldo,
            ]);
            $dettesor->delete();
        }
        $tesoreria->delete();
        return redirect()->route('admin.tesorerias.index',[session('periodo'),$tesoreria->cuenta_id])->with('destroy', 'Registro Eliminado I');
    }

    public function detdestroy(Dettesor $dettesor)
    {
        $tesoreria = $dettesor->tesoreria;
        if($dettesor->dettesorable->moneda == 'PEN'){
            $monto = abs($dettesor->montopen);
        }else{
            $monto = abs($dettesor->montousd);
        }
        $pagado = $dettesor->dettesorable->pagado - $monto;
        $saldo = $dettesor->dettesorable->saldo + $monto;
        $dettesor->dettesorable->update([
            'pagado' => $pagado,
            'saldo' => $saldo,
        ]);
        $dettesor->delete();
        if($tesoreria->cuenta->moneda = 'PEN'){
            $Total = $tesoreria->dettesors->sum('montopen');
        }else{
            $Total = $tesoreria->dettesors->sum('montousd');
        }
        $tesoreria->update(['monto' => $Total]);

        return redirect()->route('admin.tesorerias.edit',$tesoreria)->with('destroy', 'Registro Eliminado Detalle I');

    }
}

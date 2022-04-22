<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRventaRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Admin\SunatController;

use App\Models\Rventa;
use App\Models\TipoComprobante;
use App\Models\Afectacion;
use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\Cuenta;
use App\Models\Detraccion;
use App\Models\Detrventa;
use App\Models\Kardex;
use App\Models\Producto;
use App\Models\Sede;
use App\Models\Tesoreria;
use App\Models\Tmpdetsalida;
use App\Models\Vencimiento;


class RventaController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
		$this->middleware('can:admin.rventas.index')->only('index');
		$this->middleware('can:admin.rventas.create')->only('create','store');
		$this->middleware('can:admin.rventas.edit')->only('edit','update');
		// $this->middleware('can:admin.categorias.permission')->only('editpermission','updatepermission');
		// $this->middleware('can:admin.categorias.password')->only('editpassword','updatepassword');
    }

    public function index($periodo = '000000')
    {
        if($periodo == '000000'){
            $periodo = session('periodo');
        }
        $rventas = Rventa::with(['cliente'])
            ->select('id','fecha','moneda','serie','numero','tipocomprobante_codigo','cliente_id','total','status','cdr')
            ->where('tipo',1)
            ->where('periodo',$periodo)
            ->where('empresa_id',session('empresa'))
            ->where('sede_id',session('sede'))
            ->get();

        $impuesto = round(Rventa::where('periodo',$periodo)
            ->where('empresa_id',session('empresa'))
            ->where('sede_id',session('sede'))
            ->where(function($query){
                $query->where('status', 1)->orWhere('status',2);
            })
            ->get()
            ->sum('impuestosol'),2);
            
        return view('admin.rventas.index', compact('rventas','periodo','impuesto'));
    }

    public function change(Request $request)
    {
        $periodo = $request->input('mes').$request->input('año');
        $rventas = Rventa::with(['cliente'])
            ->select('id','fecha','moneda','serie','numero','tipocomprobante_codigo','cliente_id','total','status','cdr')
            ->where('tipo',1)
            ->where('periodo',$periodo)
            ->where('empresa_id',session('empresa'))
            ->where('sede_id',session('sede'))
            ->get();
        $impuesto = round(Rventa::where('periodo',$periodo)
            ->where('tipo',1)
            ->where('empresa_id',session('empresa'))
            ->where('sede_id',session('sede'))
            ->where(function($query){
                $query->where('status', 1)->orWhere('status',2);
            })
            ->get()
            ->sum('impuestosol'),2);

        return view('admin.rventas.index', compact('rventas','periodo','impuesto'));
    }

    public function create()
    {
        $moneda = Categoria::where('modulo', 4)->pluck('nombre','codigo');
        $tipocomprobante = TipoComprobante::wherein('codigo',['01','03'])->orderBy('codigo')->pluck('nombre','codigo');
        $detraccions = Detraccion::orderBy('codigo')->pluck('nombre','codigo');
        $afectaciones = Afectacion::pluck('nombre','codigo');
        $mediopago = Categoria::where('modulo', 5)->pluck('nombre','codigo');
        $cuenta = Cuenta::where('empresa_id',session('empresa'))
                ->where('sede_id',session('sede'))
                ->where('moneda','PEN')
                ->pluck('nombre','id');
        $key = generateRandomString();
        $tipdoc = Categoria::where('modulo', 1)->orderBy('codigo')->pluck('nombre','codigo');
        $sexo = Categoria::where('modulo', 2)->pluck('nombre','codigo');
        $estciv = Categoria::where('modulo', 3)->pluck('nombre','codigo');

        return view('admin.rventas.create',
            compact('moneda','tipocomprobante','detraccions','afectaciones','mediopago','cuenta','key',
                    'tipdoc','sexo','estciv'));
    }

    public function store(StoreRventaRequest $request)
    {
        $data = [
            'periodo' => $request->input('periodo'),
            'tipo' => 1,
            'empresa_id' => $request->input('empresa_id'),
            'sede_id' => $request->input('sede_id'),
            'tipocomprobante_codigo' => $request->input('tipocomprobante_codigo'),
            'fecha' => $request->input('fecha'),
            'moneda' => $request->input('moneda'),
            'tc' => $request->input('tc'),
            'cliente_id' => $request->input('cliente_id'),
            'direccion' => $request->input('direccion'),
            'fpago' => $request->input('fpago'),
            'detalle' => $request->input('detalle'),
            'detraccion' => $request->input('detraccion'),
        ];

        if ($request->input('fpago') == 2) {
            $data = array_merge($data,[
                'dias' => $request->input('dias'),
                'vencimiento' => $request->input('vencimiento'),
            ]);
        } else {
            $data = array_merge($data,[
                'mediopago' => $request->input('mediopago'),
                'cuenta_id' => $request->input('cuenta_id'),
                'numerooperacion' => $request->input('numerooperacion'),
                'vencimiento' => $request->input('fecha'),
            ]);
            if ($request->input('mediopago') == '008') {
                $data = array_merge($data, [
                    'pagacon' => $request->input('pagacon')
                ]);
            }
        }

        if ($request->input('detraccion') == 1) {
            $data = array_merge($data, [
                'detraccion_codigo' => $request->input('detraccion_codigo'),
                'detraccion_tasa' => $request->input('detraccion_tasa'),
                'detraccion_monto' => $request->input('detraccion_monto'),
            ]);
        }
        // $cliente = Cliente::find($request->input('cliente_id'));
        $sede = Sede::find(session('sede'));
        switch ($request->input('tipocomprobante_codigo')) {
            case '01':
                $correlativo = $sede->factura_corr + 1;
                $sede->update([
                    'factura_corr' => $correlativo
                ]);
                $serie = $sede->factura_serie;
                $numero = str_pad($correlativo, 8, '0', STR_PAD_LEFT);
                break;
            case '03':
                $correlativo = $sede->boleta_corr + 1;
                $sede->update([
                    'boleta_corr' => $correlativo
                ]);
                $serie = $sede->boleta_serie;
                $numero = str_pad($correlativo, 8, '0', STR_PAD_LEFT);
                break;
            case '00':
                $correlativo = $sede->consumo_corr + 1;
                $sede->update([
                    'consumo_corr' => $correlativo
                ]);
                $serie = $sede->consumo_serie;
                $numero = str_pad($correlativo, 8, '0', STR_PAD_LEFT);
                break;
        }
        $key = $request->input('key');
        $afecto = Tmpdetsalida::where('key',$key)->where('afectacion_id','10')->sum('subtotal');
        $gravado = round($afecto / (1 + (session('igv')/100)),2);
        $igv = $afecto - $gravado;
        $exonerado = Tmpdetsalida::where('key',$key)->where('afectacion_id','20')->sum('subtotal');
        $inafecto = Tmpdetsalida::where('key',$key)->where('afectacion_id','30')->sum('subtotal');
        $exportacion = Tmpdetsalida::where('key',$key)->where('afectacion_id','40')->sum('subtotal');
        $gratuito = Tmpdetsalida::where('key',$key)->whereNotIn('afectacion_id',['10','20','30','40'])->sum('subtotal');
        $icbper = Tmpdetsalida::where('key',$key)->sum('icbper');
        $total = $gravado + $exonerado + $inafecto + $exportacion + $igv + $icbper;
        if ($request->input('fpago') == 1) {
            $pagado = $total;
            $saldo = 0.00;
        } else {
            $pagado = 0.00;
            $saldo = $total;
        }
        $data = array_merge($data, [
            'serie' => $serie,
            'numero' => $numero,
            'status' => 1,
            'gravado' => $gravado,
            'exonerado' => $exonerado,
            'inafecto' => $inafecto,
            'exportacion' => $exportacion,
            'gratuito' => $gratuito,
            'igv' => $igv,
            'icbper' => $icbper,
            'total' => $total,
            'pagado' => $pagado,
            'saldo' => $saldo,
        ]);
        // Inicio
        $rventa = Rventa::create($data);
        $detalle = Tmpdetsalida::where('user_id',Auth::user()->id)->where('key',$key)->get();
        foreach($detalle as $det){
            // Crea registro en Detalle de Comprobante
            $detVenta = $rventa->detrventa()->create([
                'producto_id' => $det->producto_id,
                'adicional' => $det->adicional,
                'grupo' => $det->grupo,
                'cantidad' => $det->cantidad,
                'preprom' => $det->preprom,
                'precio' => $det->precio,
                'icbper' => $det->icbper,
                'subtotal' => $det->subtotal,
                'afectacion_id' => $det->afectacion_id,
                'vence' => $det->vence,
                'lote' => $det->lote,
            ]);
        }
        $glosa = Cliente::where('id',$request->input('cliente_id'))->value('razsoc');
        if($request->input('moneda') == 'PEN'){
            $montopen = $total;
            $montousd = round($total / $request->input('tc'),2);
        }else{
            $montousd = $total;
            $montopen = round($total * $request->input('tc'),2);
        }

        // Envío a servidor de Sunat en caso sea Factura
        if ($rventa->tipocomprobante_codigo == '01') {
            $sunat = new SunatController();
            $msm = $sunat->ventas($rventa);
            // $var = $this->sunat($rventa);
        }
        if ($rventa->status <> 3) {
            // Forma de Pago - Contado
            if($request->input('fpago') == 1){
                $bt = Tesoreria::where('cuenta_id',$request->input('cuenta_id'))
                    ->where('glosa',$glosa)
                    ->where('tipo',1)
                    ->where('mediopago', $request->input('mediopago'))
                    ->where('numerooperacion', $request->input('numerooperacion'))
                    ->value('id');
                $moncta = Cuenta::where('id', $request->input('cuenta_id'))->value('moneda');
                if($moncta == 'PEN'){
                    $montotal = $montopen;
                }else{
                    $montotal = $montousd;
                }
                if(empty($bt)){
                    $t = Tesoreria::create([
                        'empresa_id' => session('empresa'),
                        'sede_id' => session('sede'),
                        'periodo' => session('periodo'),
                        'cuenta_id' => $request->input('cuenta_id'),
                        'tipo' => 1,
                        'fecha' => $request->input('fecha'),
                        'tc' => $request->input('tc'),
                        'mediopago' => $request->input('mediopago'),
                        'numerooperacion' => $request->input('numerooperacion'),
                        'monto' => $montotal,
                        'glosa' => $glosa
                    ]);
                    $rventa->dettesors()->create([
                        'tesoreria_id' => $t->id,
                        'montopen' => $montopen,
                        'montousd' => $montousd,
                    ]);
                }else{
                    $t = Tesoreria::find($bt);
                    $glosa = $glosa;
                    $monto = $t->monto + $montotal;
                    $t->update([
                        'monto' => $monto,
                        'glosa' => $glosa
                    ]);
                    $rventa->dettesors()->create([
                        'tesoreria_id' => $t->id,
                        'montopen' => $montopen,
                        'montousd' => $montousd,
                    ]);
                    
                }
            }
    
            //Ingreso de Detalle de Comprobante
            // $detalle = Tmpdetsalida::where('user_id',Auth::user()->id)->where('key',$key)->get();
            $detalle = $rventa->detrventa;
            foreach($detalle as $det){
                // Descuenta Stock
                if ($det->grupo == 1) {
                    $producto = Producto::find($det->producto_id);
                    if ($producto->ctrlstock == 1) {
                        $stock = $producto->stock;
                        $producto->update([
                            'stock' => $stock - $det->cantidad,
                        ]);
                        Kardex::create([
                            'periodo' => $rventa->periodo,
                            'tipo' => 3,
                            'operacion_id' => $det->id,
                            'producto_id' => $det->producto_id,
                            'cliente_id' => $rventa->cliente_id,
                            'documento' => numDoc($rventa->serie,$rventa->numero),
                            'proveedor' => $rventa->cliente->razsoc,
                            'fecha' => $rventa->fecha,
                            'cant_sal' => $det->cantidad,
                            'cant_sald' => $stock - $detVenta->cantidad,
                            'pre_prom' => $det->preprom,
                            'descrip' => 'VENTA TD:' . $rventa->tipocomprobante_codigo . ' ' . numDoc($rventa->serie,$rventa->numero),
                        ]);
                    }
                    if ($producto->lotevencimiento == 1) {
                        $vencimiento_id = Vencimiento::where('producto_id',$det->producto_id)
                            ->where('lote',$det->lote)->value('id');
                        $vencimiento = Vencimiento::find($vencimiento_id);
                        $vencimientoSalidas = $vencimiento->salidas + $det->cantidad;
                        $vencimientoSaldo = $vencimiento->saldo - $det->cantidad;
                        $vencimiento->update([
                            'salidas' => $vencimientoSalidas,
                            'saldo' => $vencimientoSaldo,
                        ]);
                    }
                }
            }
            Tmpdetsalida::where('user_id',Auth::user()->id)->where('key',$key)->where('tipo',1)->delete();
        }
        
        return response()->json($rventa);
            // return redirect()->route('admin.rventas.index')->with('store', 'Registro Agregado, Ingrese Productos | Servicios');
        // }
    }

    public function show(Rventa $rventa)
    {
        
    }

    public function edit(Rventa $rventa)
    {
        // $moneda = Categoria::where('modulo', 4)->pluck('nombre','codigo');
        $tipocomprobante = TipoComprobante::wherein('codigo',['00','01','03'])->orderBy('codigo')->pluck('nombre','codigo');
        $tipooperacion = Categoria::where('modulo', 7)->pluck('nombre','codigo');
        $clientes = Cliente::where('id',$rventa->cliente_id)->get()->pluck('numdoc_razsoc','id');
        $mediopago = Categoria::where('modulo', 5)->pluck('nombre','codigo');
        $cuenta = Cuenta::where('empresa_id',session('empresa'))
                ->where('sede_id',session('sede'))
                ->where('moneda','PEN')
                ->pluck('nombre','id');
        $detraccions = Detraccion::orderBy('codigo')->pluck('nombre','codigo');
        $afectaciones = Afectacion::pluck('nombre','codigo');
        $moneda = $rventa->moneda;

        return view('admin.rventas.edit',
            compact('rventa','moneda','tipocomprobante','tipooperacion','clientes',
            'mediopago','cuenta','detraccions','afectaciones'));
    }

    public function update(Request $request, Rventa $rventa)
    {
        $rules = [
            'fpago' => 'required',
        ];
        $data = [
            'fpago' => $request->input('fpago')
        ];
        if ($rventa->tipo == 1) {
            if ($request->input('fpago') == 2) {
                $rules = array_merge($rules, [
                    'dias' => 'required',
                    'vencimiento' => 'required',
                ]);
                $data = array_merge($data,[
                    'dias' => $request->input('dias'),
                    'vencimiento' => $request->input('vencimiento'),
                ]);
            } else {
                $rules = array_merge($rules, [
                    'mediopago' => 'required',
                    'cuenta_id' => 'required',
                    'numerooperacion' => 'required',
                ]);
                $data = array_merge($data,[
                    'mediopago' => $request->input('mediopago'),
                    'cuenta_id' => $request->input('cuenta_id'),
                    'numerooperacion' => $request->input('numerooperacion'),
                ]);
                if ($request->input('mediopago') == '008') {
                    $rules = array_merge($rules, [
                        'pagacon' => 'required',
                    ]);
                    $mon = $rventa->moneda == 'PEN' ? 'S/ ' : 'US$ ';
                    $data = array_merge($data, [
                        'detalle' => 'Paga con: ' 
                        . $mon
                        . $request->input('pagacon')
                        . ' Vuelto: '
                        . $mon
                        . $request->input('vuelto')
                    ]);
                }
            }
        }
        if ($request->input('detraccion') == 1) {
            $rules = array_merge($rules, [
                'detraccion_codigo' => 'required',
                'detraccion_tasa' => 'required',
                'detraccion_monto' => 'required',
            ]);

            $data = array_merge($data, [
                'detraccion' => $request->input('detraccion'),
                'detraccion_codigo' => $request->input('detraccion_codigo'),
                'detraccion_tasa' => $request->input('detraccion_tasa'),
                'detraccion_monto' => $request->input('detraccion_monto'),
            ]);
        }
        
        $messages = [
    		'dias.required' => 'Ingrese Días de Crédito.',
    		'vencimiento.required' => 'Ingrese Vencimiento del Crédito.',
    		'mediopago.required' => 'Ingrese Medio de Pago.',
    		'cuenta_id.required' => 'Ingrese Cuenta.',
    		'numerooperacion.required' => 'Ingrese Número de Operación.',
    		'pagacon.required' => 'Ingrese con cuanto Paga el Cliente.',
    		'detraccion_codigo.required' => 'Seleccione Código de detracción.',
    		'detraccion_tasa.required' => 'Ingrese Tasa de detracción.',
    		'detraccion_monto.required' => 'Ingrese Monto de detracción.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if ($validator->fails()) {
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        } else {
            $cliente = Cliente::find($request->input('cliente_id'));
            if ($request->input('tipocomprobante_codigo') == '01' && ($cliente->tipdoc_id <> '6')) {
                return back()->with('message', 'No se puede emitir Factura en Cliente sin RUC')->with('typealert', 'danger')->withinput();
            }
            $sede = Sede::find(session('sede'));
            switch ($request->input('tipocomprobante_codigo')) {
                case '01':
                    $correlativo = $sede->factura_corr + 1;
                    $sede->update([
                        'factura_corr' => $correlativo
                    ]);
                    $serie = $sede->factura_serie;
                    $numero = str_pad($correlativo, 8, '0', STR_PAD_LEFT);
                    break;
                case '03':
                    $correlativo = $sede->boleta_corr + 1;
                    $sede->update([
                        'boleta_corr' => $correlativo
                    ]);
                    $serie = $sede->boleta_serie;
                    $numero = str_pad($correlativo, 8, '0', STR_PAD_LEFT);
                    break;
                case '00':
                    $correlativo = $sede->consumo_corr + 1;
                    $sede->update([
                        'consumo_corr' => $correlativo
                    ]);
                    $serie = $sede->consumo_serie;
                    $numero = str_pad($correlativo, 8, '0', STR_PAD_LEFT);
                    break;
            }
            $data = array_merge($data, [
                'cliente_id' => $request->input('cliente_id'),
                'tipocomprobante_codigo' => $request->input('tipocomprobante_codigo'),
                'serie' => $serie,
                'numero' => $numero,
                'status' => 1,
            ]);
            $rventa->update($data);
            return 'Grabo';

        }
    }

    public function destroy(Rventa $rventa)
    {
        //
    }

    public function additem(Request $request)
    {
        Tmpdetsalida::create([
            'user_id' => Auth::user()->id,
            'key' => $request->input('keydet'),
            'tipo' => 1,
            'producto_id' => $request->input('producto_id'),
            'adicional' => e($request->input('adicional')),
            'grupo' => $request->input('grupo'),
            'cantidad' => $request->input('cantidad'),
            'preprom' => $request->input('precompra'),
            'precio' => $request->input('precio'),
            'subtotal' => $request->input('subtotal'),
            'icbper' => $request->input('icbper'),
            'afectacion_id' => $request->input('afectacion_id'),
            'lote' => $request->input('lote'),
            'vence' => $request->input('vence'),
        ]);
        return true;
    }

    public function destroyitem(Tmpdetsalida $tmpdetsalida){
        $tmpdetsalida->delete();
        return 1;
    }

    public function tablaitem($key, $moneda)
    {
        Tmpdetsalida::where('user_id',Auth::user()->id)->where('tipo',1)->update(['key'=>$key]);
        $detalle = Tmpdetsalida::with('Producto')->where('user_id',Auth::user()->id)->where('tipo',1)->where('key',$key)->get();
        $items = $detalle->count();
        $afecto = Tmpdetsalida::where('key',$key)->where('afectacion_id','10')->sum('subtotal');
        $gravado = round($afecto / (1 + (session('igv')/100)),2);
        $igv = $afecto - $gravado;
        $exonerado = Tmpdetsalida::where('key',$key)->where('afectacion_id','20')->sum('subtotal');
        $inafecto = Tmpdetsalida::where('key',$key)->where('afectacion_id','30')->sum('subtotal');
        $exportacion = Tmpdetsalida::where('key',$key)->where('afectacion_id','40')->sum('subtotal');
        $gratuito = Tmpdetsalida::where('key',$key)->whereNotIn('afectacion_id',['10','20','30','40'])->sum('subtotal');
        $icbper = Tmpdetsalida::where('key',$key)->sum('icbper');
        $total = $gravado + $exonerado + $inafecto + $exportacion + $igv + $icbper;
        return view('admin.rventas.detalle',compact('detalle','moneda','gravado','igv','exonerado','inafecto',
            'exportacion','gratuito','icbper','total','items'));
    }

    public function tablatotales(Rventa $rventa)
    {
        // $detventas = Detrventa::with('producto')->where('producto_id',$producto)->get();
        return view('admin.rventas.totales',compact('rventa'));
    }

    public function pendiente(Request $request, $cliente)
    {
    	// if($request->ajax()){
    		$rventas = Rventa::select('id','fecha','moneda','tipocomprobante_codigo','serie','numero','saldo')
                ->where('cliente_id',$cliente)
                ->where('saldo','>',0)
                // ->where('tipocomprobante_codigo','<>','07')
                ->get();
    		return response()->json($rventas);
    	// }
    }
}

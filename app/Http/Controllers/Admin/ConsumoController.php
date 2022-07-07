<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Admin\SunatController;
use App\Http\Requests\StoreConsumoRequest;
use App\Models\Rventa;
use App\Models\TipoComprobante;
use App\Models\Afectacion;
use App\Models\Categoria;
use App\Models\Ccosto;
use App\Models\Cliente;
use App\Models\Cuenta;
use App\Models\Destino;
use App\Models\Detdestino;
use App\Models\Detraccion;
use App\Models\Detrventa;
use App\Models\Kardex;
use App\Models\Lote;
use App\Models\Producto;
use App\Models\Sede;
use App\Models\Tesoreria;
use App\Models\Tmpdetsalida;
use App\Models\Vencimiento;

class ConsumoController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
		$this->middleware('can:admin.consumos.index')->only('index');
		$this->middleware('can:admin.consumos.create')->only('create','store');
		$this->middleware('can:admin.consumos.edit')->only('edit','update');
		// $this->middleware('can:admin.categorias.permission')->only('editpermission','updatepermission');
		// $this->middleware('can:admin.categorias.password')->only('editpassword','updatepassword');
    }

    public function index($periodo = '000000')
    {
        if($periodo == '000000'){
            $periodo = session('periodo');
        }
        $rventas = Rventa::with(['cliente','detrventa','ccosto'])
            ->select('id','fecha','moneda','serie','numero','tipocomprobante_codigo','cliente_id','detdestino_id','lote')
            ->where('tipo',2)
            ->where('periodo',$periodo)
            ->where('empresa_id',session('empresa'))
            ->where('sede_id',session('sede'))
            ->get();

        return view('admin.consumos.index', compact('rventas','periodo'));
    }

    public function change(Request $request)
    {
        $periodo = $request->input('mes').$request->input('año');
        $rventas = Rventa::with(['cliente'])
            ->select('id','fecha','moneda','serie','numero','tipocomprobante_codigo','cliente_id','detdestino_id','lote')
            ->where('tipo',2)
            ->where('periodo',$periodo)
            ->where('empresa_id',session('empresa'))
            ->where('sede_id',session('sede'))
            ->get();

            return view('admin.consumos.index', compact('rventas','periodo'));
    }

    public function create()
    {
        $moneda = Categoria::where('modulo', 4)->pluck('nombre','codigo');
        $tipocomprobante = TipoComprobante::wherein('codigo',['00'])->orderBy('codigo')->pluck('nombre','codigo');
        $key = generateRandomString();
        $destinos = Destino::where('empresa_id',session('empresa'))->orderBy('nombre')->pluck('nombre','id');
        $ccosto = Ccosto::where('empresa_id',session('empresa'))->orderBy('nombre')->pluck('nombre','id');
        $lotes = Lote::where('empresa_id',session('empresa'))->OrderBy('lote','desc')->take(15)->pluck('lote','lote');

        return view('admin.consumos.create', compact('moneda','tipocomprobante','key','destinos','ccosto','lotes'));
    }

    public function store(StoreConsumoRequest $request)
    {
        $data = [
            'periodo' => $request->input('periodo'),
            'tipo' => 2,
            'contable' => 2,
            'empresa_id' => $request->input('empresa_id'),
            'sede_id' => $request->input('sede_id'),
            'tipocomprobante_codigo' => '00',
            'fecha' => $request->input('fecha'),
            'moneda' => 'PEN',
            'tc' => $request->input('tc'),
            'cliente_id' => 2,
            'detdestino_id' => $request->input('detdestino_id'),
            'lote' => $request->input('lotep'),
            // 'ccosto_id' => $request->input('ccosto_id'),
            'detalle' => $request->input('detalle'),
        ];

        // $cliente = Cliente::find($request->input('cliente_id'));
        $sede = Sede::find(session('sede'));
        $correlativo = $sede->consumo_corr + 1;
        $sede->update([
            'consumo_corr' => $correlativo
        ]);
        $serie = $sede->consumo_serie;
        $numero = str_pad($correlativo, 8, '0', STR_PAD_LEFT);

        $key = $request->input('key');
        $total = 0.00;
        $pagado = 0.00;
        $saldo = 0.00;
        $data = array_merge($data, [
            'serie' => $serie,
            'numero' => $numero,
            'status' => 1,
            'total' => $total,
            'pagado' => $pagado,
            'saldo' => $saldo,
        ]);
        // Inicio
        $rventa = Rventa::create($data);
        // return $rventa;
        $detalle = Tmpdetsalida::where('user_id',Auth::user()->id)->where('key',$key)->get();
        foreach($detalle as $det){
            // Crea registro en Detalle de Comprobante
            $detVenta = $rventa->detrventa()->create([
                'producto_id' => $det->producto_id,
                'adicional' => $det->adicional,
                'grupo' => 1,
                'cantidad' => $det->cantidad,
                'devolucion' => 0,
                'preprom' => $det->preprom,
                'precio' => $det->precio,
                'subtotal' => $det->subtotal,
                'vence' => $det->vence,
                'lote' => $det->lote,
            ]);

            $producto = Producto::find($det->producto_id);
            if ($producto->ctrlstock == 1) {
                $stock = $producto->stock;
                $producto->update([
                    'stock' => $stock - $det->cantidad,
                ]);
                Kardex::create([
                    'periodo' => $rventa->periodo,
                    'tipo' => 2,
                    'operacion_id' => $detVenta->id,
                    'producto_id' => $detVenta->producto_id,
                    'cliente_id' => $rventa->cliente_id,
                    'documento' => numDoc($rventa->serie,$rventa->numero),
                    'proveedor' => $rventa->cliente->razsoc,
                    'fecha' => $rventa->fecha,
                    'cant_sal' => $detVenta->cantidad,
                    'cant_sald' => $stock - $detVenta->cantidad,
                    'pre_prom' => $detVenta->preprom,
                    'descrip' => 'CONSUMO TD:' . $rventa->tipocomprobante_codigo . ' ' . numDoc($rventa->serie,$rventa->numero),
                ]);
            }
            if ($producto->lotevencimiento == 1) {
                $vencimiento_id = Vencimiento::where('producto_id',$detVenta->producto_id)
                    ->where('lote',$detVenta->lote)->value('id');
                $vencimiento = Vencimiento::find($vencimiento_id);
                $vencimientoSalidas = $vencimiento->salidas + $detVenta->cantidad;
                $vencimientoSaldo = $vencimiento->saldo - $detVenta->cantidad;
                $vencimiento->update([
                    'salidas' => $vencimientoSalidas,
                    'saldo' => $vencimientoSaldo,
                ]);
            }
            Tmpdetsalida::where('user_id',Auth::user()->id)->where('key',$key)->where('tipo',2)->delete();
        }
      
        return response()->json($rventa);
            // return redirect()->route('admin.rventas.index')->with('store', 'Registro Agregado, Ingrese Productos | Servicios');
        // }
    }

    public function show(Rventa $rventa)
    {
        
    }

    public function edit(Rventa $consumo)
    {
        $clientes = Cliente::where('id',$consumo->cliente_id)->get()->pluck('numdoc_razsoc','id');
        $destinos = Destino::where('id', $consumo->detdestino->destino_id)->pluck('nombre','id');
        $detdestinos = Detdestino::where('id', $consumo->detdestino_id)->pluck('nombre','id');
        $lotes = Lote::where('empresa_id',session('empresa'))->OrderBy('lote','desc')->take(15)->pluck('lote','lote');
        
        return view('admin.consumos.edit',
            compact('consumo','destinos','detdestinos','lotes'));
    }

    public function update(Request $request, Rventa $consumo)
    {
        $rules = [
            // 'fpago' => 'required',
        ];
        $data = [
            'fpago' => $request->input('fpago')
        ];

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
            $sede = Sede::find(session('sede'));
            $correlativo = $sede->consumo_corr + 1;
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
            'tipo' => 2,
            'producto_id' => $request->input('producto_id'),
            'adicional' => e($request->input('adicional')),
            'grupo' => $request->input('grupo'),
            'cantidad' => $request->input('cantidad'),
            'preprom' => $request->input('precompra'),
            'precio' => $request->input('precio'),
            'subtotal' => $request->input('subtotal'),
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
        Tmpdetsalida::where('user_id',Auth::user()->id)->where('tipo',2)->update(['key'=>$key]);
        $detalle = Tmpdetsalida::with('Producto')->where('user_id',Auth::user()->id)->where('tipo',2)->where('key',$key)->get();
        $items = $detalle->count();
        $subtotal = Tmpdetsalida::where('key',$key)->sum('subtotal');
        $total = $subtotal;
        return view('admin.consumos.detalle',compact('detalle','moneda','subtotal','total','items'));
    }

    public function tabladevol(Rventa $rventa)
    {
        return view('admin.consumos.detalledevol',compact('rventa'));
    }

    public function tablatotales(Rventa $rventa)
    {
        // $detventas = Detrventa::with('producto')->where('producto_id',$producto)->get();
        return view('admin.consumos.totales',compact('rventa'));
    }

    public function detconsumo(Request $request, Detrventa $detconsumo)
    {
        $detalle = [
            'id' => $detconsumo->id,
            'producto' => $detconsumo->producto->nombre . ' X ' . $detconsumo->producto->umedida->nombre,
            'adicional' =>  $detconsumo->adicional,
            'cantidad' =>  $detconsumo->cantidad,
            'dfecha' =>  empty($detconsumo->dfecha)?date('Y-m-d'):$detconsumo->dfecha,
            'motivo' =>  $detconsumo->motivo,
            'devolucion' =>  $detconsumo->devolucion,
        ];
        // if ($request->ajax()) {
            return response()->json($detalle);
        // }
    }

    public function devolucion($envio)
    {
        $det = json_decode($envio);
        $detrventa = Detrventa::findOrFail($det->id);
        // $detrventa->rventa->periodo
        //----------------------------------------------------------------------------------------
        $producto = Producto::find($detrventa->producto_id);
        if ($producto->ctrlstock == 1) {
            $stock = $producto->stock;
            $producto->update([
                'stock' => $stock - $detrventa->devolucion + $det->devolucion,
            ]);
            Kardex::where('operacion_id', $detrventa->id)->where('tipo', 5)->delete();
            Kardex::create([
                'periodo' => $detrventa->rventa->periodo,
                'tipo' => 5,
                'operacion_id' => $detrventa->id,
                'producto_id' => $detrventa->producto_id,
                'cliente_id' => 2,
                'documento' => numDoc($detrventa->rventa->serie,$detrventa->rventa->numero),
                'proveedor' => $detrventa->rventa->cliente->razsoc,
                'fecha' => $det->dfecha,
                'cant_ent' => $det->devolucion,
                'cant_sald' => $producto->stock,
                'pre_prom' => $detrventa->preprom,
                'descrip' => 'DEVOLUCIÓN TD:' . $detrventa->rventa->tipocomprobante_codigo . ' ' . numDoc($detrventa->rventa->serie, $detrventa->rventa->numero),
            ]);
        }
        if ($producto->lotevencimiento == 1) {
            $vencimiento_id = Vencimiento::where('producto_id',$detrventa->producto_id)
                ->where('lote',$detrventa->lote)->value('id'); // 100 + 4 - 2
            $vencimiento = Vencimiento::find($vencimiento_id);
            $vencimientoSalidas = $vencimiento->salidas + $detrventa->cantidad - $det->devolucion;
            $vencimientoSaldo = $vencimiento->saldo - $detrventa->devolucion + $det->devolucion;
            $vencimiento->update([
                'salidas' => $vencimientoSalidas,
                'saldo' => $vencimientoSaldo,
            ]);
        }
        //----------------------------------------------------------------------------------------

        $detrventa->update([
            'dfecha' => $det->dfecha,
            'motivo' => $det->motivo,
            'devolucion' => $det->devolucion,
        ]);
    }

}

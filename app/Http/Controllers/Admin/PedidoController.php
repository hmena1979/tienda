<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDetpedidoRequest;
use App\Models\Categoria;
use App\Models\Destino;
use App\Models\Detdestino;
use App\Models\Detpedido;
use App\Models\Kardex;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\Rventa;
use App\Models\Sede;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
		$this->middleware('can:admin.pedidos.index')->only('index');
		$this->middleware('can:admin.pedidos.create')->only('create','store');
		$this->middleware('can:admin.pedidos.edit')->only('edit','update');
		// $this->middleware('can:admin.categorias.permission')->only('editpermission','updatepermission');
		// $this->middleware('can:admin.categorias.password')->only('editpassword','updatepassword');
    }

    public function index($periodo = '000000')
    {
        if($periodo == '000000'){
            $periodo = session('periodo');
        }
        
        $permiso = User::permission('admin.pedidos.procesar')->where('id',Auth::user()->id)->count();
        if ($permiso) {
            $pedidos = Pedido::with(['user'])
                ->select('id','fecha','user_id','estado','detdestino_id','observaciones','obslogistica') 
                ->where('periodo',$periodo)
                ->where('estado','!=', 1)
                ->where('empresa_id',session('empresa'))
                ->where('sede_id',session('sede'))
                ->get();
        } else {
            $pedidos = Pedido::with(['user'])
                ->select('id','fecha','user_id','estado','detdestino_id','observaciones','obslogistica') 
                ->where('periodo',$periodo)
                ->where('user_id',Auth::user()->id)
                ->where('empresa_id',session('empresa'))
                ->where('sede_id',session('sede'))
                ->get();
        }
        $estados = [
            1 => 'PENDIENTE',
            2 => 'ENVIADO',
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
        return view('admin.pedidos.index',compact('pedidos','periodo','estados','colores'));
    }

    public function change(Request $request)
    {
        $periodo = $request->input('mes').$request->input('año');
        $permiso = User::permission('admin.pedidos.procesar')->where('id',Auth::user()->id)->count();
        if ($permiso) {
            $pedidos = Pedido::with(['user'])
                ->select('id','fecha','user_id','estado','detdestino_id','observaciones','obslogistica') 
                ->where('periodo',$periodo)
                ->where('estado','!=', 1)
                ->where('empresa_id',session('empresa'))
                ->where('sede_id',session('sede'))
                ->get();
        } else {
            $pedidos = Pedido::with(['user'])
                ->select('id','fecha','user_id','estado','detdestino_id','observaciones','obslogistica') 
                ->where('periodo',$periodo)
                ->where('user_id',Auth::user()->id)
                ->where('empresa_id',session('empresa'))
                ->where('sede_id',session('sede'))
                ->get();
        }
        $estados = [
            1 => 'PENDIENTE',
            2 => 'ENVIADO',
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

        return view('admin.pedidos.index',compact('pedidos','periodo','estados','colores'));
    }

    public function create()
    {
        $users = User::where('id',Auth::user()->id)->pluck('name','id');
        $destinos = Destino::where('empresa_id',session('empresa'))->orderBy('nombre')->pluck('nombre','id');
        return view('admin.pedidos.create', compact('users','destinos'));
    }

    public function store(Request $request)
    {
        $rules = [
            'fecha' => 'required',
            'detdestino_id' => 'required',
        ];
        $messages = [
    		'fecha.required' => 'Ingrese fecha.',
    		'detdestino_id.required' => 'Seleccione Detalle de Destino.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            $pedido = Pedido::create($request->except('destino_id'));
            return redirect()->route('admin.pedidos.edit',$pedido)->with('store', 'Pedido Agregado, Ingrese los productos');
        }
    }

    public function show(Pedido $pedido)
    {
        //
    }

    public function edit(Pedido $pedido)
    {
        $procesa = User::permission('admin.pedidos.procesar')->where('id',Auth::user()->id)->count();
        if($procesa) {
            $procesa = true;
        } else {
            $procesa = false;
        }
        $users = User::where('id',$pedido->user_id)->pluck('name','id');
        $destino = $pedido->detdestino->destino->id;
        $destinos = Destino::where('empresa_id',session('empresa'))->orderBy('nombre')->pluck('nombre','id');
        $detdestinos = Detdestino::where('destino_id',$destino)->orderBy('nombre')->pluck('nombre','id');
        return view('admin.pedidos.edit',
            compact('pedido','users','destino','destinos','detdestinos','procesa'));
    }

    public function update(Request $request, Pedido $pedido)
    {
        $rules = [
            'fecha' => 'required',
            'detdestino_id' => 'required',
        ];
        $messages = [
    		'fecha.required' => 'Ingrese fecha.',
    		'detdestino_id.required' => 'Seleccione Detalle de Destino.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            $pedido->update($request->except('destino_id','procesa'));
            return redirect()->route('admin.pedidos.index')->with('store', 'Pedido Actualizado');
        }
    }

    public function destroy(Pedido $pedido)
    {
        if($pedido->detpedidos->count() > 0){
            return redirect()->route('admin.pedidos.index')->with('message', 'Se ha producido un error, No se puede eliminar, Pedido ya contiene productos')->with('typealert', 'danger');
        }
        $pedido->delete();

        return redirect()->route('admin.pedidos.index')->with('destroy', 'Registro Eliminado');
    }

    public function tablaitem(Pedido $pedido)
    {
        $procesa = User::permission('admin.pedidos.procesar')->where('id',Auth::user()->id)->count();
        if($procesa) {
            $procesa = true;
        } else {
            $procesa = false;
        }
        return view('admin.pedidos.detalle',compact('pedido','procesa'));
    }

    public function additem(StoreDetpedidoRequest $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $data = array_merge($data,[
                'catendida' => $request->input('cantidad'),
            ]);
            Detpedido::create($data);
            return true;
        }
    }
    
    public function destroyitem(Detpedido $detpedido){
        $detpedido->delete();
        return 1;
    }

    public function enviar(Pedido $pedido)
    {
        $pedido->update(['estado' => 2]);
        return true;
    }

    public function recepcionado(Pedido $pedido)
    {
        $pedido->update(['estado' => 3]);
        return true;
    }

    public function rechazar(Pedido $pedido)
    {
        $pedido->update(['estado' => 5]);
        return true;
    }

    public function atender(Pedido $pedido)
    {
        foreach ($pedido->detpedidos as $det) {
            If ($det->producto->stock < $det->catendida) {
                $response = ['codigo'=>2,'id'=>0];
                return response()->json($response);
            }
        }
        //----------------------------------------------------------------------------------------------------
        $data = [
            'periodo' => session('periodo'),
            'tipo' => 2,
            'contable' => 2,
            'empresa_id' => session('empresa'),
            'sede_id' => session('sede'),
            'tipocomprobante_codigo' => '00',
            'fecha' => date('Y-m-d'),
            'moneda' => 'PEN',
            'tc' => $this->BusTcXML(date('Y-m-d')),
            'cliente_id' => 2,
            'detdestino_id' => $pedido->detdestino_id,
            'detalle' => $pedido->user->name,
        ];

        // $cliente = Cliente::find($request->input('cliente_id'));
        $sede = Sede::find(session('sede'));
        $correlativo = $sede->consumo_corr + 1;
        $sede->update([
            'consumo_corr' => $correlativo
        ]);
        $serie = $sede->consumo_serie;
        $numero = str_pad($correlativo, 8, '0', STR_PAD_LEFT);

        $key = 1;
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
        // $detalle = Tmpdetsalida::where('user_id',Auth::user()->id)->where('key',$key)->get();
        
        foreach($pedido->detpedidos as $det){
            if ($det->catendida > 0){
                // Crea registro en Detalle de Comprobante
                $detVenta = $rventa->detrventa()->create([
                    'producto_id' => $det->producto_id,
                    'adicional' => $det->motivo,
                    'grupo' => 1,
                    'cantidad' => $det->catendida,
                    'preprom' => $det->producto->precompra,
                    'precio' => $det->producto->precompra,
                    'subtotal' => $det->catendida*$det->producto->precompra,
                ]);
    
                $producto = Producto::find($det->producto_id);
                if ($producto->ctrlstock == 1) {
                    $stock = $producto->stock;
                    $producto->update([
                        'stock' => $stock - $det->catendida,
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
            }
            // if ($producto->lotevencimiento == 1) {
            //     $vencimiento_id = Vencimiento::where('producto_id',$detVenta->producto_id)
            //         ->where('lote',$detVenta->lote)->value('id');
            //     $vencimiento = Vencimiento::find($vencimiento_id);
            //     $vencimientoSalidas = $vencimiento->salidas + $detVenta->cantidad;
            //     $vencimientoSaldo = $vencimiento->saldo - $detVenta->cantidad;
            //     $vencimiento->update([
            //         'salidas' => $vencimientoSalidas,
            //         'saldo' => $vencimientoSaldo,
            //     ]);
            // }
            // Tmpdetsalida::where('user_id',Auth::user()->id)->where('key',$key)->where('tipo',2)->delete();
        }
        //----------------------------------------------------------------------------------------------------
        $pedido->update(['estado' => 4]);
        $response = ['codigo'=>1,'id'=>$rventa->id];
        return response()->json($response);
    }
    
    public function detpedido(Detpedido $detpedido)
    {
        $det = [
            'id' => $detpedido->id,
            'producto' => $detpedido->producto->nombre . ' X ' . $detpedido->producto->umedida->nombre,
            'stock' => $detpedido->producto->stock,
            'ctrlstock' => $detpedido->producto->ctrlstock,
            'stockmin' => $detpedido->producto->stockmin,
            'cantidad' => $detpedido->cantidad,
            'glosa' => $detpedido->glosa,
            'catendida' => $detpedido->catendida,
            'motivo' => $detpedido->motivo,
        ];
        // $det = json_decode($det);
        return response()->json($det);
    }

    public function editdetpedido(Request $request, $envio)
    {
        if ($request->ajax()) {
            $det = json_decode($envio);
            $detpedido = Detpedido::findOrFail($det->id);
            $detpedido->update([
                'catendida' => $det->catendida,
                'motivo' => $det->motivo,
            ]);
        }
        return true;
    }

    public function BusTcXML($fecha)
    {
        $context = stream_context_create(array(
            'http' => array('ignore_errors' => true),
        ));

        // return $fecha;
        $url = 'https://api.apis.net.pe/v1/tipo-cambio-sunat?fecha='.$fecha;

        $api = file_get_contents($url,false,$context);

        if($api == false){
            return 0;
        }else{
            $api = str_replace('&Ntilde;','Ñ',$api);
            $api = json_decode($api);
            return $api->venta;
        }
    }
}

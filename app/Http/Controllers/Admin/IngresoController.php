<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\KardexController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Rcompra;
use App\Models\Detingreso;
use App\Models\Detproducto;
use App\Models\Kardex;
use App\Models\TipoComprobante;
use App\Models\Vencimiento;
use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\Producto;
use PhpParser\Node\Stmt\Return_;

class IngresoController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
		$this->middleware('can:admin.ingresos.index')->only('index');
		$this->middleware('can:admin.ingresos.edit')->only('edit','update');
		$this->middleware('can:admin.ingresos.adddet')->only('adddet','updatedet','destroydet');
    }

    public function index($periodo = '000000')
    {
        if($periodo == '000000'){
            $periodo = session('periodo');
        }
        $rcompras = Rcompra::with(['cliente'])
            ->select('id','fecha','moneda','serie','numero','tipocomprobante_codigo','cliente_id','afecto','otros')
            ->where('peringreso',$periodo)
            ->where('almacen',1)
            ->where('empresa_id',session('empresa'))
            ->where('sede_id',session('sede'))
            ->get();
            
        return view('admin.ingresos.index', compact('rcompras','periodo'));
    }

    public function change(Request $request)
    {
        $periodo = $request->input('mes').$request->input('año');
        $rcompras = Rcompra::with(['cliente'])
            ->select('id','fecha','moneda','serie','numero','tipocomprobante_codigo','cliente_id','afecto','otros')
            ->where('peringreso',$periodo)
            ->where('almacen',1)
            ->where('empresa_id',session('empresa'))
            ->where('sede_id',session('sede'))
            ->get();
            return view('admin.ingresos.index', compact('rcompras','periodo'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit(Rcompra $ingreso)
    {
        $moneda = Categoria::where('modulo', 4)->pluck('nombre','codigo');
        $tipocomprobante = TipoComprobante::orderBy('codigo')->pluck('nombre','codigo');
        $clientes = Cliente::where('id',$ingreso->cliente_id)->get()->pluck('numdoc_razsoc','id');

        return view('admin.ingresos.edit',
            compact('ingreso','moneda','tipocomprobante','clientes'));
    }

    public function update(Request $request, Rcompra $ingreso)
    {
        $rules = [
            'fechaingreso' => 'required',
            'entregadopor' => 'required',
        ];
        
        $messages = [
    		'fechaingreso.required' => 'Ingrese Fecha de Ingreso al almacén.',
    		'entregadopor.required' => 'Ingrese quien entregó los productos.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            $ingreso->update([
                'fechaingreso' => $request->input('fechaingreso'),
                'fechaguia' => $request->input('fechaguia'),
                'numeroguia' => $request->input('numeroguia'),
                'entregadopor' => $request->input('entregadopor'),
                ]);
            return redirect()->route('admin.ingresos.edit', $ingreso)->with('update', 'Ingresos | Ingrese Detalles del Comprobante');
        }
    }

    public function destroy(Rcompra $rcompra)
    {
        //
    }

    public function adddet(Request $request, Rcompra $ingreso)
    {
        // return $ingreso;
        $rules = [
            'producto_id' => 'required',
            'cantidad' => 'required',
            'precio' => 'required',
        ];
        if($request->input('lotevencimiento') == 1){
            $rules = array_merge($rules,[
                'lote' => 'required',
                'venceanio' => 'required',
                'vencemes' => 'required',
            ]);
        }        
        $messages = [
    		'producto_id.required' => 'Seleccione Producto.',
    		'cantidad.required' => 'Ingrese Cantidad.',
    		'precio.required' => 'Ingrese Precio.',
    		'lote.required' => 'Ingrese Lote.',
    		'venceanio.required' => 'Ingrese Año de Vencimiento.',
    		'vencemes.required' => 'Ingrese Mes de Vencimiento.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            // return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
            return redirect()->route('admin.ingresos.edit', $ingreso)->with('message', 'Se ha producido un error, ingrese todos los valores')->with('typealert', 'danger');
        }else{
            //Agregar registro en Detalle de Ingresos
            $di = $ingreso->detingresos()->create([
                'producto_id' => $request->input('producto_id'),
                'cantidad' => $request->input('cantidad'),
                'igv' => $request->input('igv'),
                'pre_ini' => $request->input('pre_ini'),
                'precio' => $request->input('precio'),
                'subtotal' => $request->input('subtotal'),
                'lote' => $request->input('lote'),
                'vence' => $request->input('venceanio').'-'.$request->input('vencemes'),
                'glosa' => $request->input('glosa'),
            ]);
            //Actualiza Tabla Productos
            if($ingreso->moneda == 'PEN'){
                $precio = $di->precio;
            }else{
                $precio = round($di->precio * $ingreso->tc,4);
            }
            $Producto = Producto::find($di->producto_id);
            $precioPromedio = 0.00;
            $stockProducto = 0.00;
            if($ingreso->tipocomprobante_codigo == '07'){
                $precioPromedio = prePromE($Producto->stock, $Producto->precompra, $di->cantidad, $precio);
                $stockProducto = $Producto->stock - $di->cantidad;
            }else{
                $precioPromedio = preProm($Producto->stock, $Producto->precompra, $di->cantidad, $precio);
                $stockProducto = $Producto->stock + $di->cantidad;
            }
            $Producto->update([
                'precompra' => $precioPromedio,
                'stock' => $stockProducto,
            ]);
            // Agrega Registro en Kardex
            if($ingreso->tipocomprobante_codigo == '07'){
                $tipoKardex = 4; //(1)Ingreso (2)Consumo directo (3)Salidas (4)Nota de Credito
                $cantEntradaKardex = $di->cantidad * -1;
            }
            else{
                $tipoKardex = 1; //(1)Ingreso (2)Consumo directo (3)Ventas (4)Nota de Credito
                $cantEntradaKardex = $di->cantidad;
            }
            Kardex::create([
                'periodo' => $ingreso->periodo,
                'tipo' => $tipoKardex,
                'operacion_id' => $di->id,
                'producto_id' => $di->producto_id,
                'cliente_id' => $ingreso->cliente_id,
                'documento' => numDoc($ingreso->serie,$ingreso->numero),
                'proveedor' => $ingreso->cliente->razsoc,
                'fecha' => $ingreso->fechaingreso,
                'cant_ent' => $cantEntradaKardex,
                'cant_sald' => $stockProducto,
                'pre_compra' => $precio,
                'pre_prom' => $precioPromedio,
                'descrip' => $di->glosa,
            ]);
            // Agrega Registro o Actualiza Vencimientos
            if($request->input('lotevencimiento') == 1){
                $vencimientoId = Vencimiento::where('producto_id',$di->producto_id)->where('lote',$di->lote)->value('id');
                if($vencimientoId){
                    $vencimiento = Vencimiento::find($vencimientoId);
                    $entradasVenc = $vencimiento->entradas;
                    $saldoVenc = $vencimiento->saldo;
                    if($ingreso->tipocomprobante_codigo == '07'){
                        $vencimiento->update([
                            'entradas' => $entradasVenc - $di->cantidad,
                            'saldo' => $saldoVenc - $di->cantidad
                        ]);
                    }
                    else{
                        $vencimiento->update([
                            'entradas' => $entradasVenc + $di->cantidad,
                            'saldo' => $saldoVenc + $di->cantidad
                        ]);
                    }
                    
                }else{
                    if($ingreso->tipocomprobante_codigo <> '07'){
                        Vencimiento::create([
                            'producto_id' => $di->producto_id,
                            'lote' => $di->lote,
                            'vencimiento' => $di->vence,
                            'entradas' => $di->cantidad,
                            'saldo' => $di->cantidad,
                        ]);
                    }
                }
            }
            
            return redirect()->route('admin.ingresos.edit', $ingreso)->with('create', 'Registro Agregado');
        }
    }

    public function destroydet(Detingreso $detingreso)
    {
        //Actualiza Tabla Productos
        $precio = $detingreso->precio;
        $Producto = Producto::find($detingreso->producto_id);
        $precioPromedio = 0.00;
        $stockProducto = 0.00;
        
        if($detingreso->rcompra->tipocomprobante_codigo == '07'){
            $precioPromedio = preProm($Producto->stock, $Producto->precompra, $detingreso->cantidad, $precio);
            $stockProducto = $Producto->stock + $detingreso->cantidad;
        }else{
            $precioPromedio = prePromE($Producto->stock, $Producto->precompra, $detingreso->cantidad, $precio);
            $stockProducto = $Producto->stock - $detingreso->cantidad;
        }
        $Producto->update([
            'precompra' => $precioPromedio,
            'stock' => $stockProducto,
        ]);

        // Elimina Registro en Kardex y Regenera
        if($detingreso->rcompra->tipocomprobante_codigo == '07'){
            $tipoKardex = 4; //(1)Ingreso (2)Consumo directo (3)Salidas (4)Nota de Credito
        }
        else{
            $tipoKardex = 1; //(1)Ingreso (2)Consumo directo (3)Salidas (4)Nota de Credito
        }
        Kardex::where('tipo',$tipoKardex)->where('operacion_id',$detingreso->id)->delete();
        $kardex = new KardexController();
        $b = $kardex->Regenerate(session('periodo'),$detingreso->producto_id);

        // Actualiza Vencimientos
        if(!empty($detingreso->lote)){
            $vencimientoId = Vencimiento::where('producto_id',$detingreso->producto_id)->where('lote',$detingreso->lote)->value('id');
            if($vencimientoId){
                $vencimiento = Vencimiento::find($vencimientoId);
                $entradasVenc = $vencimiento->entradas;
                $saldoVenc = $vencimiento->saldo;
                if($detingreso->rcompra->tipocomprobante_codigo == '07'){
                    $vencimiento->update([
                        'entradas' => $entradasVenc + $detingreso->cantidad,
                        'saldo' => $saldoVenc + $detingreso->cantidad
                    ]);
                }
                else{
                    $vencimiento->update([
                        'entradas' => $entradasVenc - $detingreso->cantidad,
                        'saldo' => $saldoVenc - $detingreso->cantidad
                    ]);
                }
            }
        }

        //Elimina Detalle de Ingresos
        $detingreso->delete();
        
        return redirect()->route('admin.ingresos.edit',$detingreso->rcompra_id)->with('destroy', 'Registro Eliminado');
    }
}

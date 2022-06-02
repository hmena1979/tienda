<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDetordcompraRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Models\Ordcompra;
use App\Models\Detordcompra;
use App\Models\Detrventa;
use App\Models\Producto;
use App\Models\Rcompra;
use App\Models\Detingreso;
use App\Models\Cotizacion;
use App\Models\Detcotizacion;
use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\Detcliente;
use App\Models\User;

class OrdcomprasController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
		$this->middleware('can:admin.ordcompras.index')->only('index');
		$this->middleware('can:admin.ordcompras.create')->only('create','store','busproducto','genoc');
		$this->middleware('can:admin.ordcompras.edit')->only('edit','update','tablaitem','additem','destroyitem');
		// $this->middleware('can:admin.categorias.permission')->only('editpermission','updatepermission');
		// $this->middleware('can:admin.categorias.password')->only('editpassword','updatepassword');
    }

    public function index($periodo = '000000')
    {
        if($periodo == '000000'){
            $periodo = session('periodo');
        }
        $ordcompras = Ordcompra::with(['cliente:id,razsoc'])
            ->select('id','fecha','cliente_id','moneda','total')
            ->where('periodo',$periodo)
            ->where('empresa_id',session('empresa'))
            ->where('sede_id',session('sede'))
            ->get();
        return view('admin.ordcompras.index',compact('ordcompras','periodo'));
    }

    public function change(Request $request)
    {
        $periodo = $request->input('mes').$request->input('año');
        $ordcompras = Ordcompra::with(['cliente:id,razsoc'])
            ->select('id','fecha','cliente_id','moneda','total')
            ->where('periodo',$periodo)
            ->where('empresa_id',session('empresa'))
            ->where('sede_id',session('sede'))
            ->get();
        return view('admin.ordcompras.index',compact('ordcompras','periodo'));
    }

    public function create()
    {
        $tipdoc = Categoria::where('modulo', 1)->orderBy('codigo')->pluck('nombre','codigo');
        $cuentas = [];
        $users = User::where('empresa',session('empresa'))->where('sede',session('sede'))->orderBy('name')->pluck('name','id');
        return view('admin.ordcompras.create',compact('tipdoc','cuentas','users'));
    }

    public function store(Request $request)
    {
        $rules = [
            'fecha' => 'required',
            'cliente_id' => 'required',
        ];
        $messages = [
    		'fecha.required' => 'Ingrese fecha.',
    		'cliente_id.required' => 'Seleccione Proveedor.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            $ordcompra = Ordcompra::create($request->all());
            return redirect()->route('admin.ordcompras.edit',$ordcompra)->with('store', 'Orden de Compra Agregada, Ingrese los productos');
        }
    }
 function show(Ordcompra $ordcompra)
    {
        //
    }

    public function edit(Ordcompra $ordcompra)
    {
        $tipdoc = Categoria::where('modulo', 1)->orderBy('codigo')->pluck('nombre','codigo');
        $clientes = Cliente::where('id',$ordcompra->cliente_id)->get()->pluck('numdoc_razsoc','id');
        $detcli = Detcliente::with('banco')->where('cliente_id', $ordcompra->cliente_id)->get();
        $users = User::where('empresa',session('empresa'))->where('sede',session('sede'))->orderBy('name')->pluck('name','id');
        $id = [];
        $text = [];
        foreach ($detcli as $dc) {
            $id = array_merge($id,[
                $dc->id
            ]);
            $text = array_merge($text,[
                $dc->banco->nombre . ' ' . $dc->cuenta
            ]);
        }
        $cuentas = array_combine($id,$text);
        return view('admin.ordcompras.edit',
            compact('ordcompra','tipdoc','clientes','cuentas','users'));
    }

    public function update(Request $request, Ordcompra $ordcompra)
    {
        $rules = [
            'fecha' => 'required',
            'cliente_id' => 'required',
        ];
        $messages = [
    		'fecha.required' => 'Ingrese fecha.',
    		'cliente_id.required' => 'Seleccione Proveedor.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            $data = $request->except('numero');
            $ordcompra->update($data);
            return redirect()->route('admin.ordcompras.index')->with('update', 'Orden de Compra Actualizada');
        }
    }

    public function destroy(Ordcompra $ordcompra)
    {
        if($ordcompra->detordcompras->count() > 0){
            return redirect()->route('admin.ordcompras.index')->with('message', 'Se ha producido un error, No se puede eliminar, Orden de Compra ya contiene productos')->with('typealert', 'danger');
        }
        $ordcompra->delete();

        return redirect()->route('admin.ordcompras.index')->with('destroy', 'Registro Eliminado');
    }

    public function tablaitem(Ordcompra $ordcompra)
    {
        $total = $ordcompra->total;
        return view('admin.ordcompras.detalle',compact('ordcompra','total'));
    }

    public function additem(StoreDetordcompraRequest  $request)
    {
        if ($request->ajax()) {
            Detordcompra::create($request->all());
            $suma = Detordcompra::where('ordcompra_id',$request->input('ordcompra_id'))->sum('subtotal');
            Ordcompra::where('id',$request->input('ordcompra_id'))->update(['total' => $suma]);
            return true;
        }
    }

    public function destroyitem(Detordcompra $detordcompra){
        $idOrdCompra = $detordcompra->ordcompra_id;
        $detordcompra->delete();
        $suma = Detordcompra::where('ordcompra_id',$idOrdCompra)->sum('subtotal');
        Ordcompra::where('id',$idOrdCompra)->update(['total' => $suma]);
        return 1;
    }

    public function busproducto($producto_id = 999999)
    {
        if ($producto_id == 999999) {
            $productos = [];
            $producto = null;
            $data = [
                'producto' => $producto,
                'productos' => $productos,
            ];
        } else {
            $producto = Producto::findOrFail($producto_id);
            $productos = [
                $producto->id => $producto->nombre . ' X ' . $producto->umedida->nombre,
            ];
            $data = [
                'producto' => $producto,
                'productos' => $productos,
            ];
        }
        return view('admin.ordcompras.productos', $data);
    }

    public function consumos($producto_id)
    {
        $periodoConsulta = session('periodo');
        $resultado = [];
        for ($i = 1; $i <= 13; $i++) { 
            $suma = Detrventa::whereRelation('rventa',['periodo' => $periodoConsulta, 'tipo' => 2])
                ->where('producto_id', $producto_id)
                ->sum('cantidad');
            $mes = getMes(substr($periodoConsulta,0,2)). ' '. substr($periodoConsulta,2,4);
            $resultado = array_merge($resultado, [$mes => $suma]);
            $periodoConsulta = pAnterior($periodoConsulta);
        }
        return view('admin.ordcompras.consumos',compact('resultado'));
    }

    public function compras($producto_id)
    {
        $compras = Detingreso::with(['rcompra:id,serie,numero,cliente_id,fechaingreso,moneda'])
            ->orderBy(Rcompra::select('fechaingreso')->whereColumn('detingresos.rcompra_id','rcompras.id'),'desc')
            ->where('producto_id',$producto_id)
            ->select('id','rcompra_id','cantidad','precio','subtotal')
            ->take(10)
            ->get();
        return view('admin.ordcompras.compras',compact('compras'));
    }

    public function cotizaciones($producto_id)
    {
        $cotizaciones = Detcotizacion::with(['cotizacion:id,numero,cliente_id,fecha,moneda,observaciones,file'])
            ->whereRelation('cotizacion','estado',1)
            ->orderBy(Cotizacion::select('fecha')->whereColumn('detcotizacions.cotizacion_id','cotizacions.id'),'desc')
            ->where('producto_id',$producto_id)
            ->select('id','cotizacion_id','cantidad','precio','subtotal','glosa')
            ->take(10)
            ->get();
        return view('admin.ordcompras.cotizaciones',compact('cotizaciones'));
        return $cotizaciones;
    }

    public function genoc(Detcotizacion $detcotizacion)
    {
        $ordcompra = Ordcompra::where('cliente_id', $detcotizacion->cotizacion->cliente_id)->where('estado',1)->first();
        if ($ordcompra) {
            Detordcompra::create([
                'ordcompra_id' => $ordcompra->id,
                'producto_id' => $detcotizacion->producto_id,
                'cantidad' => $detcotizacion->cantidad,
                'precio' => $detcotizacion->precio,
                'subtotal' => $detcotizacion->subtotal,
                'glosa' => $detcotizacion->glosa,
            ]);
            $subtotal = Detordcompra::where('ordcompra_id', $ordcompra->id)->sum('subtotal');
            Ordcompra::where('id',$ordcompra->id)->update(['total' => $subtotal]);
            return redirect()->route('admin.ordcompras.edit',$ordcompra)->with('store', 'Se Agregó un producto a la Orden de Compra');
        } else {
            $orden = Ordcompra::create([
                'empresa_id' => session('empresa'),
                'sede_id' => session('sede'),
                'periodo' => session('periodo'),
                'fecha' => date('Y-m-d'),
                'cliente_id' => $detcotizacion->cotizacion->cliente_id,
                'moneda' => $detcotizacion->cotizacion->moneda,
                'total' => $detcotizacion->subtotal,
                'observaciones' => $detcotizacion->cotizacion->observaciones,
                'contacto' => $detcotizacion->cotizacion->contacto,
                'creado' => Auth::user()->id,
                'cotizacion' => $detcotizacion->cotizacion->numero,
            ]);
            Detordcompra::create([
                'ordcompra_id' => $orden->id,
                'producto_id' => $detcotizacion->producto_id,
                'cantidad' => $detcotizacion->cantidad,
                'precio' => $detcotizacion->precio,
                'subtotal' => $detcotizacion->subtotal,
                'glosa' => $detcotizacion->glosa,
            ]);
            return redirect()->route('admin.ordcompras.edit',$orden)->with('store', 'Orden de Compra creada');
        }
    }

    public function finalizar(Ordcompra $ordcompra)
    {
        $ordcompra->update(['estado' => 2]);
        return true;
    }

    public function autorizar(Ordcompra $ordcompra)
    {
        $ordcompra->update(['estado' => 3,'autorizado' => Auth::user()->id]);
        return true;
    }
}

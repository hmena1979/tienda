<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Afectacion;
use App\Models\Catproducto;
use App\Models\Detingreso;
use App\Models\Detproducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
Use Illuminate\Support\Facades\Config;

use App\Models\Producto;
use App\Models\Rcompra;
use App\Models\Rventa;
use App\Models\Sede;
use App\Models\TipoProducto;
use App\Models\Tmpdetsalida;
use App\Models\Umedida;
use App\Models\Vencimiento;
use Intervention\Image\ImageManagerStatic as Image;

class ProductoController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
		$this->middleware('can:admin.productos.index')->only('index');
		$this->middleware('can:admin.productos.create')->only('create','store');
		$this->middleware('can:admin.productos.edit')->only('edit','update');
		// $this->middleware('can:admin.categorias.permission')->only('editpermission','updatepermission');
		// $this->middleware('can:admin.categorias.password')->only('editpassword','updatepassword');
    }

    public function index()
    {
        $principal = Sede::where('id',Auth::user()->sede)->value('principal');
        $productos = Producto::with('umedida')->select('id','nombre','umedida_id','stock','preventa_pen','grupo')
            ->where('empresa_id',Auth::user()->empresa)
            ->get();
        return view('admin.productos.index', compact('productos','principal'));
    }

    public function registro(Request $request)
    {
        //$prov = Paciente::select('id','numdoc','razsoc','telefono','email','tipo')->get();
        if($request->ajax()){
            return datatables()
                // ->of(Cliente::select('id','numdoc','razsoc','celular','email'))
                ->of(Producto::with('Umedida')->select('id','nombre','umedida_id','stock','preventa_pen','grupo')
                ->where('empresa_id',session('empresa'))
                ->where('sede_id',session('sede')))
                ->addColumn('btn','admin.productos.action')
                ->rawColumns(['btn'])
                ->toJson();
        }
    }

    public function create()
    {
        $tipoproductos = Catproducto::whereIn('modulo',['1'])->orderBy('nombre')->pluck('nombre','id');
        $umedidas = Umedida::orderBy('nombre')->get()->pluck('codigo_nombre','codigo');
        $afectaciones = Afectacion::pluck('nombre','codigo');
        return view('admin.productos.create', compact('umedidas','tipoproductos','afectaciones'));
    }

    public function store(Request $request)
    {
        // 'nombre' => "required|unique:productos,nombre,$producto->id",
        $rules = [
            'tipoproducto_id' => 'required',
            'nombre' => 'required|unique:productos,nombre,NULL,id,deleted_at,NULL',
            'umedida_id' => 'required'
        ];
        
        $messages = [
    		'tipoproducto_id.required' => 'Ingrese Tipo de Producto | Servicio.',
    		'nombre.required' => 'Ingrese Nombre.',
            'nombre.unique' => 'Ya se encuentra registrado un Producto | Servicio con ese nombre.',
            'umedida_id.required' => 'Ingrese Unidad de Medida.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            $grupo = $request->input('grupo');
            $ultimo = Producto::select('codigo')
                ->where('sede_id', session('sede'))
                ->where('grupo',$grupo)
                ->orderBy('codigo','desc')
                ->first();
            if(empty($ultimo)){
                $codigo = $grupo.'00000001';
            }else{
                $codigo = $grupo.str_pad(intval(substr($ultimo->codigo,2,8))+1,8,'0',STR_PAD_LEFT);
            }
            $data = $request->all();
            $data = array_merge($data,['codigo'=>$codigo,'stock'=>0.00]);
            Producto::create($data);
            return redirect()->route('admin.productos.index')->with('store', 'Producto | Servicio Agregado');
        }
    }

    public function show($id)
    {
        //
    }

    public function edit(Producto $producto)
    {
        $tipoproductos = Catproducto::whereIn('modulo',['1'])->orderBy('nombre')->pluck('nombre','id');
        $umedidas = Umedida::orderBy('nombre')->get()->pluck('codigo_nombre','codigo');
        $afectaciones = Afectacion::pluck('nombre','codigo');
        $compras = Rcompra::with(['cliente:id,numdoc,razsoc'])
            ->join('detingresos','rcompras.id','detingresos.rcompra_id')
            ->where('detingresos.producto_id',$producto->id)
            ->whereNull('detingresos.deleted_at')
            ->orderBy('rcompras.fecha','desc')
            ->select('rcompras.fecha','rcompras.moneda','rcompras.tc','rcompras.cliente_id','detingresos.cantidad','detingresos.precio')
            ->take(10)->get();
        if($compras->count() == 0){
            $historial = 0;
            $tc = 0;
        }else{
            $historial = 1;
            $tc = $compras[0]->tc;
        }
        // return $compras;
        return view('admin.productos.edit', compact('producto','umedidas','tipoproductos','afectaciones','compras','historial','tc'));
    }

    public function update(Request $request, Producto $producto)
    {
        $rules = [
            'tipoproducto_id' => 'required',
            // required|unique:productos,nombre,NULL,id,deleted_at,NULL
            'nombre' => "required|unique:productos,nombre,$producto->id,id,deleted_at,NULL",
            'umedida_id' => 'required',
        ];
        
        $messages = [
    		'tipoproducto_id.required' => 'Ingrese Tipo de Producto | Servicio.',
    		'nombre.required' => 'Ingrese Nombre.',
    		'nombre.unique' => 'Ya se encuentra registrado un Producto | Servicio con ese nombre.',
            'umedida_id.required' => 'Ingrese Unidad de Medida.',
            'stockmin.required' => 'Ingrese Stock Mínimo.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            if($request->hasFile('imagen')){
                $ruta = Config::get('filesystems.disks.products.root');
                $extencion = trim($request->file('imagen')->getClientOriginalExtension());
                $img = Image::make($request->file('imagen'));
                $img->resize(700, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                Storage::disk('products')->makeDirectory($producto->id);
                $archivo = '/'.$producto->id.'/'.$producto->id.'.'.$extencion;
                $img->save($ruta.$archivo);
            } else {
                $archivo = $producto->imagen;
            }
            $producto->update([
                'tipoproducto_id' => $request->input('tipoproducto_id'),
                'nombre' => $request->input('nombre'),
                'umedida_id' => $request->input('umedida_id'),
                'afectacion_id' => $request->input('afectacion_id'),
                'icbper' => $request->input('icbper'),
                'lotevencimiento' => $request->input('lotevencimiento'),
                'ctrlstock' => $request->input('ctrlstock'),
                'stockmin' => $request->input('stockmin'),
                'utilidad_pen' => $request->input('utilidad_pen'),
                'utilidad_usd' => $request->input('utilidad_usd'),
                'preventamin_pen' => $request->input('preventamin_pen'),
                'preventamin_usd' => $request->input('preventamin_usd'),
                'preventa_pen' => $request->input('preventa_pen'),
                'preventa_usd' => $request->input('preventa_usd'),
                'codigobarra' => $request->input('codigobarra'),
                'detallada' => $request->input('detallada'),
                'imagen' => $archivo,
                ]);
            return redirect()->route('admin.productos.index')->with('update', 'Producto | Servicio Actualizado');
        }
    }

    public function destroy(Producto $producto)
    {
        if($producto->detingreso()->count()){
            return back()->with('message', 'Registro no puede ser eliminado, fue usado en Compras')->with('typealert', 'danger');
        }
        if($producto->detrventa()->count()){
            return back()->with('message', 'Registro no puede ser eliminado, fue usado en Ventas')->with('typealert', 'danger');
        }
        $producto->delete();
        return redirect()->route('admin.productos.index')->with('destroy', 'Producto Eliminado');
    }

    public function tabla_dp($producto)
    {
        $detproducto = Detproducto::with('producto')->where('producto_id',$producto)->get();
        return view('admin.productos.detproducto',compact('detproducto'));
    }

    public function adddp($envio)
    {
        // return true;
        $ao = json_decode($envio);
        if($ao->tipo == 1){
            $ultimo = Detproducto::select('codigo')
                ->where('producto_id', $ao->producto_id)
                ->where('sede_id', session('sede'))
                ->orderBy('codigo','desc')
                ->first();
            if(empty($ultimo)){
                $codigo = str_pad($ao->id, 5, '0', STR_PAD_LEFT).'0001';
            }else{
                $correlativo = str_pad(intval(substr($ultimo->codigo,6,4))+1,4,'0',STR_PAD_LEFT);
                $codigo = str_pad($ao->producto_id, 5, '0', STR_PAD_LEFT).$correlativo;
            }
            Detproducto::create([
                'producto_id' => $ao->producto_id,
                'sede_id' => session('sede'),
                'marca_id' => $ao->marca_id,
                'talla_id' => $ao->talla_id,
                'color_id' => $ao->color_id,
                'afecto' => $ao->afecto,
                'ctrlstock' => $ao->ctrlstock,
                'preventa' => $ao->preventa,
                'preventamin' => $ao->preventamin,
                'codigo' => $codigo,
                'lotevencimiento' => $ao->lotevencimiento,
                'stockmin' => $ao->stockmin,
            ]);

        }
        if($ao->tipo == 2){
            Detproducto::where('id',$ao->id)->update([
                'marca_id' => $ao->marca_id,
                'talla_id' => $ao->talla_id,
                'color_id' => $ao->color_id,
                'afecto' => $ao->afecto,
                'ctrlstock' => $ao->ctrlstock,
                'preventa' => $ao->preventa,
                'preventamin' => $ao->preventamin,
                'lotevencimiento' => $ao->lotevencimiento,
                'stockmin' => $ao->stockmin,
            ]);
        }
        return true;
    }

    public function showdetp(Request $request, Producto $producto){
        if($request->ajax()){
            // $pendiente = Rventa::join('detrventas','rventas.id', 'detrventas.rventa_id')
            //     ->where('rventas.status',1)
            //     ->where('detrventas.producto_id', $producto->id)
            //     ->whereNull('rventas.deleted_at')
            //     ->whereNull('detrventas.deleted_at')
            //     ->sum('cantidad');
            $pendiente = Tmpdetsalida::where('producto_id', $producto->id)
                ->sum('cantidad');
            $tmp = $producto;
            $tmp->stock = $tmp->stock - $pendiente;
            return response()->json($tmp);
        }
    }

    public function destroyitem(Detproducto $detproducto){
        return 2;
    }

    public function seleccionado(Request $request,$grupo=1)
    {
        if($request->ajax()){
            $term = trim($request->q);
            if (empty($term)) {
                return response()->json([]);
            }
            $umedida = Umedida::orderBy('nombre')->pluck('nombre','codigo');
            // $marca = Catproducto::whereIn('modulo',['0','2'])->orderBy('nombre')->pluck('nombre','id');
            // $talla = Catproducto::whereIn('modulo',['0','3'])->orderBy('nombre')->pluck('nombre','id');
            // $color = Catproducto::whereIn('modulo',['0','4'])->orderBy('nombre')->pluck('nombre','id');
            // $productos = Producto::with(['detproductos'])
            //     ->join('detproductos','productos.id','detproductos.producto_id')
            //     ->where('productos.grupo', $grupo)
            //     ->where('productos.nombre','like','%'.$term.'%')
            //     ->where('productos.empresa_id',session('empresa'))
            //     ->where('detproductos.sede_id',session('sede'))
            //     ->select('detproductos.id','productos.nombre','productos.umedida_id','detproductos.marca_id','detproductos.talla_id','detproductos.color_id')
            //     ->limit(10)
            //     ->get();

            $productos = Producto::select('id','nombre','productos.umedida_id')
                ->where('productos.grupo', $grupo)
                ->where('nombre','like','%'.$term.'%')
                ->where('empresa_id',session('empresa'))
                ->where('sede_id',session('sede'))
                ->orderBy('nombre')
                ->limit(10)
                ->get();

            $respuesta = array();
            foreach($productos as $producto){
                $nombre = $producto->nombre . ' X ' .$umedida[$producto->umedida_id];
                // if ($producto->marca_id <> 1){
                //     $nombre = $nombre . ' '.$marca[$producto->marca_id];
                // }
                // if ($producto->talla_id <> 1){
                //     $nombre = $nombre . ' '.$talla[$producto->talla_id];
                // }
                // if ($producto->color_id <> 1){
                //     $nombre = $nombre . ' '.$color[$producto->color_id];
                // }

                $respuesta[] = [
                    'id' => $producto->id,
                    'text' => $nombre,
                ];            
            }
            return $respuesta;
        }
    }

    public function seleccionadot(Request $request)
    {
        if($request->ajax()){
            $term = trim($request->q);
            if (empty($term)) {
                return response()->json([]);
            }
            $umedida = Umedida::orderBy('nombre')->pluck('nombre','codigo');

            $productos = Producto::select('id','nombre','productos.umedida_id')
                ->where('nombre','like','%'.$term.'%')
                ->where('empresa_id',session('empresa'))
                ->where('sede_id',session('sede'))
                ->orderBy('nombre')
                ->limit(10)
                ->get();

            $respuesta = array();
            foreach($productos as $producto){
                $nombre = $producto->nombre . ' X ' .$umedida[$producto->umedida_id];

                $respuesta[] = [
                    'id' => $producto->id,
                    'text' => $nombre,
                ];            
            }
            return $respuesta;
        }
    }

    public function seleccionadov(Request $request, $moneda = 'PEN', $grupo = 1)
    {
        if($request->ajax()){
            $term = trim($request->q);
            if (empty($term)) {
                return response()->json([]);
            }
            $umedida = Umedida::orderBy('nombre')->pluck('nombre','codigo');
            if ($moneda == 'PEN') {
                $productos = Producto::select('id','nombre','productos.umedida_id')
                ->where('productos.grupo', $grupo)
                ->where('nombre','like','%'.$term.'%')
                ->where('empresa_id',session('empresa'))
                ->where('sede_id',session('sede'))
                ->where('preventa_pen','>', 0)
                ->orderBy('nombre')
                ->limit(10)
                ->get();
            } else {
                $productos = Producto::select('id','nombre','productos.umedida_id')
                    ->where('productos.grupo', $grupo)
                    ->where('nombre','like','%'.$term.'%')
                    ->where('empresa_id',session('empresa'))
                    ->where('sede_id',session('sede'))
                    ->where('preventa_usd','>', 0)
                    ->orderBy('nombre')
                    ->limit(10)
                    ->get();
            }

            $respuesta = array();
            foreach($productos as $producto){
                $nombre = $producto->nombre . ' X ' .$umedida[$producto->umedida_id];
                $respuesta[] = [
                    'id' => $producto->id,
                    'text' => $nombre,
                ];            
            }
            return $respuesta;
        }
    }

    public function seleccionadoc(Request $request, $moneda = 'PEN', $grupo = 1)
    {
        if($request->ajax()){
            $term = trim($request->q);
            if (empty($term)) {
                return response()->json([]);
            }
            $umedida = Umedida::orderBy('nombre')->pluck('nombre','codigo');
            if ($moneda == 'PEN') {
                $productos = Producto::select('id','nombre','productos.umedida_id')
                ->where('productos.grupo', $grupo)
                ->where('nombre','like','%'.$term.'%')
                ->where('empresa_id',session('empresa'))
                ->where('sede_id',session('sede'))
                ->orderBy('nombre')
                ->limit(10)
                ->get();
            }
            $respuesta = array();
            foreach($productos as $producto){
                $nombre = $producto->nombre . ' X ' .$umedida[$producto->umedida_id];
                $respuesta[] = [
                    'id' => $producto->id,
                    'text' => $nombre,
                ];            
            }
            return $respuesta;
        }
    }

    public function findlote(Request $request, $producto, $bus)
    {
        if($request->ajax()){
            $venc = Vencimiento::where('producto_id',$producto)
                ->where('lote','like','%'.$bus.'%')
                ->where('saldo','>',0)
                ->orderBy('vencimiento')
                ->get();
            return response()->json($venc);
        }

    }

    public function selectlote(Request $request, Vencimiento $vencimiento)
    {
        if($request->ajax()){
            // $pendiente = Rventa::join('detrventas','rventas.id', 'detrventas.rventa_id')
            //     ->where('rventas.status',1)
            //     ->where('detrventas.producto_id', $vencimiento->producto_id)
            //     ->where('detrventas.lote', $vencimiento->lote)
            //     ->whereNull('rventas.deleted_at')
            //     ->whereNull('detrventas.deleted_at')
            //     ->sum('cantidad');
            $pendiente = Tmpdetsalida::where('producto_id', $vencimiento->producto_id)
                ->where('lote', $vencimiento->lote)
                ->sum('cantidad');
            $tmp = $vencimiento;
            $tmp->saldo = $tmp->saldo - $pendiente;
            return response()->json($tmp);
        }
    }

    public function buslote(Request $request, $producto, $lote)
    {
        if($request->ajax()){
            // $pendiente = Rventa::join('detrventas','rventas.id', 'detrventas.rventa_id')
            //     ->where('rventas.status',1)
            //     ->where('detrventas.producto_id', $producto)
            //     ->where('detrventas.lote', $lote)
            //     ->whereNull('rventas.deleted_at')
            //     ->whereNull('detrventas.deleted_at')
            //     ->sum('cantidad');
            $pendiente = Tmpdetsalida::where('producto_id', $producto)
                ->where('lote', $lote)
                ->sum('cantidad');
            $venc = Vencimiento::where('producto_id',$producto)->where('lote',$lote)->get();
            $tmp = $venc;
            $tmp[0]->saldo = $tmp[0]->saldo - $pendiente;
            return response()->json($tmp);
        }
    }


}

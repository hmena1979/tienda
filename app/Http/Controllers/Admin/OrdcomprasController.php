<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cotizacion;
use App\Models\Detcotizacion;
use App\Models\Detingreso;
use App\Models\Detrventa;
use App\Models\Producto;
use App\Models\Rcompra;
use GuzzleHttp\Utils;
use Illuminate\Http\Request;

use function GuzzleHttp\json_encode;

class OrdcomprasController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
		$this->middleware('can:admin.ordcompras.index')->only('index');
		$this->middleware('can:admin.ordcompras.create')->only('create','store');
		$this->middleware('can:admin.ordcompras.edit')->only('edit','update');
		// $this->middleware('can:admin.categorias.permission')->only('editpermission','updatepermission');
		// $this->middleware('can:admin.categorias.password')->only('editpassword','updatepassword');
    }

    public function index()
    {
        // if($periodo == '000000'){
        //     $periodo = session('periodo');
        // }
        // $materiaprimas = Materiaprima::where('empresa_id',session('empresa'))
        //     ->where('periodo',$periodo)
        //     ->orderBy('ingplanta','desc')->get();
        // return view('admin.materiaprimas.index',compact('materiaprimas','periodo'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }
 function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function busproducto($producto_id = 999999)
    {
        if ($producto_id == 999999) {
            $productos = [];
            $data = [
                'producto' => null,
                'productos' => $productos,
                'consumos' => null,
                'compras' => null,
                'cotizaciones' => null,
            ];
        } else {
            $producto = Producto::findOrFail($producto_id);
            $productos = [
                $producto->id => $producto->nombre . ' X ' . $producto->umedida->nombre,
            ];
            $consumos = $this->consumos($producto_id,session('periodo'));
            $compras = $this->compras($producto_id);
            $cotizaciones = $this->cotizaciones($producto_id);
            $data = [
                'producto' => $producto,
                'productos' => $productos,
                'consumos' => $consumos,
                'compras' => $compras,
                'cotizaciones' => $cotizaciones,
            ];
        }
    }

    public function consumos($producto_id, $periodo)
    {
        $periodoConsulta = $periodo;
        $resultado = [];
        for ($i = 1; $i <= 13; $i++) { 
            $suma = Detrventa::whereRelation('rventa',['periodo' => $periodoConsulta, 'tipo' => 2])
                ->where('producto_id', $producto_id)
                ->sum('cantidad');
            $mes = getMes(substr($periodoConsulta,0,2)). ' '. substr($periodoConsulta,2,4);
            // $resultado = array_merge($resultado, [$mes => $suma]);
            $periodoConsulta = pAnterior($periodoConsulta);
            $resultado[] = [
                'mes' => $mes,
                'consumo' => $suma,
            ];    
        }
        return Utils::jsonEncode($resultado);
    }

    public function compras($producto_id)
    {
        $compras = Detingreso::with(['rcompra:id,serie,numero,cliente_id','fechaingreso','moneda'])
            ->orderBy(Rcompra::select('fechaingreso')->whereColumn('detingresos.rcompra_id','rcompras.id'),'desc')
            ->where('producto_id',$producto_id)
            ->select('id','rcompra_id','cantidad','precio','subtotal')
            ->take(10)
            ->get();
        return $compras;
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
        return $cotizaciones;
    }
}

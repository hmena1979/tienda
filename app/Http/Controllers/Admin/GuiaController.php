<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Guia;
use App\Models\TipoComprobante;
use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\Kardex;
use App\Models\Producto;
use App\Models\Sede;
use App\Models\Tmpdetguia;
use App\Models\Vencimiento;
use App\Models\Departamento;
use App\Models\Provincia;
use App\Models\Ubigeo;

class GuiaController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
		$this->middleware('can:admin.guias.index')->only('index');
		$this->middleware('can:admin.guias.create')->only('create','store');
		$this->middleware('can:admin.guias.edit')->only('edit','update');
		// $this->middleware('can:admin.categorias.permission')->only('editpermission','updatepermission');
		// $this->middleware('can:admin.categorias.password')->only('editpassword','updatepassword');
    }

    public function index($periodo = '000000')
    {
        if($periodo == '000000'){
            $periodo = session('periodo');
        }
        $guias = Guia::with(['cliente'])
            ->select('id','fecha','serie','numero','tipocomprobante_codigo','cliente_id','status','cdr')
            ->where('periodo',$periodo)
            ->where('empresa_id',session('empresa'))
            ->where('sede_id',session('sede'))
            ->get();

        return view('admin.guias.index', compact('guias','periodo'));
    }

    public function change(Request $request)
    {
        $periodo = $request->input('mes').$request->input('año');
        $guias = Guia::with(['cliente'])
            ->select('id','fecha','serie','numero','tipocomprobante_codigo','cliente_id','status','cdr')
            ->where('periodo',$periodo)
            ->where('empresa_id',session('empresa'))
            ->where('sede_id',session('sede'))
            ->get();

        return view('admin.guias.index', compact('guias','periodo'));
    }

    public function create()
    {
        $tipocomprobante = TipoComprobante::wherein('codigo',['09'])->orderBy('codigo')->pluck('nombre','codigo');
        $key = generateRandomString();
        $docRelacionados = Categoria::where('modulo', 8)->orderBy('codigo')->pluck('nombre','codigo');
        $motivoTraslado = Categoria::where('modulo', 9)->orderBy('codigo')->pluck('nombre','codigo');
        $modalidadTraslado = Categoria::where('modulo', 10)->orderBy('codigo')->pluck('nombre','codigo');

        $departamentos = Departamento::pluck('nombre','codigo');
        // $provincias = Provincia::where('departamento',substr($ubicacion,0,2))->pluck('nombre','codigo');
        // $ubigeo = Ubigeo::where('provincia',substr($ubicacion,0,4))->pluck('nombre','codigo');

        $tipdoc = Categoria::where('modulo', 1)->orderBy('codigo')->pluck('nombre','codigo');
        $sexo = Categoria::where('modulo', 2)->pluck('nombre','codigo');
        $estciv = Categoria::where('modulo', 3)->pluck('nombre','codigo');

        return view('admin.guias.create',
            compact('tipocomprobante','key','tipdoc','docRelacionados','motivoTraslado',
            'modalidadTraslado','departamentos','tipdoc','sexo','estciv'));
    }

    public function store(Request $request)
    {
        $data = [
            'empresa_id' => $request->input('empresa_id'),
            'sede_id' => $request->input('sede_id'),
            'periodo' => $request->input('periodo'),
            'tipocomprobante_codigo' => '09',
            'fecha' => $request->input('fecha'),
            'fechatraslado' => $request->input('fechatraslado'),
            'motivotraslado_id' => $request->input('motivotraslado_id'),
            'tipdoc_relacionado_id' => $request->input('tipdoc_relacionado_id'),
            'numdoc_relacionado' => $request->input('numdoc_relacionado'),
            'puerto' => $request->input('puerto'),
            'transbordo' => $request->input('transbordo'),
            'modalidadtraslado_id' => $request->input('modalidadtraslado_id'),
            'tipodoctransportista_id' => $request->input('tipodoctransportista_id'),
            'numdoctransportista' => $request->input('numdoctransportista'),
            'razsoctransportista' => $request->input('razsoctransportista'),
            'placa' => $request->input('placa'),
            'tipodocchofer_id' => $request->input('tipodocchofer_id'),
            'documentochofer' => $request->input('documentochofer'),
            'cliente_id' => $request->input('cliente_id'),
            'tercero_id' => $request->input('tercero_id'),
            'pesototal' => $request->input('pesototal'),
            'ubigeo_partida' => $request->input('ubigeo_partida'),
            'punto_partida' => $request->input('punto_partida'),
            'ubigeo_llegada' => $request->input('ubigeo_llegada'),
            'punto_llegada' => $request->input('punto_llegada'),
        ];

        // $cliente = Cliente::find($request->input('cliente_id'));
        $sede = Sede::find(session('sede'));
        $correlativo = $sede->guia_corr + 1;
        $sede->update([
            'guia_corr' => $correlativo
        ]);
        $serie = $sede->guia_serie;
        $numero = str_pad($correlativo, 8, '0', STR_PAD_LEFT);
                
        $key = $request->input('key');
        $data = array_merge($data, [
            'serie' => $serie,
            'numero' => $numero,
            'status' => 1,
        ]);
        // Inicio
        $guia = Guia::create($data);
        $detalle = Tmpdetguia::where('user_id',Auth::user()->id)->where('key',$key)->get();
        foreach($detalle as $det){
            // Crea registro en Detalle de Comprobante
            $detguia = $guia->detguia()->create([
                'producto_id' => $det->producto_id,
                'adicional' => $det->adicional,
                'cantidad' => $det->cantidad,
            ]);
        }

        // Envío a servidor de Sunat en caso sea Factura
        if ($guia->tipocomprobante_codigo == '09') {
            $sunat = new SunatController();
            $msm = $sunat->guias($guia);
            // $var = $this->sunat($rventa);
        }
        if ($guia->status <> 3) {
    
            //Ingreso de Detalle de Comprobante
            $detalle = $guia->detguias;
            Tmpdetguia::where('user_id',Auth::user()->id)->where('key',$key)->delete();
        }
        
        return response()->json($guia);
            // return redirect()->route('admin.rventas.index')->with('store', 'Registro Agregado, Ingrese Productos | Servicios');
        // }
    }

    public function show(Guia $guia)
    {
        //
    }

    public function edit(Guia $guia)
    {
        //
    }

    public function update(Request $request, Guia $guia)
    {
        //
    }

    public function destroy(Guia $guia)
    {
        //
    }

    public function additem(Request $request)
    {
        Tmpdetguia::create([
            'user_id' => Auth::user()->id,
            'key' => $request->input('keydet'),
            'producto_id' => $request->input('producto_id'),
            'adicional' => e($request->input('adicional')),
            'cantidad' => $request->input('cantidad'),
            'lote' => $request->input('lote'),
            'vence' => $request->input('vence'),
        ]);
        return true;
    }

    public function destroyitem(Tmpdetguia $tmpdetguia){
        $tmpdetguia->delete();
        return 1;
    }

    public function tablaitem($key)
    {
        Tmpdetguia::where('user_id',Auth::user()->id)->update(['key'=>$key]);
        $detalle = Tmpdetguia::with('Producto')->where('user_id',Auth::user()->id)->where('key',$key)->get();
        $items = $detalle->count();
        return view('admin.guias.detalle',compact('detalle','items'));
    }
}

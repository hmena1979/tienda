<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreDetrcompraRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Models\Rcompra;
use App\Models\TipoComprobante;
use App\Models\Categoria;
use App\Models\Ccosto;
use App\Models\Cliente;
use App\Models\Cuenta;
use App\Models\Destino;
use App\Models\Detraccion;
use App\Models\Detrcompra;
use App\Models\Tesoreria;
use App\Models\Dettesor;
use App\Models\Empresa;
use DOMDocument;
use DOMXPath;
use phpDocumentor\Reflection\Types\This;
use SimpleXMLElement;

use function GuzzleHttp\json_decode;

class RcompraController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
		$this->middleware('can:admin.rcompras.index')->only('index');
		$this->middleware('can:admin.rcompras.create')->only('create','store');
		$this->middleware('can:admin.rcompras.edit')->only('edit','update');
		// $this->middleware('can:admin.categorias.permission')->only('editpermission','updatepermission');
		// $this->middleware('can:admin.categorias.password')->only('editpassword','updatepassword');
    }

    public function index($periodo = '000000')
    {
        if($periodo == '000000'){
            $periodo = session('periodo');
        }
        $rcompras = Rcompra::with(['cliente'])
            ->select('id','fecha','moneda','serie','numero','tipocomprobante_codigo','cliente_id','total')
            ->where('periodo',$periodo)
            ->where('empresa_id',session('empresa'))
            ->where('sede_id',session('sede'))
            ->get();

        $impuesto = round(Rcompra::where('periodo',$periodo)
            ->where('empresa_id',session('empresa'))
            ->where('sede_id',session('sede'))
            ->get()
            ->sum('impuestosol'),2);
        
        $renta = round(Rcompra::where('periodo',$periodo)
            ->where('empresa_id',session('empresa'))
            ->where('sede_id',session('sede'))
            ->get()
            ->sum('rentasol'),2);

        $rentalq = round(Rcompra::where('periodo',$periodo)
            ->where('empresa_id',session('empresa'))
            ->where('sede_id',session('sede'))
            ->get()
            ->sum('rentalqsol'),2);
            
        return view('admin.rcompras.index', compact('rcompras','periodo','impuesto','renta','rentalq'));
    }

    public function change(Request $request)
    {
        $periodo = $request->input('mes').$request->input('año');
        $rcompras = Rcompra::with(['cliente'])
            ->select('id','fecha','moneda','serie','numero','tipocomprobante_codigo','cliente_id','total')
            ->where('periodo',$periodo)
            ->where('empresa_id',session('empresa'))
            ->where('sede_id',session('sede'))
            ->get();
            $impuesto = round(Rcompra::where('periodo',$periodo)
            ->where('empresa_id',session('empresa'))
            ->where('sede_id',session('sede'))
            ->get()
            ->sum('impuestosol'),2);
        
        $renta = round(Rcompra::where('periodo',$periodo)
            ->where('empresa_id',session('empresa'))
            ->where('sede_id',session('sede'))
            ->get()
            ->sum('rentasol'),2);
        
        $rentalq = round(Rcompra::where('periodo',$periodo)
            ->where('empresa_id',session('empresa'))
            ->where('sede_id',session('sede'))
            ->get()
            ->sum('rentalqsol'),2);

        return view('admin.rcompras.index', compact('rcompras','periodo','impuesto','renta','rentalq'));
    }

    public function create()
    {
        $moneda = Categoria::where('modulo', 4)->pluck('nombre','codigo');
        $tipocomprobante = TipoComprobante::orderBy('codigo')->pluck('nombre','codigo');
        $tipooperacion = Categoria::where('modulo', 7)->pluck('nombre','codigo');
        $mediopago = Categoria::where('modulo', 5)->pluck('nombre','codigo');
        $cuenta = Cuenta::where('empresa_id',session('empresa'))
                ->where('sede_id',session('sede'))
                ->where('moneda','PEN')
                ->pluck('nombre','id');
        $detraccions = Detraccion::orderBy('codigo')->get()->pluck('codigo_nombre','codigo');
        $proveedores = [];

        $tipdoc = Categoria::where('modulo', 1)->orderBy('codigo')->pluck('nombre','codigo');
        $sexo = Categoria::where('modulo', 2)->pluck('nombre','codigo');
        $estciv = Categoria::where('modulo', 3)->pluck('nombre','codigo');

        $rcompra = new Rcompra;
        $rcompra->moneda = 'PEN';

        return view('admin.rcompras.create',
            compact('moneda','tipocomprobante','tipooperacion','mediopago','cuenta',
                'detraccions','tipdoc','sexo','estciv','rcompra','proveedores'));
    }

    public function store(Request $request)
    {
        $rules = [
            'fecha' => 'required',
            'tipocomprobante_codigo' => 'required',
            'cliente_id' => 'required',
            'numero' => 'required',
            'total' => 'required'
        ];
        $tipcomp = TipoComprobante::where('codigo',$request->input('tipocomprobante_codigo'))->value('tipo');
        if($tipcomp == 1){
            $rules = array_merge($rules,[
                'tipooperacion_id' => 'required'            
            ]);
        }
        $detraccion_monto = $request->input('detraccion_monto');
        $total = $request->input('total') - $detraccion_monto;
        if($request->input('fpago') == 1){
            $pagos = $request->input('total')-$detraccion_monto;
            $saldo = $detraccion_monto;
            $rules = array_merge($rules,[
                'mediopago' => 'required',
                'cuenta_id' => 'required',
                'numerooperacion' => 'required'
            ]);
        }else{
            $pagos = 0;
            $saldo = $request->input('total')-$detraccion_monto;
        }
        
        $messages = [
    		'fecha.required' => 'Ingrese Fecha.',
    		'tipocomprobante_codigo.required' => 'Ingrese Tipo de Comprobante.',
    		'cliente_id.required' => 'Ingrese Proveedor.',
    		'numero.required' => 'Ingrese Número.',
    		'total.required' => 'Ingrese Total.',
    		'tipooperacion_id.required' => 'Ingrese Tipo de Operación.',
    		'mediopago.required' => 'Ingrese Medio Pago.',
    		'cuenta_id.required' => 'Ingrese Origen Pago.',
    		'numerooperacion.required' => 'Ingrese Número de Operación.'
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            $repetido = 0;
            $repetido = Rcompra::where('tipocomprobante_codigo',$request->input('tipocomprobante_codigo'))
                ->where('serie',$request->input('serie'))
                ->where('numero',$request->input('numero'))
                ->where('cliente_id',$request->input('cliente_id'))
                ->count();
            if($repetido <> 0){
                return back()->with('message', 'Se ha producido un error, Documento ya fue ingresado')->with('typealert', 'danger')->withinput();
            }
            if($request->input('almacen') == 1){
                $peringreso = $request->input('periodo');
            }else{
                $peringreso = null;
            }
            $data = $request->all();
            $data = array_merge($data,[
                'peringreso' => $peringreso,
                'tipocomprobante_tipo' => $tipcomp,
                'pagado' => $pagos,
                'saldo' => $saldo
            ]);
            $glosa = Cliente::where('id',$request->input('cliente_id'))->value('razsoc');
            $r = Rcompra::create($data);
            if($request->input('moneda') == 'PEN'){
                $montopen = $total;
                $montousd = round($total/$request->input('tc'),2);
            }else{
                $montousd = $total;
                $montopen = round($total*$request->input('tc'),2);
            }
            if($request->input('fpago') == 1 && $request->input('tipocomprobante_codigo') <> '07'){
                $bt = Tesoreria::where('cuenta_id',$request->input('cuenta_id'))
                        ->where('tipo',2)
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
                        'tipo' => 2,
                        'fecha' => $request->input('fecha'),
                        'tc' => $request->input('tc'),
                        'mediopago' => $request->input('mediopago'),
                        'numerooperacion' => $request->input('numerooperacion'),
                        'monto' => $montotal,
                        'glosa' => $glosa
                    ]);
                    $r->dettesors()->create([
                        'tesoreria_id' => $t->id,
                        'montopen' => $montopen,
                        'montousd' => $montousd,
                    ]);
                }else{
                    $t = Tesoreria::find($bt);
                    $glosa = $glosa == $t->glosa ? $glosa : 'VARIOS COMPRA/SERVICIO';
                    $monto = $t->monto + $montotal;
                    // $montopen1 = $t->montopen + $montopen;
                    // $montousd1 = $t->montousd + $montousd;
                    $t->update([
                        'monto' => $monto,
                        'glosa' => $glosa
                    ]);
                    $r->dettesors()->create([
                        'tesoreria_id' => $t->id,
                        'montopen' => $montopen,
                        'montousd' => $montousd,
                    ]);
                    
                }
            }
            

            return redirect()->route('admin.rcompras.index')->with('store', 'Registro Agregado');
        }
    }

    public function show(Rcompra $rcompra)
    {
        //
    }

    public function edit(Rcompra $rcompra)
    {
        // $clientes = Cliente::get();
        // return $clientes;
        $moneda = Categoria::where('modulo', 4)->pluck('nombre','codigo');
        $tipocomprobante = TipoComprobante::orderBy('codigo')->pluck('nombre','codigo');
        $clientes = Cliente::where('id',$rcompra->cliente_id)->get()->pluck('numdoc_razsoc','id');
        $tipooperacion = Categoria::where('modulo', 7)->pluck('nombre','codigo');
        $mediopago = Categoria::where('modulo', 5)->pluck('nombre','codigo');
        $cuenta = Cuenta::where('empresa_id',session('empresa'))
                ->where('sede_id',session('sede'))
                ->where('moneda',$rcompra->moneda)
                ->pluck('nombre','id');
        $detraccions = Detraccion::orderBy('codigo')->get()->pluck('codigo_nombre','codigo');

        return view('admin.rcompras.edit',
            compact('rcompra','moneda','tipocomprobante','clientes','tipooperacion',
            'mediopago','cuenta','detraccions'));
    }

    public function update(Request $request, Rcompra $rcompra)
    {
        $detraccion_monto = $request->input('detraccion_monto');
        $total = $request->input('total') - $detraccion_monto;
        $rules = [
            'fecha' => 'required',
            'tipocomprobante_codigo' => 'required',
            'cliente_id' => 'required',
            'numero' => 'required',
            'total' => 'required'
        ];
        if($request->input('fpago') == 1){
            $pagado = $request->input('total');
            $saldo = 0;
            $rules = array_merge($rules,[
                'mediopago' => 'required',
                'cuenta_id' => 'required',
                'numerooperacion' => 'required'
            ]);
        }else{
            $pagado = $rcompra->pagado;
            $saldo = $total - $pagado;
        }
        $tipcomp = TipoComprobante::where('codigo',$request->input('tipocomprobante_codigo'))->value('tipo');
        if($tipcomp == 1){
            $rules = array_merge($rules,[
                'tipooperacion_id' => 'required'            
            ]);
        }
        $messages = [
    		'fecha.required' => 'Ingrese Fecha.',
    		'tipocomprobante_codigo.required' => 'Ingrese Tipo de Comprobante.',
    		'cliente_id.required' => 'Ingrese Proveedor.',
    		'numero.required' => 'Ingrese Número.',
    		'total.required' => 'Ingrese Total.',
    		'tipooperacion_id.required' => 'Ingrese Tipo de Operación.',
    		'mediopago.required' => 'Ingrese Medio Pago.',
    		'cuenta_id.required' => 'Ingrese Origen Pago.',
    		'numerooperacion.required' => 'Ingrese Número de Operación.'
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            if($request->input('almacen') == 1){
                $peringreso = $request->input('periodo');
            }else{
                $peringreso = null;
            }
            $data = $request->all();
            // $data = $request->except('saldo');
            $data = array_merge($data,[
                'peringreso' => $peringreso,
                'tipocomprobante_tipo' => $tipcomp,
                'pagado' => $pagado,
                'saldo' => $saldo
            ]);
            // return $data;
            $rcompra->update($data);

            // Elimina Registro en Tesoreria
            if($rcompra->dettesors->count() > 0){
                $detalletesoreria = $rcompra->dettesors[0];
                $idtesor = $detalletesoreria->tesoreria_id;
                
                $moncta = $detalletesoreria->tesoreria->cuenta->moneda;
                $rcompra->dettesors[0]->delete();
                // return $detalletesoreria;
                if($moncta == 'PEN'){
                    $tottes = Dettesor::where('tesoreria_id',$idtesor)->sum('montopen');
                }else{
                    $tottes = Dettesor::where('tesoreria_id',$idtesor)->sum('montousd');
                }
                if($tottes == 0){
                    Tesoreria::where('id', $idtesor)->delete();
                }else{
                    Tesoreria::where('id', $idtesor)->update([
                        'monto' => $tottes,
                    ]);
                }
            }
            // Fin Elimina
            // return true;

            if($request->input('moneda') == 'PEN'){
                $montopen = $total;
                $montousd = round($total/$request->input('tc'),2);
            }else{
                $montousd = $total;
                $montopen = round($total*$request->input('tc'),2);
            }
            
            if($request->input('fpago') == 1 && $request->input('tipocomprobante_codigo') <> '07'){
                $glosa = Cliente::where('id',$request->input('cliente_id'))->value('razsoc');
                $bt = Tesoreria::where('cuenta_id',$request->input('cuenta_id'))
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
                        'tipo' => 2,
                        'fecha' => $request->input('fecha'),
                        'tc' => $request->input('tc'),
                        'mediopago' => $request->input('mediopago'),
                        'numerooperacion' => $request->input('numerooperacion'),
                        'monto' => $montotal,
                        'glosa' => $glosa
                    ]);
                    $rcompra->dettesors()->create([
                        'tesoreria_id' => $t->id,
                        'montopen' => $montopen,
                        'montousd' => $montousd,
                    ]);
                }else{
                    $t = Tesoreria::find($bt);
                    $glosa = $glosa == $t->glosa ? $glosa : 'VARIOS COMPRA/SERVICIO';
                    $monto = $t->monto + $montotal;
                    // $montopen1 = $t->montopen + $montopen;
                    // $montousd1 = $t->montousd + $montousd;
                    $t->update([
                        'monto' => $monto,
                        'glosa' => $glosa
                    ]);
                    $rcompra->dettesors()->create([
                        'tesoreria_id' => $t->id,
                        'montopen' => $montopen,
                        'montousd' => $montousd,
                    ]);
                    
                }
            }
            // return $data['tipocomprobante_tipo'];
            return redirect()->route('admin.rcompras.index')->with('update', 'Registro Actualizado');
        }
    }

    public function destroy(Rcompra $rcompra)
    {
        // Error si tiene productos en Almacen
        if($rcompra->detingresos->count() > 0){
            return redirect()->route('admin.rcompras.index')->with('message', 'Se ha producido un error, No se puede eliminar, En almacen ya contiene productos')->with('typealert', 'danger');
        }
        // Elimina Registro en Tesoreria
        if($rcompra->dettesors->count() > 0){ 
            foreach($rcompra->dettesors as $det){
                $idTesoreria = $det->tesoreria_id;
                $idDetTesoreria = $det->id;
                $moncta = $det->tesoreria->cuenta->moneda;
                Dettesor::where('id',$idDetTesoreria)->delete();
                // $rcompra->dettesors[0]->delete();
                if($moncta == 'PEN'){
                    $tottes = Dettesor::where('tesoreria_id',$idTesoreria)->sum('montopen');
                }else{
                    $tottes = Dettesor::where('tesoreria_id',$idTesoreria)->sum('montousd');
                }
                if($tottes == 0){
                    Tesoreria::where('id', $idTesoreria)->delete();
                }else{
                    Tesoreria::where('id', $idTesoreria)->update([
                        'monto' => $tottes,
                    ]);
                }

            }
        }
        //Elimina Registro de Compras
        $rcompra->delete();

        return redirect()->route('admin.rcompras.index')->with('destroy', 'Registro Eliminado');
    }

    public function BusTc(Request $request, $fecha)
    {
        if($request->ajax()){
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
                return response()->json($api);
                //return $api;
            }
        }
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

    public function detrcompra(Rcompra $rcompra)
    {
        $tipocomprobante = TipoComprobante::orderBy('codigo')->pluck('nombre','codigo');
        $clientes = Cliente::where('id',$rcompra->cliente_id)->get()->pluck('numdoc_razsoc','id');
        $destinos = Destino::where('empresa_id',session('empresa'))->orderBy('nombre')->pluck('nombre','id');
        $ccosto = Ccosto::where('empresa_id',session('empresa'))->orderBy('nombre')->pluck('nombre','id');

        return view('admin.rcompras.detrcompra',
            compact('rcompra','tipocomprobante','clientes','destinos','ccosto'));
    }

    public function pendiente(Request $request, $proveedor)
    {
    	// if($request->ajax()){
    		$rcompras = Rcompra::select('id','fecha','moneda','tipocomprobante_codigo','serie','numero','saldo')
                ->where('cliente_id',$proveedor)
                ->where('saldo','>',0)
                // ->where('tipocomprobante_codigo','<>','07')
                ->get();
    		return response()->json($rcompras);
    	// }
    }

    public function materiaprima(Request $request, $proveedor, $lote)
    {
    	// if($request->ajax()){
    		$rcompras = Rcompra::select('id','serie','numero')
                ->where('cliente_id',$proveedor)
                ->where('lote',$lote)
                ->get();
    		return response()->json($rcompras);
    	// }
    }

    
    public function adddestino(StoreDetrcompraRequest $request)
    {
        // if ($request->ajax()) {
            $data = [
                'rcompra_id' => $request->input('id'),
                'detdestino_id' => $request->input('detdestino_id'),
                'ccosto_id' => $request->input('ccosto_id'),
                'monto' => $request->input('monto'),
            ];
            $detrcompra = Detrcompra::create($data);
        // }
        return 'Hola';
    }

    public function tablaitem(Request $request, Rcompra $rcompra)
    {
        if ($request->ajax()) {
            return view('admin.rcompras.destinos',compact('rcompra'));
        }
    }

    public function destroyitem(Detrcompra $detrcompra)
    {
        $detrcompra->delete();
    }
    
    public function leerXML(Request $request)
    {
        $empresa = Empresa::findOrFail(session('empresa'));
        $extencion = $request->file('xml')->getClientOriginalExtension();
        if ($extencion <> 'xml' && $extencion <> 'XML') {
            return back()->with('message', 'Error: Solo se pueden importar archivos XML.')->with('typealert', 'danger');
        }
        $texto = $_FILES["xml"];
        $xmlp = file_get_contents($texto['tmp_name']);
        $xmlp = str_replace('cbc:','',$xmlp);
        $xmlp = str_replace('/cbc:','',$xmlp);
        $xmlp = str_replace('cac:','',$xmlp);
        $xmlp = str_replace('/cac:','',$xmlp);
        $xmlp = str_replace('ext:','',$xmlp);
        $xmlp = str_replace('/ext:','',$xmlp);
        $xmlp = str_replace('ds:','',$xmlp);
        $xmlp = str_replace('/ds:','',$xmlp);
        $xml = str_replace('\n','',$xmlp);
        $xml = str_replace('\t','',$xmlp);
        // $cac = "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2";
        // $cac = "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2";
        $xml = simplexml_load_string($xmlp);

        $emisor = trim($xml->AccountingCustomerParty->Party->PartyIdentification->ID);
        $numero = trim($xml->ID);
        if ($emisor <> $empresa->ruc) {
            return back()->with('message', 'Error: XML no fue emitido para esta Empresa.')->with('typealert', 'danger');
        }
        $numDocProveedor = trim($xml->AccountingSupplierParty->Party->PartyIdentification->ID);
        // $numDocProveedor = '10804869161';
        $proveedor = Cliente::where('numdoc',$numDocProveedor)->first();
        if ($proveedor) {
            $rc = Rcompra::where('cliente_id',$proveedor->id)
                ->where('serie', serieNumero($numero, 1))
                ->where('numero', serieNumero($numero, 2))
                ->count();
            if ($rc > 0) {
                return back()->with('message', 'Error: Comprobante ya fue Ingresado.')->with('typealert', 'danger');
            }
        }
        if ($proveedor == null) {
            $perm = new ClienteController();
            if (strlen($numDocProveedor) == 8) {
                $infProveedor = $perm->BusApiXML('1',$numDocProveedor);
                if ($infProveedor) {
                    $razsoc = $infProveedor->apellidoPaterno.' '.$infProveedor->apellidoMaterno.' '.$infProveedor->nombres;
                    $proveedor = Cliente::create([
                        'tipdoc_id' => 1,
                        'numdoc' => $infProveedor->dni,
                        'ape_pat' => $infProveedor->apellidoPaterno,
                        'ape_mat' => $infProveedor->apellidoMaterno,
                        'nombres' => $infProveedor->nombres,
                        'razsoc' => $razsoc,
                        'nomcomercial' => $razsoc,
                    ]);
                    $proveedores = [$proveedor->id => $proveedor->numdoc.'-'.$proveedor->razsoc];
                } else {
                    $proveedores = [];
                }
            }
            if (strlen($numDocProveedor) == 11) {
                $infProveedor = $perm->BusApiXML('6',$numDocProveedor);
                if ($infProveedor) {
                    $nomcomercial = $infProveedor->nombreComercial==null?$infProveedor->razonSocial:$infProveedor->nombreComercial;
                    $proveedor = Cliente::create([
                        'tipdoc_id' => 6,
                        'numdoc' => $infProveedor->ruc,
                        'razsoc' => $infProveedor->razonSocial,
                        'nomcomercial' => $nomcomercial
                    ]);
                    $proveedores = [$proveedor->id => $proveedor->numdoc.'-'.$proveedor->razsoc];
                } else {
                    $proveedores = [];
                }
            }
        } else {
            $proveedores = [$proveedor->id => $proveedor->numdoc.'-'.$proveedor->razsoc];
        }
        if ($proveedor == null) {
            return back()->with('message', 'Error: No se pudo crear el Proveedor, Ingréselo y vuelva a Importar XML.')->with('typealert', 'danger');
        }
        $td = trim($xml->InvoiceTypeCode);
        $fecha = trim($xml->IssueDate);
        $moneda = trim($xml->DocumentCurrencyCode);
        $tc = $this->BusTcXML($fecha);
        $afecto = floatval($xml->LegalMonetaryTotal->LineExtensionAmount);
        $exonerado = 0;
        $igv = 0;
        $isc = 0;
        $renta = 0;
        $icbper = 0;
        $total = floatval($xml->LegalMonetaryTotal->PayableAmount);
        foreach ($xml->TaxTotal->TaxSubtotal as $det) {
            if ($det->TaxCategory->TaxScheme->Name == 'IGV') {
                if (floatval($det->TaxAmount) > 0.00) {
                    $igv = floatval($det->TaxAmount);
                }
            }
            if ($det->TaxCategory->TaxScheme->Name == 'ISC') {
                if (floatval($det->TaxAmount) > 0.00) {
                    $isc = floatval($det->TaxAmount);
                }
            }
            if ($det->TaxCategory->TaxScheme->Name == 'IR') {
                if (floatval($det->TaxAmount) > 0.00) {
                    $renta = floatval($det->TaxAmount);
                }
            }
            if ($det->TaxCategory->TaxScheme->Name == 'EXONERADO') {
                if (floatval($det->TaxableAmount) > 0.00) {
                    $exonerado = $exonerado + floatval($det->TaxableAmount);
                }
            }
            if ($det->TaxCategory->TaxScheme->Name == 'INAFECTO') {
                if (floatval($det->TaxableAmount) > 0.00) {
                    $exonerado = $exonerado + floatval($det->TaxableAmount);
                }
            }
            if ($det->TaxCategory->TaxScheme->Name == 'ICBPER') {
                if (floatval($det->TaxAmount) > 0.00) {
                    $icbper = floatval($det->TaxAmount);
                }
            }
        }
        $rcompra = new Rcompra;
        $rcompra->empresa_id = session('empresa');
        $rcompra->sede_id = session('sede');
        $rcompra->periodo = session('periodo');
        $rcompra->fpago = 2;
        $rcompra->dias = 0;
        $rcompra->vencimiento = $fecha;
        $rcompra->tipocomprobante_codigo = $td;
        if ($td == '04') {
            $rcompra->tipocomprobante_tipo = 2;
        } else {
            $rcompra->tipocomprobante_tipo = 1;
        }
        $rcompra->fecha = $fecha;
        $rcompra->tc = $tc;
        $rcompra->moneda = $moneda;
        $rcompra->serie = serieNumero($numero, 1);
        $rcompra->numero = serieNumero($numero, 2);
        if ($proveedor){
            $rcompra->cliente_id = $proveedor->id;
        }
        if ($afecto > 0) {
            $rcompra->afecto = $afecto;
        }
        if ($exonerado > 0) {
            $rcompra->exonerado = $exonerado;
        }
        if ($igv > 0) {
            $rcompra->igv = $igv;
        }
        if ($isc > 0) {
            $rcompra->isc = $isc;
        }
        if ($renta > 0) {
            $rcompra->renta = $renta;
        }
        if ($icbper > 0) {
            $rcompra->icbper = $icbper;
        }
        if ($total > 0) {
            $rcompra->total = $total;
            $rcompra->saldo = $total;
        }
        $rcompra->save();
        return redirect()->route('admin.rcompras.edit', $rcompra)->with('store', 'Comprobante Agregado, revise Forma de Pago');

    }
}

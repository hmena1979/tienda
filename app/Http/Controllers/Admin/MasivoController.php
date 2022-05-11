<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

use App\Models\Masivo;
use App\Models\Cuenta;
use App\Models\Detcliente;
use App\Models\Detmasivo;
use App\Models\Dettesor;
use App\Models\Rcompra;
use App\Models\Tesoreria;
use Facade\FlareClient\Http\Response;

class MasivoController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
		$this->middleware('can:admin.masivos.index')->only('index');
		$this->middleware('can:admin.masivos.create')->only('create','store');
		$this->middleware('can:admin.masivos.edit')->only('edit','update');
    }

    public function index($periodo = '000000')
    {
        if($periodo == '000000'){
            $periodo = session('periodo');
        }
        $estado = [1=>'PENDIENTE', 2=>'APROBADO', 3=>'GENERADO'];
        $masivos = Masivo::where('periodo',$periodo)
            ->where('empresa_id',session('empresa'))
            ->where('sede_id',session('sede'))
            ->get();
        return view('admin.masivos.index', compact('masivos','periodo','estado'));
    }

    public function change(Request $request)
    {
        $periodo = $request->input('mes').$request->input('año');
        $estado = [1=>'PENDIENTE', 2=>'APROBADO', 3=>'GENERADO'];
        $masivos = Masivo::where('periodo',$periodo)
            ->where('empresa_id',session('empresa'))
            ->where('sede_id',session('sede'))
            ->get();
        return view('admin.masivos.index', compact('masivos','periodo','estado'));
    }

    public function create()
    {
        $cuentas = Cuenta::where('empresa_id',session('empresa'))
            ->where('sede_id',session('sede'))
            ->pluck('nombre','id');


        return view('admin.masivos.create', compact('cuentas'));
    }

    public function store(Request $request)
    {
        $rules = [
            'cuenta_id' => 'required',
            'fecha' => 'required',
            'tc' => 'required',
            'glosa' => 'required'
        ];
        
        $messages = [
    		'cuenta_id.required' => 'Seleccione Cuenta.',
    		'fecha.required' => 'Ingrese Fecha.',
    		'tc.required' => 'Ingrese Tipo de Cambio.',
    		'glosa.required' => 'Ingrese Glosa.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            $masivo = Masivo::create($request->all());
            return redirect()->route('admin.masivos.edit',$masivo)->with('store', 'Registro Agregado, Ingrese detalle');
        }
    }

    public function show(Masivo $masivo)
    {
        //
    }

    public function edit(Masivo $masivo)
    {
        $cuentas = Cuenta::where('empresa_id',session('empresa'))
            ->where('sede_id',session('sede'))
            ->where('moneda', $masivo->cuenta->moneda)
            ->pluck('nombre','id');

        return view('admin.masivos.edit', compact('masivo','cuentas'));
    }

    public function update(Request $request, Masivo $masivo)
    {
        $rules = [
            'cuenta_id' => 'required',
            'fecha' => 'required',
            'tc' => 'required',
            'glosa' => 'required'
        ];
        
        $messages = [
    		'cuenta_id.required' => 'Seleccione Cuenta.',
    		'fecha.required' => 'Ingrese Fecha.',
    		'tc.required' => 'Ingrese Tipo de Cambio.',
    		'glosa.required' => 'Ingrese Glosa.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            $masivo->update($request->all());
            return redirect()->route('admin.masivos.index')->with('update', 'Registro Actualizado');
        }
    }

    public function destroy(Masivo $masivo)
    {
        //
    }

    public function tablaitem(Masivo $masivo)
    {
        return view('admin.masivos.detalle',compact('masivo'));
    }

    public function pendientes(Masivo $masivo)
    {
    	// if($request->ajax()){
    		$rcompras = Rcompra::with(['cliente'])
                ->select('id','cliente_id','vencimiento','moneda','tipocomprobante_codigo','serie','numero','saldo','total_masivo')
                ->where('moneda', $masivo->cuenta->moneda)
                ->get()
                ->where('pendiente','>',0);
            return view('admin.masivos.pendientes',compact('rcompras','masivo'));
    	// }
    }

    public function procesa(Request $request)
    {
        // $masivo = $request->rcompra[0]['masivo_id'];
        if ($request->rcompra[1]['masivo_id']) {
            $masivo = Masivo::findOrFail($request->rcompra[1]['masivo_id']);
            $moneda = $masivo->cuenta->moneda;
            $tc = $masivo->tc;
            foreach ($request->rcompra as $rc) {
                // return response()->json($rc['monto']);
                if ($rc['paga'] == 1 && $rc['monto'] <= $rc['saldo']) {
                    if ($masivo->cuenta->moneda == 'PEN') {
                        $montopen = $rc['monto'];
                        $montousd = round($rc['monto'] / $masivo->tc, 2);
                    } else {
                        $montopen = round($rc['monto'] * $masivo->tc,2);
                        $montousd = $rc['monto'];
                    }
                    $rcompra = Rcompra::find($rc['id']);
                    $rcompra->update([
                        'masivo' => 1,
                        'total_masivo' => $rcompra->total_masivo + $rc['monto']
                    ]);
                    $bus = Detcliente::where('cliente_id', $rcompra->cliente_id)
                        ->where('banco_id',$masivo->cuenta->banco_id)
                        ->where('moneda',$moneda)
                        ->value('cuenta');
                    if ($bus) {
                        $cuenta = $bus;
                        $tipo = 'P';
                    } else {
                        $bus = Detcliente::where('cliente_id', $rcompra->cliente_id)
                        ->where('moneda',$moneda)
                        ->value('cci');
                        if ($bus) {
                            $cuenta = $bus;
                            $tipo = 'I';
                        } else {
                            $cuenta = null;
                            $tipo = 'E';
                        }
                    }
                    Detmasivo::create([
                        'masivo_id' => $rc['masivo_id'],
                        'rcompra_id' => $rc['id'],
                        'cuenta' => $cuenta,
                        'tipo' => $tipo,
                        'montopen' => $montopen,
                        'montousd' => $montousd,
                    ]);
                }
            }
            if ($masivo->cuenta->moneda == 'PEN') {
                $masivo->update([
                    'monto' => $masivo->detmasivos->sum('montopen')
                ]);
            } else {
                $masivo->update([
                    'monto' => $masivo->detmasivos->sum('montousd')
                ]);
            }
            return response()->json($request->all());
        }
    }

    public function autorizar(Masivo $masivo)
    {
        $conteo = Detmasivo::where('masivo_id', $masivo->id)->where('tipo', 'E')->count();
        if ($conteo == 0) {
            $masivo->update([
                'estado' => 2
            ]);
            return 1;
        } else {
            return 2;
        }
    }

    public function generar(Masivo $masivo)
    {
        //---------------------------------------------------------------------------------------
        foreach($masivo->detmasivos as $cmp) {
            if($masivo->cuenta->moneda == 'PEN'){
                $montotal = $cmp->montopen;
            }else{
                $montotal = $cmp->montousd;
            }
            $t = Tesoreria::create([
                'empresa_id' => session('empresa'),
                'sede_id' => session('sede'),
                'periodo' => session('periodo'),
                'cuenta_id' => $masivo->cuenta_id,
                'tipo' => 2,
                'fecha' => $masivo->fecha,
                'tc' => $masivo->tc,
                'mediopago' => '001',
                'monto' => $montotal,
                'glosa' => $cmp->rcompra->cliente->razsoc
            ]);
            Dettesor::create([
                'dettesorable_id' => $cmp->rcompra->id,
                'dettesorable_type' => 'App\Models\Rcompra',
                'tesoreria_id' => $t->id,
                'montopen' => $cmp->montopen,
                'montousd' => $cmp->montousd,
            ]);
            $r = Rcompra::find($cmp->rcompra->id);
            $pagado = $r->pagado + $montotal;
            $saldo = $r->saldo - $montotal;
            $tmasivo = $r->total_masivo - $montotal;
            $masrc = $tmasivo == 0 ? 2 : 1;
            $r->update([
                'pagado' => $pagado,
                'saldo' => $saldo,
                'total_masivo' => $tmasivo,
                'masivo' => $masrc
            ]);
        }
        //---------------------------------------------------------------------------------------
        if ($masivo->cuenta->banco_id == 3){
            $cuenta = str_pad($masivo->cuenta->numerocta, 20, '0', STR_PAD_RIGHT);
            $moneda = $masivo->cuenta->moneda;
            $entera = floor($masivo->monto);
            $pentera = str_pad($entera,13,'0',STR_PAD_LEFT);
            $decimal = decimal($masivo->monto,2);
            $esp15 = str_pad('00', 15, '0', STR_PAD_RIGHT);
            $esp9 = '         ';
            $fecha = substr($masivo->fecha, 0, 4).substr($masivo->fecha, 5, 2).substr($masivo->fecha, 8, 2);
            $glosa = str_pad($masivo->glosa, 25, ' ', STR_PAD_RIGHT);
            $lineas = str_pad($masivo->detmasivos->count(),6,'0',STR_PAD_LEFT);
            $fin = str_pad('',18,'0',STR_PAD_LEFT);
            $esp50 = '                                                  ';
            $cabecera = '750'.$cuenta.$moneda.$pentera.$decimal.'A'.$fecha.$glosa.$lineas.'S'.$fin.$esp50;
            $detalles = '';
            foreach($masivo->detmasivos as $det) {
                switch($det->rcompra->cliente->tipdoc_id) {
                    case '1':
                        $td = 'L';
                        break;
                    case '4':
                        $td = 'E';
                        break;
                    case '6':
                        $td = 'R';
                        break;
                }
                $numdoc = str_pad($det->rcompra->cliente->numdoc,12,' ',STR_PAD_RIGHT);
                $tipo = $det->tipo;
                $cuenta = str_pad($det->cuenta,20,' ',STR_PAD_RIGHT);
                $beneficiario = substr(str_pad($det->rcompra->cliente->razsoc, 40,' ',STR_PAD_RIGHT), 0, 40);
                if ($masivo->cuenta->moneda == 'PEN') {
                    $entera = floor($det->montopen);
                    $pentera = str_pad($entera,13,'0',STR_PAD_LEFT);
                    $decimal = decimal($det->montopen,2);
                    // $decimal = ($det->montopen-intval($det->montopen))*100;
                } else {
                    $entera = floor($det->montousd);
                    $pentera = str_pad($entera,13,'0',STR_PAD_LEFT);
                    $decimal = decimal($det->montousd,2);
                    // $decimal = ($det->montousd-intval($det->montousd))*100;
                }
                $trecibo = 'F';
                $documento = str_pad($det->rcompra->serie.$det->rcompra->numero,12,' ',STR_PAD_RIGHT);
                $abono = 'N';
                $referencia = str_pad($masivo->glosa,40,' ',STR_PAD_RIGHT);
                $esp = str_pad(' ',81,' ',STR_PAD_RIGHT);
                $ceros = str_pad('0',32,'0',STR_PAD_LEFT);
                $espfinal = '                  ';
                $item = '002'.$td.$numdoc.$tipo.$cuenta.$beneficiario.$pentera.$decimal.$trecibo.$documento.$abono.$referencia.$esp.$ceros.$espfinal;
                $detalles .= "\r\n".$item;
            }
            $archivo =  'BBVA'.$masivo->cuenta->moneda.substr($masivo->fecha, 0, 4).substr($masivo->fecha, 5, 2).substr($masivo->fecha, 8, 2).'.txt';
            
            $resultado = $cabecera.$detalles;
            $arcresul = $masivo->id.'/'.$archivo;
            Storage::disk('masivos')->put($arcresul, $resultado);
            $masivo->update(['estado' => 3]);
        }
        if ($masivo->cuenta->banco_id == 2){
            $numope = str_pad($masivo->detmasivos->count(),6,'0',STR_PAD_LEFT);
            $fecha = substr($masivo->fecha, 0, 4).substr($masivo->fecha, 5, 2).substr($masivo->fecha, 8, 2);
            $cuenta = str_pad($masivo->cuenta->numerocta, 13, '0', STR_PAD_RIGHT);
            $esp7 = '       ';
            $entera = floor($masivo->monto);
            $pentera = str_pad($entera,14,'0',STR_PAD_LEFT);
            $decimal = decimal($masivo->monto,2);
            $glosa = str_pad($masivo->glosa, 40, ' ', STR_PAD_RIGHT);
            $codigo = str_pad($masivo->id,15,'0',STR_PAD_LEFT);
            $cabecera = '1'.$numope.$fecha.'C0001'.$cuenta.$esp7.$pentera.'.'.$decimal.$glosa.'N'.$codigo;
            $detalles = '';
            foreach($masivo->detmasivos as $det) {
                if($det->tipo == 'I') {
                    $tipo = 'B';
                } else {
                    if (substr($det->rcompra->cliente->numdoc,0,1) == '2') {
                        $tipo = 'C';
                    } else {
                        $tipo = 'A';
                    }
                }
                $cuenta = str_pad($det->cuenta,20,' ',STR_PAD_RIGHT);
                $tipdoc = $det->rcompra->cliente->tipdoc_id;
                $numdoc = str_pad($det->rcompra->cliente->numdoc,15,' ',STR_PAD_RIGHT);
                $nombre = str_pad($det->rcompra->cliente->razsoc,75,' ',STR_PAD_RIGHT);
                $refben = 'Referencia Beneficiario ';
                $refemp = 'Ref Emp ';
                $nd_emp = $numdoc = str_pad($det->rcompra->cliente->numdoc,12,' ',STR_PAD_RIGHT);
                if ($masivo->cuenta->moneda == 'PEN') {
                    $entera = floor($det->montopen);
                    $pentera = str_pad($entera,14,'0',STR_PAD_LEFT);
                    $decimal = decimal($det->montopen,2);
                    // $decimal = ($det->montopen-intval($det->montopen))*100;
                } else {
                    $entera = floor($det->montousd);
                    $pentera = str_pad($entera,14,'0',STR_PAD_LEFT);
                    $decimal = decimal($det->montousd,2);
                    // $decimal = ($det->montousd-intval($det->montousd))*100;
                }
                $item = '2'.$tipo.$cuenta.'1'.$tipdoc.$numdoc.$nombre.$refben.$numdoc.' '.$refemp.$nd_emp.'0001'.$pentera.'.'.$decimal.'S';
                if ($det->rcompra->tipocomprobante_codigo == '01') {
                    $tcomp = 'F0';
                } else {
                    $tcomp = 'D0';
                }
                $numcomprobante = str_pad(numDoc($det->rcompra->serie, $det->rcompra->numero),15,' ',STR_PAD_RIGHT);
                $dets = '3'.$tcomp.$numcomprobante.$pentera.'.'.$decimal;
                $detalles .= "\r\n".$item."\r\n".$dets;
            }
            $archivo =  'BCP'.$masivo->cuenta->moneda.substr($masivo->fecha, 0, 4).substr($masivo->fecha, 5, 2).substr($masivo->fecha, 8, 2).'.txt';
            
            $resultado = $cabecera.$detalles;
            $arcresul = $masivo->id.'/'.$archivo;
            Storage::disk('masivos')->put($arcresul, $resultado);
            $masivo->update(['estado' => 3]);
        }
        return true;
    }
    
    public function destroyitem(Detmasivo $detmasivo)
    {
        $moneda = $detmasivo->masivo->cuenta->moneda;
        if ($detmasivo->masivo->cuenta->moneda == 'PEN') {
            $monto = $detmasivo->montopen;
        } else {
            $monto = $detmasivo->montousd;
        }
        $rcompra = Rcompra::find($detmasivo->rcompra_id);
        if ($rcompra->total_masivo == $monto) {
            $rcompra->update([
                'total_masivo' => $rcompra->total_masivo - $monto,
                'masivo' => 2
            ]);
        } else {
            $rcompra->update([
                'total_masivo' => $rcompra->total_masivo - $monto,
            ]);
        }
        $detmasivo->delete();

        $masivo = Masivo::findOrFail($detmasivo->masivo_id);
        if ($masivo->cuenta->moneda == 'PEN') {
            $masivo->update([
                'monto' => $masivo->detmasivos->sum('montopen')
            ]);
        } else {
            $masivo->update([
                'monto' => $masivo->detmasivos->sum('montousd')
            ]);
        }

        return true;
    }

    public function download_macro(Masivo $masivo)
    {
        if ($masivo->cuenta->banco_id == 3){
            $archivo =  'BBVA'.$masivo->cuenta->moneda.substr($masivo->fecha, 0, 4).substr($masivo->fecha, 5, 2).substr($masivo->fecha, 8, 2).'.txt';
        }
        if ($masivo->cuenta->banco_id == 2){
            $archivo =  'BCP'.$masivo->cuenta->moneda.substr($masivo->fecha, 0, 4).substr($masivo->fecha, 5, 2).substr($masivo->fecha, 8, 2).'.txt';
        }
        $arcresul = $masivo->id.'/'.$archivo;
        // return response()->download(url('masivos/'.$arcresul));
        $contents = Storage::disk('masivos')->get($arcresul);
        return response($contents, 200)
        ->withHeaders(
            [
                'Content-Type' => 'text/plain',
                'Cache-Control' => 'no-store, no-cache',
                'Content-Disposition' => 'attachment; filename="'.$archivo.'"',
            ]
        );
    }
}

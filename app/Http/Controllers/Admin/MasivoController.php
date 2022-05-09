<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cuenta;
use App\Models\Detcliente;
use App\Models\Detmasivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Masivo;
use App\Models\Rcompra;

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
        //
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
        // str_pad($correlativo, 8, '0', STR_PAD_LEFT);
        $cuenta = str_pad($masivo->cuenta->numerocta, 20, '0', STR_PAD_RIGHT);
        $moneda = $masivo->cuenta->moneda;
        $esp15 = str_pad('00', 15, '0', STR_PAD_RIGHT);
        $esp9 = str_pad('', 15, ' ', STR_PAD_RIGHT);
        $glosa = str_pad($masivo->glosa, 25, ' ', STR_PAD_RIGHT);
        $contenido = '750'.$cuenta.$moneda.$esp15.'A'.$esp9.'S';

        return $contenido;
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

        return true;
    }
}

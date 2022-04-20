<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Categoria;
use App\Models\Cuenta;
use App\Models\Tesoreria;
use App\Models\Transferencia;

class TransferenciaController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
		$this->middleware('can:admin.transferencias.index')->only('index');
		$this->middleware('can:admin.transferencias.create')->only('create','store');
		$this->middleware('can:admin.transferencias.edit')->only('edit','update','detstore');
		// $this->middleware('can:admin.categorias.permission')->only('editpermission','updatepermission');
		// $this->middleware('can:admin.categorias.password')->only('editpassword','updatepassword');
    }

    public function index($periodo = '000000')
    {
        if($periodo == '000000'){
            $periodo = session('periodo');
        }
        $transferencias = Transferencia::where('periodo',$periodo)
            ->where('empresa_id',session('empresa'))
            ->where('sede_id',session('sede'))
            ->get();
            
        return view('admin.transferencias.index', compact('transferencias','periodo'));
    }

    public function change(Request $request)
    {
        $periodo = $request->input('mes').$request->input('año');
        $transferencias = Transferencia::where('periodo',$periodo)
            ->where('empresa_id',session('empresa'))
            ->where('sede_id',session('sede'))
            ->get();

        return view('admin.transferencias.index', compact('transferencias','periodo'));
    }

    public function create()
    {
        $cuenta = Cuenta::where('empresa_id',session('empresa'))->pluck('nombre','id');
        $mediopago = Categoria::where('modulo', 5)->pluck('nombre','codigo');
        return view('admin.transferencias.create', compact('cuenta','mediopago'));
    }

    public function store(Request $request)
    {
        $rules = [
            'fecha' => 'required',
            'tc' => 'required',
            'mediopago' => 'required',
            'cargo_id' => 'required|different:abono_id',
            'abono_id' => 'required',
            'numerooperacion' => 'required',
            'montopen' => 'required',
            'montousd' => 'required',
            'glosa' => 'required'
        ];
        
        $messages = [
    		'fecha.required' => 'Ingrese Fecha.',
    		'tc.required' => 'Ingrese Tipo de Cambio.',
    		'mediopago.required' => 'Ingrese Medio Pago.',
    		'cargo_id.required' => 'Seleccione Cuenta de Cargo.',
    		'cargo_id.different' => 'Cuenta de Cargo no puede ser igual a la de Abono.',
    		'abono_id.required' => 'Seleccione Cuenta de Abono.',
    		'numerooperacion.required' => 'Ingrese Número Operación.',
    		'montopen.required' => 'Ingrese Monto en Soles.',
    		'montousd.required' => 'Ingrese Monto en Dólares.',
    		'glosa.required' => 'Ingrese Glosa.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            $transferencia = Transferencia::create($request->all());
            // Cargo en Tesoreria
            $monedaCtaCargo = Cuenta::where('id', $request->input('cargo_id'))->value('moneda');
            if($monedaCtaCargo == 'PEN'){
                $monTotalCargo = $request->input('montopen');
            }else{
                $monTotalCargo = $request->input('montousd');
            }
            $tesoreriaCargo = Tesoreria::create([
                'empresa_id' => session('empresa'),
                'sede_id' => session('sede'),
                'periodo' => session('periodo'),
                'cuenta_id' => $request->input('cargo_id'),
                'tipo' => 2,
                'edit' => 2,
                'fecha' => $request->input('fecha'),
                'tc' => $request->input('tc'),
                'mediopago' => $request->input('mediopago'),
                'numerooperacion' => $request->input('numerooperacion'),
                'monto' => $monTotalCargo,
                'glosa' => $request->input('glosa')
            ]);
            $transferencia->dettesors()->create([
                'tesoreria_id' => $tesoreriaCargo->id,
                'montopen' => $request->input('montopen'),
                'montousd' => $request->input('montousd'),
            ]);
            // Abono en Tesoreria
            $monedaCtaAbono = Cuenta::where('id', $request->input('abono_id'))->value('moneda');
            if($monedaCtaAbono == 'PEN'){
                $monTotalAbono = $request->input('montopen');
            }else{
                $monTotalAbono = $request->input('montousd');
            }
            $tesoreriaAbono = Tesoreria::create([
                'empresa_id' => session('empresa'),
                'sede_id' => session('sede'),
                'periodo' => session('periodo'),
                'cuenta_id' => $request->input('abono_id'),
                'tipo' => 1,
                'edit' => 2,
                'fecha' => $request->input('fecha'),
                'tc' => $request->input('tc'),
                'mediopago' => $request->input('mediopago'),
                'numerooperacion' => $request->input('numerooperacion'),
                'monto' => $monTotalAbono,
                'glosa' => $request->input('glosa')
            ]);
            $transferencia->dettesors()->create([
                'tesoreria_id' => $tesoreriaAbono->id,
                'montopen' => $request->input('montopen'),
                'montousd' => $request->input('montousd'),
            ]);
            return redirect()->route('admin.transferencias.index')->with('store', 'Registro Agregado');
        }
    }

    public function show(Transferencia $transferencia)
    {
        
    }

    public function edit(Transferencia $transferencia)
    {
        $cuenta = Cuenta::where('empresa_id',session('empresa'))->pluck('nombre','id');
        $mediopago = Categoria::where('modulo', 5)->pluck('nombre','codigo');
        return view('admin.transferencias.edit', compact('transferencia','cuenta','mediopago'));
    }

    public function update(Request $request, Transferencia $transferencia)
    {
        $rules = [
            'fecha' => 'required',
            'tc' => 'required',
            'mediopago' => 'required',
            'cargo_id' => 'required|different:abono_id',
            'abono_id' => 'required',
            'numerooperacion' => 'required',
            'montopen' => 'required',
            'montousd' => 'required',
            'glosa' => 'required'
        ];
        
        $messages = [
    		'fecha.required' => 'Ingrese Fecha.',
    		'tc.required' => 'Ingrese Tipo de Cambio.',
    		'mediopago.required' => 'Ingrese Medio Pago.',
    		'cargo_id.required' => 'Seleccione Cuenta de Cargo.',
    		'cargo_id.different' => 'Cuenta de Cargo no puede ser igual a la de Abono.',
    		'abono_id.required' => 'Seleccione Cuenta de Abono.',
    		'numerooperacion.required' => 'Ingrese Número Operación.',
    		'montopen.required' => 'Ingrese Monto en Soles.',
    		'montousd.required' => 'Ingrese Monto en Dólares.',
    		'glosa.required' => 'Ingrese Glosa.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            $transferencia->update($request->all());
            foreach($transferencia->dettesors as $det) {
                $tesoreria_id = $det->tesoreria_id;
                $tesoreria = Tesoreria::find($tesoreria_id);
                if ($tesoreria->tipo == 2) {
                    // Cargo en Tesoreria
                    $monedaCtaCargo = Cuenta::where('id', $request->input('cargo_id'))->value('moneda');
                    if($monedaCtaCargo == 'PEN'){
                        $monTotalCargo = $request->input('montopen');
                    }else{
                        $monTotalCargo = $request->input('montousd');
                    }
                    $tesoreria->update([
                        'cuenta_id' => $request->input('cargo_id'),
                        'fecha' => $request->input('fecha'),
                        'tc' => $request->input('tc'),
                        'mediopago' => $request->input('mediopago'),
                        'numerooperacion' => $request->input('numerooperacion'),
                        'monto' => $monTotalCargo,
                        'glosa' => $request->input('glosa')
                    ]);
                } else {
                    // Abono en Tesoreria
                    $monedaCtaAbono = Cuenta::where('id', $request->input('abono_id'))->value('moneda');
                    if($monedaCtaAbono == 'PEN'){
                        $monTotalAbono = $request->input('montopen');
                    }else{
                        $monTotalAbono = $request->input('montousd');
                    }
                    $tesoreria->update([
                        'cuenta_id' => $request->input('abono_id'),
                        'fecha' => $request->input('fecha'),
                        'tc' => $request->input('tc'),
                        'mediopago' => $request->input('mediopago'),
                        'numerooperacion' => $request->input('numerooperacion'),
                        'monto' => $monTotalAbono,
                        'glosa' => $request->input('glosa')
                    ]);
                }
                $det->update([
                    'montopen' => $request->input('montopen'),
                    'montousd' => $request->input('montousd'),
                ]);
            }
            return redirect()->route('admin.transferencias.index')->with('update', 'Registro Actualizado');
        }
    }

    public function destroy(Transferencia $transferencia)
    {
        foreach($transferencia->dettesors as $det) {
            Tesoreria::where('id', $det->tesoreria_id)->delete();
            $det->delete();
        }
        $transferencia->delete();
        return redirect()->route('admin.transferencias.index')->with('destroy', 'Transferencia Eliminada');
    }
}

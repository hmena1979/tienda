<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Catembarque;
use App\Models\Cliente;
use App\Models\Country;
use App\Models\Detsalcamara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

use App\Models\Embarque;
use App\Models\Pproceso;
use App\Models\Salcamara;
use App\Models\Transportista;

class EmbarqueController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
		$this->middleware('can:admin.embarques.index')->only('index');
		$this->middleware('can:admin.embarques.create')->only('create','store');
		$this->middleware('can:admin.embarques.edit')->only('edit','update');
    }

    public function index($periodo = '000000')
    {
        if($periodo == '000000'){
            $periodo = session('periodo');
        }
        $embarques = Embarque::where('empresa_id', session('empresa'))
            ->where('periodo', $periodo)
            ->get();    
        return view('admin.embarques.index',compact('embarques','periodo'));
    }

    public function change(Request $request)
    {
        $periodo = $request->input('mes').$request->input('año');
        $embarques = Embarque::where('empresa_id', session('empresa'))
            ->where('periodo', $periodo)
            ->get();    
        return view('admin.embarques.index',compact('embarques','periodo'));
    }

    public function create()
    {
        $transportistas = Transportista::where('empresa_id',session('empresa'))
            ->orderBy('nombre')->pluck('nombre','id');
        $moneda = Categoria::where('modulo',4)->orderBy('nombre')->pluck('nombre','codigo');
        $countries = Country::orderBy('nombre')->pluck('nombre','id');
        $stuffing = Catembarque::where('modulo',1)->orderBy('nombre')->pluck('nombre','id');
        $ffw = Catembarque::where('modulo',2)->orderBy('nombre')->pluck('nombre','id');
        $agaduana = Catembarque::where('modulo',3)->orderBy('nombre')->pluck('nombre','id');
        $release =Catembarque::where('modulo',4)->orderBy('nombre')->pluck('nombre','id');
        $pi2 = Catembarque::whereIn('modulo',[0,5])->orderBy('nombre')->pluck('nombre','id');
        $py = Catembarque::whereIn('modulo',[0,6])->orderBy('nombre')->pluck('nombre','id');
        $payt = Catembarque::whereIn('modulo',[0,7])->orderBy('nombre')->pluck('nombre','id');
        return view('admin.embarques.create',
            compact('moneda','transportistas','countries','stuffing','ffw','agaduana','release','pi2','py','payt'));
    }

    public function store(Request $request)
    {
        $rules = [
            'lote' => ['required',
                function($attribute, $value, $fail) {
                    $contador = Embarque::where('lote',$value)
                        ->where('empresa_id',session('empresa'))
                        ->count();
                    if ($contador > 0) {
                        $fail(__('Ya se encuentra registrado'));
                    }
                }],
            'cliente_id' => 'required',
        ];
        $messages = [
    		'lote.required' => 'Ingrese Lote.',
            'cliente_id.required' => 'Seleccione Lote',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            $embarque = Embarque::create($request->all());
            return redirect()->route('admin.embarques.index')->with('store', 'Registro agregado');
        }
    }

    public function show(Embarque $embarque)
    {
        //
    }

    public function edit(Embarque $embarque)
    {
        $transportistas = Transportista::where('empresa_id',session('empresa'))
            ->orderBy('nombre')->pluck('nombre','id');
        $clientes = Cliente::where('id',$embarque->cliente_id)->get()->pluck('numdoc_razsoc','id');
        $moneda = Categoria::where('modulo',4)->orderBy('nombre')->pluck('nombre','codigo');
        $countries = Country::orderBy('nombre')->pluck('nombre','id');
        $stuffing = Catembarque::where('modulo',1)->orderBy('nombre')->pluck('nombre','id');
        $ffw = Catembarque::where('modulo',2)->orderBy('nombre')->pluck('nombre','id');
        $agaduana = Catembarque::where('modulo',3)->orderBy('nombre')->pluck('nombre','id');
        $release =Catembarque::where('modulo',4)->orderBy('nombre')->pluck('nombre','id');
        $pi2 = Catembarque::whereIn('modulo',[0,5])->orderBy('nombre')->pluck('nombre','id');
        $py = Catembarque::whereIn('modulo',[0,6])->orderBy('nombre')->pluck('nombre','id');
        $payt = Catembarque::whereIn('modulo',[0,7])->orderBy('nombre')->pluck('nombre','id');
        return view('admin.embarques.edit',
            compact('embarque','clientes','moneda','transportistas','countries','stuffing','ffw',
                'agaduana','release','pi2','py','payt'));
    }

    public function update(Request $request, Embarque $embarque)
    {
        $rules = [
            'lote' => [
                'required',
                Rule::unique('embarques')->where(function ($query) use ($embarque) {
                    return $query->where('id','<>',$embarque->id)
                        ->whereNull('deleted_at')
                        ->where('empresa_id',session('empresa'));
                }),
            ],
            'cliente_id' => 'required',
        ];
        $messages = [
    		'lote.required' => 'Ingrese Número.',
    		'lote.unique' => 'Lote ya fue ingresado.',
    		'transportista_id.required' => 'Seleccione Transportista.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            $embarque->update($request->all());
            // return redirect()->route('admin.salcamaras.index')->with('update', 'Registro Actualizado');
            return redirect()->route('admin.embarques.edit',$embarque)->with('update', 'Registro Actualizado');
        }
    }

    public function destroy(Embarque $embarque)
    {
        $embarque->delete();
        return redirect()->route('admin.embarques.index')->with('destroy', 'Registro Eliminado');
    }

    public function valores($lote)
    {
        $salcamara = Salcamara::where('lote',$lote)->first();
        $productoTerminados = Detsalcamara::whereRelation('salcamara','lote','=',$lote)
            ->groupBy('pproceso_id')
            ->selectRaw('pproceso_id')
            ->get();
        if ($salcamara && $productoTerminados) {
            $cantidad = Detsalcamara::whereRelation('salcamara','lote','=',$lote)
                ->sum('cantidad');
            
            $productos = '';
            foreach ($productoTerminados as $det) {
                $pproceso = Pproceso::find($det->pproceso_id);
                $productos .= $pproceso->nombre. ' ';
            }
            $valores = [
                'transportista_id' => $salcamara->transportista_id,
                'contenedor' => $salcamara->contenedor,
                'grt' => $salcamara->grt,
                'grr' => $salcamara->gr,
                'precinto_hl' => $salcamara->precinto_hl,
                'precinto_linea' => $salcamara->precinto_linea,
                'precinto_ag' => $salcamara->precinto_ag,
                'producto' => $productos,
                'peso_neto' => $cantidad * 20,
                'atd_paking' => $salcamara->fecha,
                'sacos' => $cantidad,
            ];
        } else {
            $valores = [
                'transportista_id' => null,
                'contenedor' => null,
                'grt' => null,
                'grr' => null,
                'precinto_hl' => null,
                'precinto_linea' => null,
                'precinto_ag' => null,
                'producto' => null,
                'peso_neto' => null,
                'atd_paking' => null,
                'sacos' => null,
            ];
        }
        return response()->json($valores);
    }
}

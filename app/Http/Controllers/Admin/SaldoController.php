<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Admin\KardexController;

use App\Models\Producto;
use App\Models\Kardex;
use App\Models\Saldo;
use App\Models\Sede;

class SaldoController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
		$this->middleware('can:admin.saldos.index')->only('index');
		$this->middleware('can:admin.saldos.create')->only('create','store');
		$this->middleware('can:admin.saldos.edit')->only('edit','update');
		$this->middleware('can:admin.utils.regenerasaldo')->only('gregenera','pregenera');
		// $this->middleware('can:admin.categorias.permission')->only('editpermission','updatepermission');
		// $this->middleware('can:admin.categorias.password')->only('editpassword','updatepassword');
    }

    public function index()
    {
        $saldos = Saldo::with(['producto'])
            ->whereRelation('producto',['empresa_id' => session('empresa'), 'sede_id' => session('sede')])
            ->where('periodo', '000000')
            ->orderBy(Producto::select('nombre')->whereColumn('saldos.producto_id','productos.id'))
            ->get();
        return view('admin.saldos.index',compact('saldos'));
    }

    public function create()
    {
        return view('admin.saldos.create');
    }

    public function store(Request $request)
    {
        $rules = [
            // 'producto_id' => 'required|unique:saldos',
            'producto_id' => ['required',
                function($attribute, $value, $fail) {
                    $contador = Saldo::where('producto_id',$value)
                        ->where('periodo','000000')
                        ->count();
                    if ($contador > 0) {
                        $fail(__('Ya se encuentra registrado'));
                    }
                }],


            'saldo' => 'required',
        ];
        
        $messages = [
            'producto_id.required' => 'Seleccione Producto.',
    		'producto_id.unique' => 'Producto ya fue Ingresado.',
    		'saldo.required' => 'Ingrese Cantidad.',
        ];
        $data = $request->all();
        $data = array_merge($data,[
            'periodo' => '000000',
            'inicial' => 0.00,
            'entradas' => $request->input('saldo'),
        ]);
        $validator = Validator::make($data, $rules, $messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            Saldo::create($data);
            return redirect()->route('admin.saldos.index')->with('store', 'Saldo Inicial Agregado, Regenere Saldos');
        }
    }

    public function show(Saldo $saldo)
    {
        //
    }

    public function edit(Saldo $saldo)
    {
        $producto = Producto::findOrFail($saldo->producto_id);
        $productos = [
            $producto->id => $producto->nombre . ' X ' . $producto->umedida->nombre,
        ];
        return view('admin.saldos.edit', compact('saldo','productos'));
    }

    public function update(Request $request, Saldo $saldo)
    {
        // $rules = [
        //     'producto_id' => "required|unique:saldos,producto_id,".$saldo->id,
        //     'saldo' => 'required',
        // ];

        $rules = [
            'producto_id' => [
                'required',
                Rule::unique('saldos')->where(function ($query) use ($saldo) {
                    return $query->where('id','<>',$saldo->id)->where('periodo','000000');
                }),
            ],
            'saldo' => 'required',
        ];
        
        $messages = [
    		'producto_id.required' => 'Seleccione Producto.',
    		'producto_id.unique' => 'Producto ya fue Ingresado.',
    		'saldo.required' => 'Seleccione Producto.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            $data = $request->all();
            $data = array_merge($data, [
                'entradas' => $request->input('saldo'),
            ]);
            $saldo->update($data);
            return redirect()->route('admin.saldos.index')->with('update', 'Saldo Inicial Actualizada, Regenere Saldos');
        }
    }

    public function destroy(Saldo $saldo)
    {
        $saldo->delete();
        return redirect()->route('admin.saldos.index')->with('destroy', 'Saldo Eliminado, Regenere Saldos');
    }

    public function gregenera()
    {
        return view('admin.saldos.regenera');
    }

    public function pregenera(Request $request)
    {
        if ($request->input('tipo') == 1) {
            $rules = [
                'periodo' => 'required',
            ];
        } else {
            $rules = [
                'producto_id' => "required",
                'periodo' => 'required',
            ];
        }
        $messages = [
    		'producto_id.required' => 'Seleccione Producto.',
    		'periodo.required' => 'Ingrese Periodo.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            if( $request->input('tipo') == 1) {
                $periodo = e($request->input('periodo'));
                $productos = Producto::where('empresa_id', session('empresa'))
                    ->where('sede_id', session('sede'))
                    ->get();
                $kardex = new KardexController();
                foreach($productos as $producto){
                    $kardex->Regenerate($periodo, $producto->id);
                }
            }else{
                $producto = e($request->input('producto_id'));
                $periodo = e($request->input('periodo'));
                $kardex = new KardexController();
                $kardex->Regenerate($periodo, $producto);
            }
        }
        return redirect()->route('admin.saldos.gregenera')->with('message', 'Saldo regenerado')->with('typealert', 'success');
    }

    public function cierremes($periodo = '000000')
    {
        if($periodo == '000000'){
            $periodo = session('periodo');
        }
        $perant = pAnterior($periodo);
        //-------------------Regenera Stock------------------------------------------------
        $productos = Producto::select('id')
            ->where('empresa_id',session('empresa'))
            ->where('sede_id',session('sede'))
            ->get();
        $kardex = new KardexController();
        foreach($productos as $producto){
            $b = $kardex->Regenerate($periodo,$producto->id);
        }
        //---------------------------------------------------------------------------------
        //-------------------Genera saldos------------------------------------------------
        Saldo::where('periodo', $periodo )->delete();
        $productos = Producto::select('id','stock','precompra')
            ->where('empresa_id',session('empresa'))
            ->where('sede_id',session('sede'))
            ->get();
        foreach($productos as $producto){
            $entradas = Kardex::where('periodo', $periodo)->where('producto_id',$producto->id)->sum('cant_ent');
            $salidas = Kardex::where('periodo', $periodo)->where('producto_id',$producto->id)->sum('cant_sal');
            $salant = Saldo::where('periodo',$perant)->where('producto_id',$producto)->first();
            if($salant) {
                $inicial = $salant->saldo;
            } else {
                $salant = Saldo::where('periodo','000000')->where('producto_id',$producto->id)->first();
                if ($salant) {
                    if ($salant->saldo == null) {
                        $inicial = 0;
                    } else {
                        $inicial = $salant->saldo;
                    }
                } else {
                    $inicial = 0.00;
                }
            }
            Saldo::insert([
                'periodo' => $periodo,
                'producto_id' => $producto->id,
                'inicial' => $inicial,
                'entradas' => $entradas,
                'salidas' => $salidas,
                'saldo' => $inicial + $entradas - $salidas,
                'precio' => $producto->precompra
                ]);
        }
        //---------------------------------------------------------------------------------
        $sede = Sede::findOrFail(session('sede'));
        $sede->update([
            'periodo' => pSiguiente($periodo)
        ]);
        session(['periodo' => $sede->periodo]);
        return redirect('/admin')->with('message', 'Periodo cerrado')->with('typealert', 'success');
    }
}

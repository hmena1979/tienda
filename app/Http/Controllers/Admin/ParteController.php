<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\Parte;
use App\Models\Lote;
use App\Models\Materiaprima;
use App\Models\Contrata;
use App\Models\Detenvasado;
use App\Models\Detingcamara;
use App\Models\Detparte;
use App\Models\Detrventa;
use App\Models\Dettrazabilidad;
use App\Models\Residuo;

class ParteController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
		$this->middleware('can:admin.partes.index')->only('index');
		$this->middleware('can:admin.partes.create')->only('create','store');
		$this->middleware('can:admin.partes.edit')->only('edit','update');
    }

    public function index($periodo = '000000')
    {
        if($periodo == '000000'){
            $periodo = session('periodo');
        }
        $partes = Parte::where('empresa_id', session('empresa'))
            ->where('periodo', $periodo)
            ->get();
        return view('admin.partes.index',compact('partes','periodo'));
    }

    public function change(Request $request)
    {
        $periodo = $request->input('mes').$request->input('año');
        $partes = Parte::where('empresa_id', session('empresa'))
            ->where('periodo', $periodo)
            ->get();
        return view('admin.partes.index',compact('partes','periodo'));
    }

    public function create()
    {
        $lotes = Lote::where('empresa_id',session('empresa'))->OrderBy('lote','desc')->take(20)->pluck('lote','lote');
        $contratas = Contrata::where('empresa_id',session('empresa'))->where('activo',1)->OrderBy('nombre')->pluck('nombre','id');
        return view('admin.partes.create', compact('lotes','contratas'));
    }

    public function store(Request $request)
    {
        $rules = [
            'lote' => 'required',
            'recepcion' => 'required',
            'congelacion' => 'required',
            'empaque' => 'required',
            'vencimiento' => 'required',
            'contrata_id' => 'required',
            'hombres' => 'required',
            'mujeres' => 'required',
            'trazabilidad' => ['required',
                function($attribute, $value, $fail) {
                    $contador = Parte::where('trazabilidad',$value)
                        ->where('empresa_id',session('empresa'))
                        ->count();
                    if ($contador > 0) {
                        $fail(__('Ya se encuentra registrado'));
                    }
                }],
        ];
        $messages = [
            'lote.required' => 'Seleccione Lote',
            'recepcion.required' => 'Ingrese fecha de recepción',
            'congelacion.required' => 'Ingrese fecha de congelación',
            'empaque.required' => 'Ingrese fecha de empaque',
            'vencimiento.required' => 'Ingrese fecha de vencimiento',
            'contrata_id.required' => 'Ingrese Mano de Obra',
            'hombres.required' => 'Ingrese cantidad de Hombres que participaron en el Proceso',
            'mujeres.required' => 'Ingrese cantidad de Mujeres que participaron en el Proceso',
    		'trazabilidad.required' => 'Ingrese Código de Trazabilidad.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            $parte = Parte::create($request->all());
            return redirect()->route('admin.partes.edit',$parte)->with('store', 'Registro agregado');
        }
    }

    public function show(Parte $parte)
    {
        //
    }

    public function edit(Parte $parte)
    {
        $lotes = Lote::where('empresa_id',session('empresa'))->OrderBy('lote','desc')->take(20)->pluck('lote','lote');
        $contratas = Contrata::where('empresa_id',session('empresa'))->where('activo',1)->OrderBy('nombre')->pluck('nombre','id');
        return view('admin.partes.edit', compact('parte','lotes','contratas'));
    }

    public function update(Request $request, Parte $parte)
    {
        $rules = [
            'lote' => 'required',
            'recepcion' => 'required',
            'congelacion' => 'required',
            'empaque' => 'required',
            'vencimiento' => 'required',
            'contrata_id' => 'required',
            'hombres' => 'required',
            'mujeres' => 'required',
            'trazabilidad' => ['required',
                Rule::unique('partes')->where(function ($query) use ($parte) {
                    return $query->where('id','<>',$parte->id)
                        ->whereNull('deleted_at')
                        ->where('empresa_id',session('empresa'));
                }),
            ],
        ];

        $messages = [
            'lote.required' => 'Seleccione Lote',
            'recepcion.required' => 'Ingrese fecha de recepción',
            'congelacion.required' => 'Ingrese fecha de congelación',
            'empaque.required' => 'Ingrese fecha de empaque',
            'vencimiento.required' => 'Ingrese fecha de vencimiento',
            'contrata_id.required' => 'Ingrese Mano de Obra',
            'hombres.required' => 'Ingrese cantidad de Hombres que participaron en el Proceso',
            'mujeres.required' => 'Ingrese cantidad de Mujeres que participaron en el Proceso',
    		'trazabilidad.required' => 'Ingrese Código de Trazabilidad.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            $parte->update($request->all());
            return redirect()->route('admin.partes.index')->with('update', 'Registro Actualizado');
        }
    }

    public function destroy(Parte $parte)
    {
        // if (Detenvasado::where('envasado_id',$envasado->id)->count() > 0) {
        //     return back()->with('message', 'Se ha producido un error, Ya contiene detalles')->with('typealert', 'danger');
        // }
        $parte->delete();
        return redirect()->route('admin.partes.index')->with('destroy', 'Registro Eliminado');
    }

    public function tablaitem(Request $request, Parte $parte)
    {
        if ($request->ajax()) {
            return view('admin.partes.detalle',compact('parte'));
        }
    }

    public function tablaitemcamara(Request $request, Parte $parte)
    {
        if ($request->ajax()) {
            return view('admin.partes.detallecamara',compact('parte'));
        }
    }

    public function tablaitemconsumo(Request $request, Parte $parte)
    {
        if ($request->ajax()) {
            return view('admin.partes.detalleconsumo',compact('parte'));
        }
    }

    public function generar(Parte $parte)
    {
        $parte->detpartes()->delete();
        $parte->detpartecamaras()->delete();
        // $materiaPrima = Materiaprima::where('lote',$parte->lote)->sum('pplanta');
        $materiaPrima = Materiaprima::selectRaw('sum(pplanta) as peso, sum(pplanta*precio) as total')
            ->where('lote',$parte->lote)
            ->first();
        // $residuo = Residuo::where('lote',$parte->lote)->sum('peso');
        $residuo = Residuo::selectRaw('sum(peso) as peso, sum(total) as total')
            ->where('lote',$parte->lote)
            ->first();

        //Planillas de Envasado
        $detalles = Detenvasado::whereRelation('envasado',['lote' => $parte->lote, 'estado' => 2])
            ->groupBy('dettrazabilidad_id')
            ->selectRaw('dettrazabilidad_id,sum(total) as total')
            ->get();
        foreach ($detalles as $det) {
            $detTrazabilidad = Dettrazabilidad::findOrFail($det->dettrazabilidad_id);
            $sobrePeso = round($det->total * ($detTrazabilidad->sobrepeso / 100),2);
            if ($detTrazabilidad->envase == 1) {
                $sacos = intval($det->total / $detTrazabilidad->peso);
                if (($det->total / $detTrazabilidad->peso) - $sacos > 0) {
                    $blocks = 1;
                } else {
                    $blocks = 0;
                }
            } else {
                $sacos = 0;
                $blocks = intval($det->total / $detTrazabilidad->peso);
            }
            $parcial = round(($det->total / $materiaPrima->peso)*100,2);
            $costo = round($det->total * $detTrazabilidad->precio ,2);            
            $parte->detpartes()->create([
                'trazabilidad_id' => $detTrazabilidad->trazabilidad_id,
                'dettrazabilidad_id' => $det->dettrazabilidad_id,
                'sobrepeso' => $sobrePeso,
                'sacos' => $sacos,
                'blocks' => $blocks,
                'parcial' => $parcial,
                'total' => $det->total,
                'costo' => $costo,
            ]);
        }
        
        // Guías de Ingreso a Camaras
        $detalles = Detingcamara::whereRelation('ingcamara',['lote' => $parte->lote, 'estado' => 2])
            ->groupBy('dettrazabilidad_id')
            ->selectRaw('dettrazabilidad_id,sum(total) as total')
            ->get();
        foreach ($detalles as $det) {
            $detTrazabilidad = Dettrazabilidad::findOrFail($det->dettrazabilidad_id);
            $sobrePeso = round($det->total * ($detTrazabilidad->sobrepeso / 100),2);
            if ($detTrazabilidad->envase == 1) {
                $sacos = intval($det->total / $detTrazabilidad->peso);
                if (($det->total / $detTrazabilidad->peso) - $sacos > 0) {
                    $blocks = 1;
                } else {
                    $blocks = 0;
                }
            } else {
                $sacos = 0;
                $blocks = intval($det->total / $detTrazabilidad->peso);
            }
            $parcial = round(($det->total / $materiaPrima->peso)*100,2);
            $costo = round($det->total * $detTrazabilidad->precio ,2);            
            $parte->detpartecamaras()->create([
                'trazabilidad_id' => $detTrazabilidad->trazabilidad_id,
                'dettrazabilidad_id' => $det->dettrazabilidad_id,
                'sobrepeso' => $sobrePeso,
                'sacos' => $sacos,
                'blocks' => $blocks,
                'parcial' => $parcial,
                'total' => $det->total,
                'costo' => $costo,
            ]);            
        }
        //Consumos de Almacen
        $consumos = Detrventa::whereRelation('rventa',['lote' => $parte->lote])
            ->groupBy('producto_id')
            ->selectRaw('
                producto_id,
                sum(cantidad) as solicitado,
                sum(devolucion) as devuelto,
                sum(cantidad-devolucion) as entregado,
                sum((cantidad-devolucion)*preprom) total
                ')
            ->get();
        // return $consumos;
        foreach ($consumos as $det) {
            $parte->detparteproductos()->create([
                'producto_id' => $det->producto_id,
                'solicitado' => $det->solicitado,
                'devuelto' => $det->devuelto,
                'entregado' => $det->entregado,
                'precio' => round($det->total / $det->entregado,2),
                'total' => $det->total,
            ]);    
        }
        $costoProductos = $consumos->sum('total');
        //Actualiza Parte
        $totales = Detparte::where('parte_id',$parte->id)
            ->groupBy('parte_id')
            ->selectRaw('parte_id,
                sum(sobrepeso) as sobrepeso,
                sum(sacos) as sacos,
                sum(blocks) as blocks,
                sum(total) as envasado,
                sum(parcial) as parcial,
                sum(costo) as manoobra
            ')->first();
        // return $totales;
        $merma = $materiaPrima->peso - ($totales->envasado + $totales->sobrepeso);
        $parte->update([
            'materiaprima' => $materiaPrima->peso,
            'costomateriaprima' => $materiaPrima->total,
            'envasado' => $totales->envasado,
            'sacos' => $totales->sacos,
            'blocks' => $totales->blocks,
            'sobrepeso' => $totales->sobrepeso,
            'residuos' => $residuo->peso,
            'costoresiduos' => $residuo->total,
            'manoobra' => $totales->manoobra,
            'costoproductos' => $costoProductos,
            'merma' => $merma,
        ]);
        return redirect()->route('admin.partes.edit',$parte)->with('update', 'Parte de Producción Generado');
    }
}

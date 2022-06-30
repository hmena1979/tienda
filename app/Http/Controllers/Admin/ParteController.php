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
use App\Models\Detpartecamara;
use App\Models\Detrventa;
use App\Models\Dettrazabilidad;
use App\Models\Envasado;
use App\Models\Ingcamara;
use App\Models\Residuo;
use App\Models\Rventa;

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
        $parte->detparteproductos()->delete();
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
        // $observaciones = Detingcamara::whereRelation('ingcamara',['lote' => $parte->lote, 'estado' => 2])
        //     ->groupBy('dettrazabilidad_id')
        //     ->groupBy('observaciones')
        //     ->whereNotNull('observaciones')
        //     ->selectRaw('dettrazabilidad_id,observaciones')
        //     ->get();
        // return $observaciones;
        $detalles = Detingcamara::whereRelation('ingcamara',['lote' => $parte->lote, 'estado' => 2])
            ->groupBy('dettrazabilidad_id')
            ->selectRaw('dettrazabilidad_id,sum(total) as total')
            ->get();
        foreach ($detalles as $det) {
            $observaciones = Detingcamara::whereRelation('ingcamara',['lote' => $parte->lote, 'estado' => 2])
                ->where('dettrazabilidad_id',$det->dettrazabilidad_id)
                ->whereNotNull('observaciones')
                ->select('observaciones')
                ->get();
            $observacion = '';
            foreach($observaciones as $obs) {
                $observacion .=  $obs->observaciones. ' ';
            }
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
                'observaciones' => $observacion,
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
        $totalesCamara = Detpartecamara::where('parte_id',$parte->id)
            ->groupBy('parte_id')
            ->selectRaw('parte_id,
                sum(costo) as manoobra
            ')->first();
        if ($totalesCamara) {
            $manoobra = $totalesCamara->manoobra;
        } else {
            $manoobra = 0;
        }
        // return $totales;
        $merma = $materiaPrima->peso - ($totales->envasado + $totales->sobrepeso + $parte->descarte + $residuo->peso);
        
        //Guía de Envasado
        $guiaEnvasado = '';
        $guias = Envasado::where('empresa_id', session('empresa'))
            ->where('tipo',1)
            ->where('lote', $parte->lote)
            ->select('numero')
            ->orderBy('numero')
            ->get();
        $ini = 1;
        $coma = '';
        foreach ($guias as $det) {
            $guiaEnvasado .= $coma.'N°' . str_pad($det->numero, 6, '0', STR_PAD_LEFT) ;
            if ($ini == 1) {
                $ini = 2;
                $coma = ', ';
            }
        }
        $guiaEnvasado .= '.';

        //Guía de Envasado Crudo
        $guiaEnvasadoCrudo = '';
        $guias = Envasado::where('empresa_id', session('empresa'))
            ->where('tipo',2)
            ->where('lote', $parte->lote)
            ->select('numero')
            ->orderBy('numero')
            ->get();
        $ini = 1;
        $coma = '';
        foreach ($guias as $det) {
            $guiaEnvasadoCrudo .= $coma.'N°' . str_pad($det->numero, 6, '0', STR_PAD_LEFT);
            if ($ini == 1) {
                $ini = 2;
                $coma = ', ';
            }
        }
        $guiaEnvasadoCrudo .= '.';

        //Guía de Ingreso a Cámaras
        $guiaIngCamara = '';
        $guias = Ingcamara::where('empresa_id', session('empresa'))
            ->where('lote', $parte->lote)
            ->select('numero')
            ->orderBy('numero')
            ->get();
        $ini = 1;
        $coma = '';
        foreach ($guias as $det) {
            $guiaIngCamara .= $coma.'N°' . str_pad($det->numero, 6, '0', STR_PAD_LEFT);
            if ($ini == 1) {
                $ini = 2;
                $coma = ', ';
            }
        }
        $guiaIngCamara .= '.';

        //Guía de Consumos
        $guiaAlmacen = '';
        $guias = Rventa::where('empresa_id', session('empresa'))
            ->where('lote', $parte->lote)
            ->where('tipo',2)
            ->select('serie','numero')
            ->orderBy('numero')
            ->get();
        $ini = 1;
        $coma = '';
        foreach ($guias as $det) {
            $guiaAlmacen .= $coma.'N°' . $det->serie.'-'.$det->numero;
            if ($ini == 1) {
                $ini = 2;
                $coma = ', ';
            }
        }
        $guiaAlmacen .= '.';

        //Guía de Residuos
        $guiaResiduo = '';
        $guias = Residuo::where('empresa_id', session('empresa'))
            ->where('lote', $parte->lote)
            ->select('guiahl')
            ->orderBy('guiahl')
            ->get();
        $ini = 1;
        $coma = '';
        foreach ($guias as $det) {
            $guiaResiduo .= $coma.'N°' . $det->guiahl;
        }
        $guiaResiduo .= '.';
        

        $parte->update([
            'materiaprima' => $materiaPrima->peso,
            'costomateriaprima' => $materiaPrima->total,
            'envasado' => $totales->envasado,
            'sacos' => $totales->sacos,
            'blocks' => $totales->blocks,
            'sobrepeso' => $totales->sobrepeso,
            'residuos' => $residuo->peso,
            'costoresiduos' => $residuo->total,
            'manoobra' => round($manoobra * BusTc($parte->empaque),2),//Round($totalesCamara->manoobra * BusTc($parte->empaque),2),
            'costoproductos' => $costoProductos,
            'merma' => $merma,
            'guias_envasado' => $guiaEnvasado,
            'guias_envasado_crudo' => $guiaEnvasadoCrudo,
            'guias_camara' => $guiaIngCamara,
            'guias_almacen' => $guiaAlmacen,
            'guias_residuos' => $guiaResiduo,
        ]);
        return redirect()->route('admin.partes.edit',$parte)->with('update', 'Parte de Producción Generado');
    }
}

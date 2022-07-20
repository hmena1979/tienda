<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Departamento;
use App\Models\Dettrazabilidad;
use App\Models\Provincia;
use App\Models\Trazabilidad;
use App\Models\Ubigeo;

class BusquedaController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
    }

    public function departamento(Request $request)
    {
        if($request->ajax()){
            $term = trim($request->q);
            if (empty($term)) {
                return response()->json([]);
            }
            $departamento = Departamento::select('codigo','nombre')
                ->where('nombre','like','%'.$term.'%')
                ->get();

            $respuesta = array();
            foreach($departamento as $dep){
                $respuesta[] = [
                    'id' => $dep->codigo,
                    'text' => $dep->nombre,
                ];            
            }
            return $respuesta;
        }
    }

    public function provincia(Request $request, $departamento)
    {
        if($request->ajax()){
            $provincia = Provincia::select('codigo','nombre')
                ->where('departamento',$departamento)
                ->get();
            return response()->json($provincia);
        }
    }

    public function ubigeo(Request $request, $provincia)
    {
        if($request->ajax()){
            $ubigeo = Ubigeo::select('codigo','nombre')
                ->where('provincia',$provincia)
                ->get();
            return response()->json($ubigeo);
        }
    }
    
    public function trazabilidad(Request $request, $pproceso)
    {
        if($request->ajax()){
            $trazabilidad = Trazabilidad::select('id','nombre')
                ->where('pproceso_id',$pproceso)
                ->get();
            return response()->json($trazabilidad);
        }
    }
    
    public function dettrazabilidad(Request $request, $trazabilidad)
    {
        if($request->ajax()){
            $detalle = Dettrazabilidad::where('trazabilidad_id',$trazabilidad)->get();
            // return $detalle[0]->codigo;
            return response()->json($detalle);
        }
    }
}

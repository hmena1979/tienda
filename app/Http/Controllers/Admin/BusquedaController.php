<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Departamento;
use App\Models\Provincia;
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
}

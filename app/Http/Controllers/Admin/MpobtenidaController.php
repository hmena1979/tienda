<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Despiece;
use App\Models\Mpobtenida;
use App\Models\Producto;
use Illuminate\Http\Request;

class MpobtenidaController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
		$this->middleware('can:admin.mpobtenidas.index')->only('index');
		$this->middleware('can:admin.mpobtenidas.create')->only('aedet');
		$this->middleware('can:admin.mpobtenidas.edit')->only('mpobtenida');
		$this->middleware('can:admin.mpobtenidas.destroy')->only('destroyitem');
		// $this->middleware('can:admin.categorias.permission')->only('editpermission','updatepermission');
		// $this->middleware('can:admin.categorias.password')->only('editpassword','updatepassword');
    }

    public function index()
    {
        $productos = Producto::where('grupo',3)
            ->where('empresa_id',session('empresa'))
            ->orderBy('nombre')
            ->pluck('nombre','id');
        $piezas = Despiece::where('empresa_id',session('empresa'))
            ->orderBy('nombre')
            ->pluck('nombre','id');
        return view('admin.mpobtenidas.index',compact('productos','piezas'));
    }

    public function aedet (Request $request, $envio) {
        if ($request->ajax()) {
            $det = json_decode($envio);
            if ($det->tipo == 1) {
                $conteo = Mpobtenida::where('producto_id',$det->producto_id)
                    ->where('despiece_id',$det->despiece_id)
                    ->count();
                if ($conteo) {
                    return 2;
                }
                Mpobtenida::create([
                    'producto_id' => $det->producto_id,
                    'despiece_id' => $det->despiece_id,
                    'porcentaje' => $det->porcentaje,
                ]);
            } else {
                $mpobtenida = Mpobtenida::findOrFail($det->id);
                $conteo = Mpobtenida::where('producto_id',$det->producto_id)
                    ->where('despiece_id',$det->despiece_id)
                    ->where('id','<>',$det->id)
                    ->count();
                if ($conteo > 0) {
                    return 2;
                }
                $mpobtenida->update([
                    'despiece_id' => $det->despiece_id,
                    'porcentaje' => $det->porcentaje,
                ]);
            }
            return 1;
        }
    }

    public function mpobtenida(Request $request, Mpobtenida $mpobtenida)
    {
        if ($request->ajax()) {
            return response()->json($mpobtenida);
        }
    }

    // public function listdetalle(Request $request, $producto)
    // {
    //     if($request->ajax()){
    //         $mpobtenida = Mpobtenida::where('producto_id',$producto)->get();
    //         return response()->json($mpobtenida);
    //     }
    // }

    public function tablaitem(Request $request, Producto $producto)
    {
        if ($request->ajax()) {
            return view('admin.mpobtenidas.detalle',compact('producto'));
        }
    }

    public function destroyitem (Request $request, Mpobtenida $mpobtenida)
    {
        if ($request->ajax()) {
            $mpobtenida->delete();
        }
    }

}

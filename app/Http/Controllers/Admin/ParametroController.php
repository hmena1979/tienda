<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Param;
use App\Models\Empresa;
use App\Models\Sede;

class ParametroController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
		$this->middleware('can:admin.parametros.index')->only('index');
		// $this->middleware('can:admin.parametros.empresaCreate')->only('empresaCreate','empresaStore');
		// $this->middleware('can:admin.parametros.empresaEdit')->only('empresaEdit','empresaUpdate');
		// $this->middleware('can:admin.parametros.empresaDestroy')->only('empresaDestroy');
		// $this->middleware('can:admin.parametros.sedeCreate')->only('sedeCreate','sedeStore');
		// $this->middleware('can:admin.parametros.sedeEdit')->only('sedeEdit','sedeUpdate');
        // $this->middleware('can:admin.parametros.sedeDestroy')->only('sedeDestroy');
    }

    public function index($empresa = 0)
    {
        $param = Param::find(1);
        if ($empresa == 0) {
            $empresas = Empresa::get();
            $empresa = $empresas[0]->id;
            $tit = Empresa::find($empresa);
            $sedes = Sede::where('empresa_id', $empresa)->get();
        } else {
            $empresas = Empresa::get();
            $tit = Empresa::find($empresa);
            $sedes = Sede::where('empresa_id', $empresa)->get();
        }
        
        return view('admin.parametros.index', compact('param','empresa','empresas','sedes','tit'));
    }

    public function empresaCreate()
    {
        return view('admin.parametros.empresacreate');
    }

    public function empresaStore(Request $request)
    {
        $rules = [
            'ruc' => 'required|unique:empresas',
            'razsoc' => 'required',
            'nomcomercial' => 'required',
            'usuario' => 'required',
            'clave' => 'required',
            'apitoken' => 'required',
            'servidor' => 'required',
            'cuenta' => 'required',
            'dominio' => 'required',
            'por_igv' => 'required',
            'por_renta' => 'required',
            'monto_renta' => 'required',
            'maximoboleta' => 'required',
            'icbper' => 'required',
        ];
        $messages = [
    		'ruc.required' => 'Ingrese RUC.',
            'ruc.unique' => 'RUC ya se encuentra registrado.',
    		'razsoc.required' => 'Ingrese Razsón Social.',
    		'nomcomercial.required' => 'Ingrese Nombre Comercial.',
    		'usuario.required' => 'Ingrese Usuario.',
    		'clave.required' => 'Ingrese Clave.',
    		'apitoken.required' => 'Ingrese Api Token para busqueda de DNI|RUC.',
    		'servidor.required' => 'Ingrese Servidor de envío de Comprobantes de Pago.',
    		'cuenta.required' => 'Ingrese Cuenta de Detracción.',
    		'dominio.required' => 'Ingrese Dominio',
    		'por_igv.required' => 'Ingrese Porcentaje de IGV.',
    		'por_renta.required' => 'Ingrese Porcentaje de Renta de 4ta Categoría.',
    		'monto_renta.required' => 'Ingrese monto a partir se cobrará rentas de 4ta Categoría.',
    		'maximoboleta.required' => 'Ingrese Monto Máximo para Boletas sin identificar Cliente.',
    		'icbper.required' => 'Ingrese Monto de Impuesto a Bolsas Plásticas.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            Empresa::create($request->all());
            return redirect()->route('admin.parametros.index')->with('store', 'Empresa Agregada');
        }

    }

    public function empresaEdit(Empresa $empresa)
    {

    }

    public function empresaUpdate(Request $request, Empresa $empresa)
    {

    }

    public function sedeCreate(Empresa $empresa)
    {
        
    }

    public function sedeStore(Request $request)
    {

    }

    public function sedeEdit(Sede $sede)
    {

    }

    public function sedeUpdate(Request $request, Sede $sede)
    {

    }

}

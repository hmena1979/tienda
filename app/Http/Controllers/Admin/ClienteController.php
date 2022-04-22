<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreClienteRequest;
use Illuminate\Support\Facades\Validator;

use App\Models\Cliente;
use App\Models\Categoria;
use Illuminate\Support\Facades\Auth;
use App\Models\Empresa;

class ClienteController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
		$this->middleware('can:admin.clientes.index')->only('index');
		$this->middleware('can:admin.clientes.create')->only('create','store');
		$this->middleware('can:admin.clientes.edit')->only('edit','update');
		// $this->middleware('can:admin.categorias.permission')->only('editpermission','updatepermission');
		// $this->middleware('can:admin.categorias.password')->only('editpassword','updatepassword');
    }

    public function index()
    {
        if(Cliente::count() == 0){
            Cliente::create([
                'empresa_id'=>1,
                'tipdoc_id'=>'0',
                'numdoc' => '00000000',
                'razsoc' => 'VARIOS'
            ]);
            Cliente::create([
                'empresa_id'=>1,
                'tipdoc_id'=>'0',
                'numdoc' => '99999999',
                'razsoc' => 'EMPRESA'
            ]);

        }
        return view('admin.clientes.index');
    }

    public function create()
    {
        $tipdoc = Categoria::where('modulo', 1)->orderBy('codigo')->pluck('nombre','codigo');
        $sexo = Categoria::where('modulo', 2)->pluck('nombre','codigo');
        $estciv = Categoria::where('modulo', 3)->pluck('nombre','codigo');

        return view('admin.clientes.create', compact('tipdoc','sexo','estciv'));
    }

    public function store(Request $request)
    {
        if($request->input('tipdoc_id') == '6' || $request->input('tipdoc_id') == '0'){
            $rules = [
                'numdoc' => 'required|unique:clientes',
                'razsoc' => 'required',
                'nomcomercial' => 'required'
            ];
        }else{
            $rules = [
                'numdoc' => 'required|unique:clientes',
                'ape_pat' => 'required',
                'nombres' => 'required',
                'razsoc' => 'required',
                'nomcomercial' => 'required'
            ];
        }
        
        $messages = [
    		'numdoc.required' => 'Ingrese Número de documento.',
    		'numdoc.unique' => 'Número de documento ya fue Ingresado.',
    		'ape_pat.required' => 'Ingrese Apellido Paterno.',
    		'nombres.required' => 'Ingrese Nombres.',
    		'razsoc.required' => 'Ingrese Razón Social.',
    		'nomcomercial.required' => 'Ingrese Nombre Comercial.'
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            Cliente::create($request->all());
            return redirect()->route('admin.clientes.index')->with('store', 'Proveedor | Cliente Agregado');
        }
    }

    public function storeAjax(StoreClienteRequest $request)
    {
        if ($request->ajax()) {
            $data = $request->except('dircliente');
            $data = array_merge($data,[
                'direccion' => $request->input('dircliente'),
            ]);
            $cliente = Cliente::create($data);
            return response()->json($cliente);
        }
    }

    public function show($id)
    {
        //
    }

    public function edit(Cliente $cliente)
    {
        $tipdoc = Categoria::where('modulo', 1)->orderBy('codigo')->pluck('nombre','codigo');
        $sexo = Categoria::where('modulo', 2)->pluck('nombre','codigo');
        $estciv = Categoria::where('modulo', 3)->pluck('nombre','codigo');

        return view('admin.clientes.edit', compact('cliente','tipdoc','sexo','estciv'));
    }
    
    public function update(Request $request, Cliente $cliente)
    {
        if($request->input('tipdoc_id') == '6' || $request->input('tipdoc_id') == '0'){
            $rules = [
                'numdoc' => "required|unique:clientes,numdoc,$cliente->id",
                'razsoc' => 'required',
                'nomcomercial' => 'required'
            ];
        }else{
            $rules = [
                'numdoc' => "required|unique:clientes,numdoc,$cliente->id",
                'ape_pat' => 'required',
                'nombres' => 'required',
                'razsoc' => 'required',
                'nomcomercial' => 'required'
            ];
        }
        
        $messages = [
    		'numdoc.required' => 'Ingrese Número de documento.',
    		'numdoc.unique' => 'Número de documento ya fue Ingresado.',
    		'ape_pat.required' => 'Ingrese Apellido Paterno.',
    		'nombres.required' => 'Ingrese Nombres.',
    		'razsoc.required' => 'Ingrese Razón Social.',
    		'nomcomercial.required' => 'Ingrese Nombre Comercial.'
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            $cliente->update($request->all());
            return redirect()->route('admin.clientes.index')->with('update', 'Proveedor | Cliente Actualizado');
        }
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return redirect()->route('admin.clientes.index')->with('destroy', 'Cliente Eliminado');
    }

    public function ClienteRegistro(Request $request)
    {
        //$prov = Paciente::select('id','numdoc','razsoc','telefono','email','tipo')->get();
        if($request->ajax()){
            return datatables()
                // ->of(Cliente::select('id','numdoc','razsoc','celular','email'))
                ->of(Cliente::where('numdoc','!=','00000000')
                ->where('numdoc','!=','99999999')
                ->where('numdoc','!=','11111111')
                ->select('id','numdoc','razsoc','celular','email'))
                ->addColumn('btn','admin.clientes.action')
                ->rawColumns(['btn'])
                ->toJson();
        }
    }

    public function BusApi(Request $request, $tipo, $numero, $id = 0)
    {
        if($request->ajax()){
            $parametro = Empresa::findOrFail(Auth::user()->empresa);
            $token = $parametro->apitoken;
            $context = stream_context_create(array(
                'http' => array('ignore_errors' => true),
            ));
            if($id == 0){
                if(Cliente::where('numdoc', $numero)->count() > 0){
                    return 'REPETIDO';
                }
            }
            else{
                if(Cliente::where('id','<>',$id)->where('numdoc', $numero)->count() > 0){
                    return 'REPETIDO';
                }
            }
            if($tipo=='1'){
                $api = file_get_contents('https://dniruc.apisperu.com/api/v1/dni/'.$numero.'?token='.$token,false,$context);
    
            }else{
                $api = file_get_contents('https://dniruc.apisperu.com/api/v1/ruc/'.$numero.'?token='.$token,false,$context);
            }
            if($api == false){
                return 0;
            }else{
                $api = str_replace('&Ntilde;','Ñ',$api);
                $api = json_decode($api);
                return response()->json($api);
                //return $api;
            }
        }
    }

    public function repetido($numdoc)
    {
        if(Cliente::where('numdoc', $numdoc)->count() > 0){
            return 'SI';
        }else{
            return 'NO';
        }
    }

    public function seleccionado(Request $request, $tipo = 1)
    {
        if($request->ajax()){
            $term = trim($request->q);
            if (empty($term)) {
                return response()->json([]);
            }
            switch ($tipo) {
                case 1:
                    $clientes = Cliente::select('id','razsoc','numdoc')
                    ->where('numdoc','<>','00000000')
                    ->where('numdoc','<>','99999999')
                    ->where('numdoc','<>','11111111')
                    ->where('empresa_id',session('empresa'))
                    ->where('numdoc','like','%'.$term.'%')
                    ->orWhere('razsoc','like','%'.$term.'%')
                    ->limit(5)
                    ->get();
                    break;
                case 2:
                    $clientes = Cliente::select('id','razsoc','numdoc')
                    ->where('numdoc','<>','99999999')
                    ->where('numdoc','<>','11111111')
                    ->where('numdoc','like','%'.$term.'%')
                    ->where('empresa_id',session('empresa'))
                    ->orWhere('razsoc','like','%'.$term.'%')
                    ->limit(5)
                    ->get();
                    break;
                case 3:
                    $clientes = Cliente::select('id','razsoc','numdoc')
                    ->where('numdoc','99999999')
                    ->where('empresa_id',session('empresa'))
                    ->limit(5)
                    ->get();
                    break;
            }

            $respuesta = array();
            foreach($clientes as $cliente){
                $respuesta[] = [
                    'id' => $cliente->id,
                    'text' => $cliente->numdoc.'-'.$cliente->razsoc,
                ];            
            }
            return $respuesta;
        }
    }

    public function valores(Request $request, Cliente $cliente)
    {
        if ($request->ajax()) {
            return response()->json($cliente);
        }
    }
}

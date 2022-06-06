<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\TesoreriaMailable;
use App\Mail\PedidoMailable;

use App\Models\Mensajeria;
use App\Models\Masivo;
use App\Models\Pedido;

class MensajeriaController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
		$this->middleware('can:admin.mensajerias.index')->only('index');
		$this->middleware('can:admin.mensajerias.create')->only('create','store');
		$this->middleware('can:admin.mensajerias.edit')->only('edit','update');
    }

    public function index($modulo = 1)
    {
        $mensajerias = Mensajeria::where('modulo', $modulo)
            ->where('empresa_id',session('empresa'))
            ->where('sede_id',session('sede'))
            ->orderBy('nombre','Asc')
            ->get();
    	return view('admin.mensajerias.index', compact('mensajerias','modulo'));
    }

    public function create($modulo)
    {
        return view('admin.mensajerias.create', compact('modulo'));
    }

    public function store(Request $request)
    {
        $rules = [
            'nombre' => 'required',
            'email' => 'required|email',
        ];
        $messages = [
    		'nombre.required' => 'Ingrese Nombre.',
    		'email.required' => 'Ingrese Correo Electrónico.',
    		'email.email' => 'Formato Incorrecto de Correo Electrónico.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            Mensajeria::create($request->all());
            return redirect()->route('admin.mensajerias.index',$request->input('modulo'))->with('store', 'e-mail Agregado');
        }
    }

    public function show($id)
    {
        //
    }

    public function edit(Mensajeria $mensajeria)
    {
        return view('admin.mensajerias.edit', compact('mensajeria'));
    }

    public function update(Request $request, Mensajeria $mensajeria)
    {
        $rules = [
            'nombre' => 'required',
            'email' => 'required',
        ];
        $messages = [
    		'nombre.required' => 'Ingrese Nombre.',
    		'email.required' => 'Ingrese e-mail.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            $mensajeria->update($request->all());
            return redirect()->route('admin.mensajerias.index',$request->input('modulo'))->with('update', 'e-mail Actualizado');
        }
    }

    public function destroy(Mensajeria $mensajeria)
    {
        $modulo = $mensajeria->modulo;
        $mensajeria->delete();
        return redirect()->route('admin.mensajerias.index',$modulo)->with('update', 'e-mail Eliminado');
    }

    public function tesoreria(Masivo $masivo)
    {
        $destinatarios = Mensajeria::where('modulo',1)->pluck('email');
        // Mail::to(['ventas@depiura.net','hmena1979@gmail.com'])->send($tesoreria);
        if ($destinatarios) {
            $tesoreria = new TesoreriaMailable($masivo);
            Mail::to($destinatarios)->send($tesoreria);
            return back()->with('message', 'e-mail enviado')->with('typealert', 'success');
        } else {
            return back()->with('message', 'Error: No tiene registrados destinatarios')->with('typealert', 'danger');
        }
    }

    public function pedido(Pedido $pedido)
    {
        $destinatarios = Mensajeria::where('modulo',2)->pluck('email');
        if ($destinatarios) {
            $pedidos = new PedidoMailable($pedido);
            Mail::to($destinatarios)->send($pedidos);
        }
        return true;
    }
}

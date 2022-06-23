<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Detenvasado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\Equipoenvasado;

class EquipoenvasadoController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
		$this->middleware('can:admin.equipoenvasados.index')->only('index');
		$this->middleware('can:admin.equipoenvasados.create')->only('create','store');
		$this->middleware('can:admin.equipoenvasados.edit')->only('edit','update');
    }

    public function index()
    {
        $equipoenvasados = Equipoenvasado::where('empresa_id',session('empresa'))->get();    
        return view('admin.equipoenvasados.index',compact('equipoenvasados'));
    }

    public function create()
    {
        return view('admin.equipoenvasados.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'nombre' => ['required',
                function($attribute, $value, $fail) {
                    $contador = Equipoenvasado::where('nombre',$value)
                        ->where('empresa_id',session('empresa'))
                        ->count();
                    if ($contador > 0) {
                        $fail(__('Ya se encuentra registrado'));
                    }
                }],             
        ];
        $messages = [
    		'nombre.required' => 'Ingrese Nombre.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            Equipoenvasado::create($request->all());
            return redirect()->route('admin.equipoenvasados.index')->with('store', 'Registro agregado');
        }
    }

    public function show(Equipoenvasado $equipoenvasado)
    {
        //
    }

    public function edit(Equipoenvasado $equipoenvasado)
    {
        return view('admin.equipoenvasados.edit', compact('equipoenvasado'));
    }

    public function update(Request $request, Equipoenvasado $equipoenvasado)
    {
        $rules = [
            'nombre' => [
                'required',
                Rule::unique('equipoenvasados')->where(function ($query) use ($equipoenvasado) {
                    return $query->where('id','<>',$equipoenvasado->id)
                        ->whereNull('deleted_at')
                        ->where('empresa_id',session('empresa'));
                }),
            ],
        ];

        $messages = [
    		'nombre.required' => 'Ingrese Nombre.',
    		'nombre.unique' => 'Ya fue registrado.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            $equipoenvasado->update($request->all());
            return redirect()->route('admin.equipoenvasados.index')->with('update', 'Registro Actualizado');
        }
    }

    public function destroy(Equipoenvasado $equipoenvasado)
    {
        if (Detenvasado::where('equipoenvasado_id',$equipoenvasado->id)->count() > 0) {
            return back()->with('message', 'Se ha producido un error, Equipo de Envasado ya esta contenido en una Planilla de Envasado')->with('typealert', 'danger');
        }
        $equipoenvasado->delete();
        return redirect()->route('admin.equipoenvasados.index')->with('destroy', 'Registro Eliminado');
    }
}

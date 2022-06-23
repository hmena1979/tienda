<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\Supervisor;
use App\Models\Envasado;

class SupervisorController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
		$this->middleware('can:admin.supervisors.index')->only('index');
		$this->middleware('can:admin.supervisors.create')->only('create','store');
		$this->middleware('can:admin.supervisors.edit')->only('edit','update');
    }

    public function index()
    {
        $supervisors = Supervisor::where('empresa_id',session('empresa'))->get();    
        return view('admin.supervisors.index',compact('supervisors'));
    }

    public function create()
    {
        return view('admin.supervisors.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'nombre' => ['required',
                function($attribute, $value, $fail) {
                    $contador = Supervisor::where('nombre',$value)
                        ->where('empresa_id',session('empresa'))
                        ->count();
                    if ($contador > 0) {
                        $fail(__('Ya se encuentra registrado'));
                    }
                }],
            'cargo' => 'required',                
        ];
        $messages = [
    		'nombre.required' => 'Ingrese Nombre.',
    		'cargo.required' => 'Ingrese cargo.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            Supervisor::create($request->all());
            return redirect()->route('admin.supervisors.index')->with('store', 'Registro agregado');
        }
    }

    public function show(Supervisor $supervisor)
    {
        //
    }

    public function edit(Supervisor $supervisor)
    {
        return view('admin.supervisors.edit', compact('supervisor'));
    }

    public function update(Request $request, Supervisor $supervisor)
    {
        $rules = [
            'nombre' => [
                'required',
                Rule::unique('supervisors')->where(function ($query) use ($supervisor) {
                    return $query->where('id','<>',$supervisor->id)
                        ->whereNull('deleted_at')
                        ->where('empresa_id',session('empresa'));
                }),
            ],
        ];

        $messages = [
    		'nombre.required' => 'Ingrese Nombre.',
    		'nombre.unique' => 'Ya fue registrado.',
    		'cargo.required' => 'Ingrese cargo.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            $supervisor->update($request->all());
            return redirect()->route('admin.supervisors.index')->with('update', 'Registro Actualizado');
        }
    }

    public function destroy(Supervisor $supervisor)
    {
        if (Envasado::where('supervisor_id',$supervisor->id)->count() > 0) {
            return back()->with('message', 'Se ha producido un error, Supervisor ya esta contenido en una Planilla de Envasado')->with('typealert', 'danger');
        }
        $supervisor->delete();
        return redirect()->route('admin.supervisors.index')->with('destroy', 'Registro Eliminado');
    }
}

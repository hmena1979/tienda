<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\Lote;
use App\Models\Materiaprima;

class LoteController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
		$this->middleware('can:admin.lotes.index')->only('index');
		$this->middleware('can:admin.lotes.create')->only('create','store');
		$this->middleware('can:admin.lotes.edit')->only('edit','update');
    }

    public function index()
    {
        if (Lote::count() == 0) {
            $materias = Materiaprima::select('lote','ingplanta')->groupBy(['lote','ingplanta'])->orderBy('lote')->get();
            foreach ($materias as $mat) {
                Lote::create([
                    'lote' => $mat->lote,
                    'finicial' => $mat->ingplanta,
                    'ffinal' => $mat->ingplanta,
                ]);
            }
        }
        $lotes = Lote::where('empresa_id',session('empresa'))->orderBy('lote', 'desc')->get();    
        return view('admin.lotes.index',compact('lotes'));
    }

    public function create()
    {
        return view('admin.lotes.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'lote' => ['required',
                function($attribute, $value, $fail) {
                    $contador = Lote::where('lote',$value)
                        ->where('empresa_id',session('empresa'))
                        ->count();
                    if ($contador > 0) {
                        $fail(__('Ya se encuentra registrado'));
                    }
                }],
            'finicial' => 'required',
            'ffinal' => 'required',
                
        ];
        $messages = [
    		'lote.required' => 'Ingrese Lote.',
    		'finicial.required' => 'Ingrese Fecha Inicial.',
    		'ffinal.required' => 'Ingrese Fecha Final.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            Lote::create($request->all());
            return redirect()->route('admin.lotes.index')->with('store', 'Registro agregado');
        }
    }

    public function show(Lote $lote)
    {
        //
    }

    public function edit(Lote $lote)
    {
        return view('admin.lotes.edit', compact('lote'));
    }

    public function update(Request $request, Lote $lote)
    {
        $rules = [
            'lote' => [
                'required',
                Rule::unique('lotes')->where(function ($query) use ($lote) {
                    return $query->where('id','<>',$lote->id)
                        ->whereNull('deleted_at')
                        ->where('empresa_id',session('empresa'));
                }),
            ],
        ];

        $messages = [
    		'lote.required' => 'Ingrese Lote.',
    		'lote.unique' => 'Ya fue registrado.',
            'finicial.required' => 'Ingrese Fecha Inicial.',
    		'ffinal.required' => 'Ingrese Fecha Final.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            $lote->update($request->all());
            return redirect()->route('admin.lotes.index')->with('update', 'Registro Actualizado');
        }
    }

    public function destroy(Lote $lote)
    {
        $lote->delete();
        return redirect()->route('admin.lotes.index')->with('destroy', 'Registro Eliminado');
    }
}

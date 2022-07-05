<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CountryController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
		$this->middleware('can:admin.countries.index')->only('index');
		$this->middleware('can:admin.countries.create')->only('create','store');
		$this->middleware('can:admin.countries.edit')->only('edit','update');
    }

    public function index()
    {
        if (Country::count() == 0) {
            Country::create([
                'codigo' => 'PE',
                'nombre' => 'PERU',
            ]);
            Country::create([
                'codigo' => 'ES',
                'nombre' => 'SPAIN',
            ]);
            Country::create([
                'codigo' => 'MX',
                'nombre' => 'MEXICO',
            ]);
            Country::create([
                'codigo' => 'KR',
                'nombre' => 'KOREA',
            ]);
            Country::create([
                'codigo' => 'TH',
                'nombre' => 'THAILAND',
            ]);
            Country::create([
                'codigo' => 'JP',
                'nombre' => 'JAPAN',
            ]);
            Country::create([
                'codigo' => 'PT',
                'nombre' => 'PORTUGAL',
            ]);
        }
        $countries = Country::orderBy('nombre')->get();
        return view('admin.countries.index',compact('countries'));
    }

    public function create()
    {
        return view('admin.countries.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'nombre' => ['required',
                function($attribute, $value, $fail) {
                    $contador = Country::where('nombre',$value)->count();
                    if ($contador > 0) {
                        $fail(__('Ya se encuentra registrado'));
                    }
                }],
            'codigo' => 'required',                
        ];
        $messages = [
    		'nombre.required' => 'Ingrese Nombre.',
    		'codigo.required' => 'Ingrese Código según estandar ISO 3166-2.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            Country::create($request->all());
            return redirect()->route('admin.countries.index')->with('store', 'Registro agregado');
        }
    }

    public function show(Country $country)
    {
        //
    }

    public function edit(Country $country)
    {
        return view('admin.countries.edit', compact('country'));
    }

    public function update(Request $request, Country $country)
    {
        $rules = [
            'nombre' => [
                'required',
                Rule::unique('countries')->where(function ($query) use ($country) {
                    return $query->where('id','<>',$country->id)
                        ->whereNull('deleted_at');
                }),
            ],
        ];

        $messages = [
    		'nombre.required' => 'Ingrese Nombre.',
    		'nombre.unique' => 'Ya fue registrado.',
    		'codigo.required' => 'Ingrese Código según estandar ISO 3166-2.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            $country->update($request->all());
            return redirect()->route('admin.countries.index')->with('update', 'Registro Actualizado');
        }
    }

    public function destroy(Country $country)
    {
        // if (Envasado::where('supervisor_id',$country->id)->count() > 0) {
        //     return back()->with('message', 'Se ha producido un error, Supervisor ya esta contenido en una Planilla de Envasado')->with('typealert', 'danger');
        // }
        $country->delete();
        return redirect()->route('admin.countries.index')->with('destroy', 'Registro Eliminado');
    }
}

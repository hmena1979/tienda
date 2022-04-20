<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
		$this->middleware('can:admin.roles.index')->only('index');
		$this->middleware('can:admin.roles.create')->only('create','store');
		$this->middleware('can:admin.roles.edit')->only('edit','update');
		// $this->middleware('can:admin.usuarios.permisos')->only('editpermission','updatepermission');
    }

    public function index()
    {
        $roles = Role::all();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::orderBy('module_id')->get();
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:roles'
        ];
        $messages = [
    		'name.required' => 'Ingrese Nombre.',
    		'name.unique' => 'Nombre ya existe en base de datos.'
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            $role = Role::create($request->all());
            $role->permissions()->sync($request->permissions);
            return redirect()->route('admin.roles.index')->with('store', 'Rol agregado');
        }
    }

    public function edit(Role $role)
    {
        $permissions = Permission::orderBy('module_id')->get();
        return view('admin.roles.edit', compact('role','permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $rules = [
            'name' => "required|unique:roles,name,$role->id"
        ];
        $messages = [
    		'name.required' => 'Ingrese Nombre.',
    		'name.unique' => 'Nombre ya existe en base de datos.'
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }else{
            $role->update($request->all());
            $role->permissions()->sync($request->permissions);
            return redirect()->route('admin.roles.index')->with('update', 'Rol actualizado');
        }
    }

    public function destroy(Role $role)
    {
        //
    }
}

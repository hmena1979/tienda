<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


use App\Models\User;
// use App\Http\Models\Doctor;

class UsuarioController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
		$this->middleware('can:admin.usuarios.index')->only('index');
		$this->middleware('can:admin.usuarios.create')->only('create','store');
		$this->middleware('can:admin.usuarios.edit')->only('edit','update');
		$this->middleware('can:admin.usuarios.permission')->only('editpermission','updatepermission');
		$this->middleware('can:admin.usuarios.password')->only('editpassword','updatepassword');
    }

    public function index($status = 1)
    {
		// if(isset($status)){
		// 	$status = 'all';
		// }
		// if(kvfj(Auth::user()->permissions,'usuario_permissions')):
			// if(can('admin.usuarios.permission'))
			$permiso = User::permission('admin.usuarios.permission')->where('id',Auth::user()->id)->count();
			if($permiso){
				switch ($status) {
					case '1':
						$users = User::where('activo',1)->get();
						break;
					case '2':
						$users = User::where('activo',2)->get();					
						break;
					case 'all':
						$users = User::get();
						break;
					}
			}else{
				$users = User::where('id',Auth::user()->id)->get();
			}
			
		// else:
		// 	$users = User::where('id',Auth::user()->id)->get();
		// endif;
        
        $data = [
            'users'=>$users
        ];
        return view('admin.usuarios.index', $data);
    }

    public function create()
    {
		// $doctores = Doctor::where('activo', 1)->pluck('nombre','id');
		$data = [
            'doctores'=>''
        ];
        return view('admin.usuarios.create');
    }

    public function store(Request $request)
    {
    	$rules = [
    		'name' => 'required',
    		'email' => 'required|email|unique:users,email',
    		'password' => 'required|min:8',
    		'cpassword' => 'required|same:password'
    	];
    	$messages = [
    		'name.required' => 'Ingrese Nombre.',
    		'email.required' => 'Ingrese E-mail.',
    		'email.email' => 'Formato E-mail incorrecto.',
    		'password.required' => 'Ingrese Contraseña.',
    		'password.min' => 'Contraseña mínimo 8 caracteres.',
    		'cpassword.required' => 'Ingrese Confirmación de Contraseña.',
    		'cpassword.same' => 'Contraseña y confirmación distintas.'
    	];

    	$validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
    	else:
    		$user = new User;
    		$user->name = Str::upper(e($request->input('name')));
    		$user->email = e($request->input('email'));
			$user->password = Hash::make($request->input('password'));
			$user->activo = $request->input('activo');

    		if($user->save()):
    			return redirect()->route('admin.usuarios.index')->with('store', 'Usuario Agregado');

    		endif;
    	endif;
	}

	public function edit(User $user)
	{
		// $user = User::findOrFail($id);
		// $doctores = Doctor::where('activo', 1)->pluck('nombre','id');
		// $roles = Role::all();
		
		// $data = [
		// 	'user' => $user,
		// 	'doctores' => ''
		// ];
        return view('admin.usuarios.edit', compact('user'));
	}

	public function update(Request $request, User $user)
	{
		$rules = [
    		'name' => 'required',
    		'email' => 'required'
    	];
    	$messages = [
    		'name.required' => 'Ingrese Nombre.',
    		'email.required' => 'Ingrese E-mail.',
    		'email.email' => 'Formato E-mail incorrecto.',
    		'password.required' => 'Ingrese Contraseña.',
    		'password.min' => 'Contraseña mínimo 8 caracteres.',
    		'cpassword.required' => 'Ingrese Confirmación de Contraseña.',
    		'cpassword.same' => 'Contraseña y confirmación distintas.'
    	];

    	$validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
			return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
		}else{
			$user->update($request->all());
			return redirect()->route('admin.usuarios.index')->with('update', 'Usuario Actualizado');
		}
	}

	public function editpermission(User $user)
	{
		// $data = ['user' => $user];
		$roles = Role::all();
        return view('admin.usuarios.permissions', compact('user','roles'));
	}

	public function updatepermission(Request $request, User $user)
	{
		$user->roles()->sync($request->roles);
		// $user->givePermissionTo($user->getPermissionsViaRoles());
		return redirect()->route('admin.usuarios.index')->with('update', 'Registo Actualizado');
	}

	public function editpassword(User $user)
	{
        return view('admin.usuarios.password', compact('user'));
	}

	public function updatepassword(Request $request, User $user)
    {
    	$rules = [
    		'password' => 'required|min:8',
    		'cpassword' => 'required|same:password'
    	];
    	$messages = [
    		'password.required' => 'Ingrese Contraseña.',
    		'password.min' => 'Contraseña mínimo 8 caracteres.',
    		'cpassword.required' => 'Ingrese Confirmación de Contraseña.',
    		'cpassword.same' => 'Contraseña y confirmación distintas.'
    	];

    	$validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
    	else:
    		$user->password = Hash::make($request->input('password'));

    		if($user->save()):
    			return redirect()->route('admin.usuarios.index')->with('update', 'Contraseña cambiada con exito')->with('typealert', 'success');

    		endif;
    	endif;
	}

}

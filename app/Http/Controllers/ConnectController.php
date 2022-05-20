<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Http\Controllers\Admin\DashboardController;

use App\Models\User;
use App\Models\Param;
Use App\Models\Empresa;
use App\Models\Sede;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ConnectController extends Controller
{
    public function __construct()
    {
		$this->middleware('guest')->except(['getLogout']);
	}

    public function getLogin()
    {
    	return view('connect.login');
    }

    public function getRegister()
    {
    	return view('connect.registerate');

    }
    
    public function postLogin(Request $request)
    {
    	$rules = [
    		'email' => 'required|email',
    		'password' => 'required|min:8'
    	];
    	$messages = [
    		'email.required' => 'Ingrese E-mail.',
    		'email.email' => 'Formato E-mail incorrecto.',
    		'password.required' => 'Ingrese Contraseña.',
    		'password.min' => 'Contraseña mínimo 8 caracteres.'
		];
		

    	$validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger');
		else:
			//True: Siempre conectado - False: Se desconecta la session
			if(Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')],false)):
				if(Empresa::count() <> 0 && Sede::count() <> 0){
					$param = Param::FindOrFail(1);
					$empresa = Empresa::FindOrFail(Auth::user()->empresa);
					$sede = Sede::FindOrFail(Auth::user()->sede);
					session(['periodo' => $sede->periodo]);
					session(['empresa' => Auth::user()->empresa]);
					session(['sede' => Auth::user()->sede]);
					session(['fecha' => \Carbon\Carbon::now()->format('Y-m-d')]);
					session(['igv' => $empresa->por_igv]);
					session(['renta' => $empresa->por_renta]);
					session(['rentalq' => $empresa->por_rentalq]);
					session(['mrenta' => $empresa->monto_renta]);
					session(['icbper' => $empresa->icbper]);
					session(['maximoboleta' => $empresa->maximoboleta]);
					session(['principal' => $sede->principal]);
					session(['mediopago' => $sede->mediopago]);
					session(['cuenta' => $sede->cuenta_id]);
				}
				
    			return redirect('/admin');
    		else:
    			return back()->with('message', 'Correo electrónico o clave incorrecto')->with('typealert', 'danger');
    		endif;
    	endif;

    }
    
    public function postRegister(Request $request)
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
    		'cpassword.same' => 'Confirmación de Contraseña distinto.'
    	];

    	$validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger');
    	else:
			if(Param::count() == 0){
				Param::create();
			}
    		$user = new User;
    		$user->name = Str::upper(e($request->input('name')));
    		$user->email = e($request->input('email'));
			$user->password = Hash::make($request->input('password'));
			$user->save();
			$var = $this->permisos_inicial($user);

			$perm = new DashboardController();
			$perm->permisosfaltantes();

			return redirect('/login')->with('message', 'Registro guardado')->with('typealert', 'success');
    	endif;

    }

	public function permisos_inicial(User $user)
	{
		if(Role::count() == 0){
			$role1 = Role::create(['name' => 'DESARROLLO']);
			$user->assignRole($role1);
		}
		if(Permission::count() == 0){
			Permission::create(['name' => 'admin.inicio',
								'description' =>'Puede ver el Inicio',
								'module_id' => '1',
								'module_name' => 'INICIO'])->syncRoles([$role1]);

			// Permission::create(['name' => 'admin.compras',
			// 					'description' =>'Puede realizar Compras',
			// 					'module_id' => '1',
			// 					'module_name' => 'INICIO']);

			// Permission::create(['name' => 'admin.ventas',
			// 					'description' =>'Puede realizar Ventas',
			// 					'module_id' => '1',
			// 					'module_name' => 'INICIO']);

			Permission::create(['name' => 'admin.tablas',
								'description' =>'Puede ver tablas del sistema',
								'module_id' => '1',
								'module_name' => 'INICIO'])->syncRoles([$role1]);
			Permission::create(['name' => 'admin.util',
								'description' =>'Puede ver Utilitarios',
								'module_id' => '1',
								'module_name' => 'INICIO'])->syncRoles([$role1]);
			Permission::create(['name' => 'admin.imports.index',
								'description' =>'Puede Importar Tablas iniciales',
								'module_id' => '1',
								'module_name' => 'INICIO'])->syncRoles([$role1]);

			// Permission::create(['name' => 'admin.clientes.index',
			// 					'description' =>'Puede ver listado Proveedor|Cliente',
			// 					'module_id' => '2',
			// 					'module_name' => 'PROVEEDOR|CLIENTE']);
			// Permission::create(['name' => 'admin.clientes.create'
			// 					,'description' =>'Puede agregar Proveedor|Cliente',
			// 					'module_id' => '2',
			// 					'module_name' => 'PROVEEDOR|CLIENTE']);
			// Permission::create(['name' => 'admin.clientes.edit',
			// 					'description' =>'Puede editar Proveedor|Cliente',
			// 					'module_id' => '2',
			// 					'module_name' => 'PROVEEDOR|CLIENTE']);
			// Permission::create(['name' => 'admin.clientes.destroy'
			// 					,'description' =>'Puede eliminar Proveedor|Cliente',
			// 					'module_id' => '2',
			// 					'module_name' => 'PROVEEDOR|CLIENTE']);
	
			Permission::create(['name' => 'admin.usuarios.index',
								'description' =>'Puede ver listado Usuarios',
								'module_id' => '3',
								'module_name' => 'USUARIOS'])->syncRoles([$role1]);
			Permission::create(['name' => 'admin.usuarios.create',
								'description' =>'Puede agregar Usuarios',
								'module_id' => '3',
								'module_name' => 'USUARIOS'])->syncRoles([$role1]);
			Permission::create(['name' => 'admin.usuarios.edit',
								'description' =>'Puede editar Usuarios',
								'module_id' => '3',
								'module_name' => 'USUARIOS'])->syncRoles([$role1]);
			Permission::create(['name' => 'admin.usuarios.permission',
								'description' =>'Puede Asignar Roles',
								'module_id' => '3',
								'module_name' => 'USUARIOS'])->syncRoles([$role1]);
			Permission::create(['name' => 'admin.usuarios.password',
								'description' =>'Puede cambiar clave',
								'module_id' => '3',
								'module_name' => 'USUARIOS'])->syncRoles([$role1]);

			Permission::create(['name' => 'admin.roles.index',
								'description' =>'Puede ver listado Roles',
								'module_id' => '4',
								'module_name' => 'ROLES'])->syncRoles([$role1]);
			Permission::create(['name' => 'admin.roles.create',
								'description' =>'Puede agregar Roles',
								'module_id' => '4',
								'module_name' => 'ROLES'])->syncRoles([$role1]);
			Permission::create(['name' => 'admin.roles.edit',
								'description' =>'Puede editar Roles',
								'module_id' => '4',
								'module_name' => 'ROLES'])->syncRoles([$role1]);
		}
		
		return true;
	}

    public function getLogout()
    {
    	Auth::logout();
    	return redirect('/');
    }
}

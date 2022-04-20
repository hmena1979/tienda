{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Usuarios')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/usuarios/all') }}"><i class="fas fa-user-friends"></i> Usuarios</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-user-friends"></i> Usuarios</h2>
						<ul>
							{{-- @if(kvfj(Auth::user()->permissions,'usuario_add')) --}}
							@can('admin.usuarios.create')
							<li>
								<a href="{{ url('/admin/usuario/create') }}">
									Agregar registro
								</a>
							</li>
							@endcan
							@can('admin.usuarios.permission')
							<li>
								<a href="#">
									Filtrar <i class="fas fa-angle-down"></i></a>
								<ul class="shadow">
									<li><a href="{{ url('/admin/usuarios/1') }}"><i class="fas fa-eye"></i> Activos</a></li>
									<li><a href="{{ url('/admin/usuarios/2') }}"><i class="fas fa-eye-slash"></i> No Activos</a></li>
									<li><a href="{{ url('/admin/usuarios/all') }}"><i class="fas fa-globe"></i> Todos</a></li>
								</ul>
							</li>
							@endcan
							{{-- @endif --}}
							{{--  
							<li>
								<a href="#" id='btn_search'>
									Buscar <i class="fas fa-search"></i>
								</a>
							</li>
							--}}
						</ul>
					</div>
					<div class="inside">
						<table id= "grid" class="table table-hover table-sm">
							<thead>
								<tr>
									<th width="35%">Nombre</th>
									<th width="25%">e-mail</th>
									<th width="30%">Activo</th>
									<th width="10%"></th>
								</tr>
							</thead>
							<tbody>
								@foreach($users as $user)
								<tr>
									<td>{{ $user->name }}@if($user->activo==2) <i class="fas fa-eye-slash"></i>@endif</td>
									<td>{{ $user->email }}</td>
									<td>{{ ($user->activo==1)?"Si":"No" }}</td>
									<td>
										<div class="opts">
											@can('admin.usuarios.edit')
											<a class="" href="{{ route('admin.usuarios.edit',$user) }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
											@endcan
											@can('admin.usuarios.password')
											<a class="" href="{{ url('/admin/usuario/'.$user->id.'/password') }}"datatoggle="tooltip" data-placement="top" title="Cambiar password"><i class="fas fa-unlock-alt"></i></a>
											@endcan
											@can('admin.usuarios.permission')											
											<a class="" href="{{ route('admin.usuarios.editpermission',$user) }}"datatoggle="tooltip" data-placement="top" title="Permisos de usuario"><i class="fas fa-cogs"></i></a>
											@endcan
										</div>
									</td>
								</tr>
								@endforeach
								</tbody>
						</table>
					</div>				
				</div>
			</div>

		</div>		
	</div>

@endsection
{{-- @section('css')
    <link rel="stylesheet" href="{{ url('/static/css/admin.css?v='.time()) }}">
@stop --}}
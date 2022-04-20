{{-- @extends('adminlte::page') --}}
@extends('admin.master')

@section('title','Roles')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/roles') }}"><i class="fas fa-cog"></i> Roles</a>
	</li>
@endsection

@section('contenido')
	{{-- @parent --}}
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-cog"></i> Roles</h2>
						<ul>
							@can('admin.roles.create')
							<li>
								<a href="{{ url('/admin/roles/create') }}">
									Agregar registro
								</a>
							</li>
							@endcan
							
							{{-- <li>
								<a class="mt-1" href="#">
									Filtrar <i class="fas fa-angle-down"></i></a>
								<ul class="shadow">
									<li><a href="{{ url('/admin/usuarios/1') }}"><i class="fas fa-eye"></i> Activos</a></li>
									<li><a href="{{ url('/admin/usuarios/2') }}"><i class="fas fa-eye-slash"></i> No Activos</a></li>
									<li><a href="{{ url('/admin/usuarios/all') }}"><i class="fas fa-globe"></i> Todos</a></li>
								</ul>
							</li> --}}
						</ul>
					</div>
					<div class="inside">
						<table id= "grid" class="table table-hover table-sm">
							<thead>
								<tr>
									<th width="90%">Nombre</th>
									<th width="10%"></th>
								</tr>
							</thead>
							<tbody>
								@foreach($roles as $rol)
								<tr>
									<td>{{ $rol->name }}</td>
									<td>
										<div class="opts">
											@can('admin.roles.edit')
											<a class="" href="{{ route('admin.roles.edit',$rol) }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
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
{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Equipos de Envasado')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.equipoenvasados.index') }}"><i class="fas fa-inbox"></i> Equipos de Envasado</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-inbox"></i> Equipos de Envasado</h2>
						<ul>
							@can('admin.equipoenvasados.create')
							<li>
								<a href="{{ route('admin.equipoenvasados.create') }}">
									Agregar registro
								</a>
							</li>
							@endcan
						</ul>
					</div>
					<div class="inside">
						<table id= "grid" class="table table-hover table-sm">
							<thead>
								<tr>
									<th width="60%">Nombre</th>
									<th width="10%">Activo</th>
									<th width="10%"></th>
								</tr>
							</thead>
							<tbody>
								@foreach($equipoenvasados as $equipo)
								<tr>
									<td>{{ $equipo->nombre }}</td>
									<td>{{ $equipo->activo==1?'Si':'No' }}</td>
									<td>
										<div class="opts">
											@can('admin.equipoenvasados.edit')
											<a class="" href="{{ route('admin.equipoenvasados.edit',$equipo) }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
											@endcan
											@can('admin.equipoenvasados.destroy')
											<form action="{{ route('admin.equipoenvasados.destroy',$equipo) }}" method="POST" class="formulario_eliminar">
												@csrf
												@method('delete')
												<button type="submit" datatoggle="tooltip" data-placement="top" title="Eliminar">
													<i class="fas fa-trash-alt"></i>
												</button>
											</form>
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
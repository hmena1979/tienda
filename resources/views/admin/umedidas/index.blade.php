{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Unidad de Medida')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.umedidas.index') }}"><i class="fas fa-ruler-combined"></i> Unidad de Medida</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-ruler-combined"></i> Unidad de Medida</h2>
						<ul>
							@can('admin.umedidas.create')
							<li>
								<a href="{{ route('admin.umedidas.create') }}">
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
									<th width="10%">Código</th>
									<th width="80%">Nombre</th>
									<th width="10%"></th>
								</tr>
							</thead>
							<tbody>
								@foreach($umedidas as $umedida)
								<tr>
									<td>{{ $umedida->codigo }}</td>
									<td>{{ $umedida->nombre }}</td>
									<td>
										<div class="opts">
											@can('admin.umedidas.edit')
											<a class="" href="{{ route('admin.umedidas.edit',$umedida) }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
											@endcan
											@can('admin.umedidas.destroy')
											<form action="{{ route('admin.umedidas.destroy',$umedida) }}" method="POST" class="formulario_eliminar">
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
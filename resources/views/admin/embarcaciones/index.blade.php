{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Embarcaciones')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.embarcaciones.index') }}"><i class="fas fa-anchor"></i> Embarcaciones</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-anchor"></i> Embarcaciones</h2>
						<ul>
							@can('admin.embarcaciones.create')
							<li>
								<a href="{{ route('admin.embarcaciones.create') }}">
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
									<th width="50%">Nombre</th>
									<th width="15%">Matrícula</th>
									<th width="15%">Protoc SANIPES</th>
									<th width="10%">CAP.Bodega</th>
									<th width="10%"></th>
								</tr>
							</thead>
							<tbody>
								@foreach($embarcaciones as $embarcacion)
								<tr>
									<td>{{ $embarcacion->nombre }}</td>
									<td>{{ $embarcacion->matricula }}</td>
									<td>{{ $embarcacion->protoc }}</td>
									<td>{{ $embarcacion->capacidad }}</td>
									<td>
										<div class="opts">
											@can('admin.embarcaciones.edit')
											<a class="" href="{{ route('admin.embarcaciones.edit',$embarcacion) }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
											@endcan
											@can('admin.umedidas.destroy')
											<form action="{{ route('admin.embarcaciones.destroy',$embarcacion) }}" method="POST" class="formulario_eliminar">
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
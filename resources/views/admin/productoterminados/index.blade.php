{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Saldo Inicial - Producto Terminado')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.productoterminados.index') }}"><i class="fas fa-dolly-flatbed"></i> Saldo Inicial - Producto Terminado</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-dolly-flatbed"></i> Saldo Inicial - Producto Terminado</h2>
						<ul>
							@can('admin.productoterminados.create')
							<li>
								<a href="{{ route('admin.productoterminados.create') }}">
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
									<th>Lote</th>
									<th>Producto</th>
									<th>Trazabilidad</th>
									<th>Código</th>
									<th>Sacos</th>
									<th width="10%"></th>
								</tr>
							</thead>
							<tbody>
								@foreach($productoterminados as $productoterminado)
								<tr>
									<td>{{ $productoterminado->lote }}</td>
									<td>{{ $productoterminado->pproceso->nombre }}</td>
									<td>{{ $productoterminado->trazabilidad->nombre }}</td>
									<td>{{ $productoterminado->dettrazabilidad->mpd_codigo }}</td>
									<td>{{ $productoterminado->entradas }}</td>
									<td>
										<div class="opts">
											@if ($productoterminado->parte_id == 0)
											@can('admin.productoterminados.edit')
											<a class="" href="{{ route('admin.productoterminados.edit',$productoterminado) }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
											@endcan
											@can('admin.productoterminados.destroy')
											<form action="{{ route('admin.productoterminados.destroy',$productoterminado) }}" method="POST" class="formulario_eliminar">
												@csrf
												@method('delete')
												<button type="submit" datatoggle="tooltip" data-placement="top" title="Eliminar">
													<i class="fas fa-trash-alt"></i>
												</button>
											</form>
                                            @endcan												
											@endif
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
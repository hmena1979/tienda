{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Centros de Costo')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.ccostos.index') }}"><i class="fas fa-grip-horizontal"></i> Centros de Costo</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-grip-horizontal"></i> Centros de Costo</h2>
						<ul>
							@can('admin.ccostos.create')
							<li>
								<a href="{{ route('admin.ccostos.create') }}">
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
									<th width="80%">Nombre</th>
									<th width="10%"></th>
								</tr>
							</thead>
							<tbody>
								@foreach($ccostos as $ccosto)
								<tr>
									<td>{{ $ccosto->nombre }}</td>
									<td>
										<div class="opts">
											@can('admin.ccostos.edit')
											<a class="" href="{{ route('admin.ccostos.edit',$ccosto) }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
											@endcan
											@can('admin.umedidas.destroy')
											<form action="{{ route('admin.ccostos.destroy',$ccosto) }}" method="POST" class="formulario_eliminars">
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
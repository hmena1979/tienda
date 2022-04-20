@extends('admin.master')
@section('title','Destinos')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.destinos.index') }}"><i class="fas fa-chart-bar"></i> Destinos</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-chart-bar"></i> Destinos</h2>
						<ul>
							@can('admin.destinos.create')
							<li>
								<a href="{{ route('admin.destinos.create') }}">
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
									<th width="90%">Nombre</th>
									<th width="10%"></th>
								</tr>
							</thead>
							<tbody>
								@foreach($destinos as $destino)
								<tr>
									<td>{{ $destino->nombre }}</td>
									<td>
										<div class="opts">
											@can('admin.destinos.edit')
											<a class="" href="{{ route('admin.destinos.edit',$destino) }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
											@endcan
											@can('admin.destinos.destroy')
											@if ($destino->detdestinos->count() == 0)
											<form action="{{ route('admin.destinos.destroy',$destino) }}" method="POST" class="formulario_eliminars">
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
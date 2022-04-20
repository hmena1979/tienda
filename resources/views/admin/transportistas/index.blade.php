@extends('admin.master')
@section('title','Transportistas')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.transportistas.index') }}"><i class="fas fa-truck-moving"></i> Transportistas</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-truck-moving"></i> Transportistas</h2>
						<ul>
							@can('admin.transportistas.create')
							<li>
								<a href="{{ route('admin.transportistas.create') }}">
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
									<th width="15%">RUC</th>
									<th width="75%">Nombre</th>
									<th width="10%"></th>
								</tr>
							</thead>
							<tbody>
								@foreach($transportistas as $transportista)
								<tr>
									<td>{{ $transportista->ruc }}</td>
									<td>{{ $transportista->nombre }}</td>
									<td>
										<div class="opts">
											@can('admin.transportistas.edit')
											<a class="" href="{{ route('admin.transportistas.edit',$transportista) }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
											@endcan
											@can('admin.transportistas.destroy')
											@if ($transportista->camaras->count() == 0)
											<form action="{{ route('admin.transportistas.destroy',$transportista) }}" method="POST" class="formulario_eliminars">
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
@extends('admin.master')
@section('title','Despiece')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.despieces.index') }}"><i class="fas fa-dice-d20"></i> Despiece</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-dice-d20"></i> Despiece</h2>
						<ul>
							@can('admin.destinos.create')
							<li>
								<a href="{{ route('admin.despieces.create') }}">
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
								@foreach($despieces as $despiece)
								<tr>
									<td>{{ $despiece->nombre }}</td>
									<td>
										<div class="opts">
											@can('admin.despieces.edit')
											<a class="" href="{{ route('admin.despieces.edit',$despiece) }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
											@endcan
											@can('admin.despieces.destroy')
											@if ($despiece->detdespieces->count() == 0)
											<form action="{{ route('admin.despieces.destroy',$despiece) }}" method="POST" class="formulario_eliminars">
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
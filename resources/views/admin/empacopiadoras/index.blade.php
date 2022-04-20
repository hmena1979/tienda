@extends('admin.master')
@section('title','Empresas Acopiadoras')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.empacopiadoras.index') }}"><i class="fas fa-newspaper"></i> Empresas Acopiadoras</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-newspaper"></i> Empresas Acopiadoras</h2>
						<ul>
							@can('admin.empacopiadoras.create')
							<li>
								<a href="{{ route('admin.empacopiadoras.create') }}">
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
								@foreach($empacopiadoras as $empacopiadora)
								<tr>
									<td>{{ $empacopiadora->nombre }}</td>
									<td>
										<div class="opts">
											@can('admin.empacopiadoras.edit')
											<a class="" href="{{ route('admin.empacopiadoras.edit',$empacopiadora) }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
											@endcan
											@can('admin.empacopiadoras.destroy')
											@if ($empacopiadora->acopiadors->count() == 0)
											<form action="{{ route('admin.empacopiadoras.destroy',$empacopiadora) }}" method="POST" class="formulario_eliminars">
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
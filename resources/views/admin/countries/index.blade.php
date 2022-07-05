{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Paises')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.countries.index') }}"><i class="fas fa-globe-americas"></i> Paises</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-globe-americas"></i> Paises (Codificación según estandar ISO 3166-2)</h2>
						<ul>
							@can('admin.countries.create')
							<li>
								<a href="{{ route('admin.countries.create') }}">
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
									<th width="20%">Codigo</th>
									<th width="60%">Nombre</th>
									<th width="10%"></th>
								</tr>
							</thead>
							<tbody>
								@foreach($countries as $country)
								<tr>
									<td>{{ $country->codigo }}</td>
									<td>{{ $country->nombre }}</td>
									<td>
										<div class="opts">
											@can('admin.countries.edit')
											<a class="" href="{{ route('admin.countries.edit',$country) }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
											@endcan
											@can('admin.countries.destroy')
											<form action="{{ route('admin.countries.destroy',$country) }}" method="POST" class="formulario_eliminar">
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
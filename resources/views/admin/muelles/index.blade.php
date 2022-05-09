{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Muelles')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.muelles.index') }}"><i class="fab fa-docker"></i> Muelles</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fab fa-docker"></i> Muelles</h2>
						<ul>
							@can('admin.muelles.create')
							<li>
								<a href="{{ route('admin.muelles.create') }}">
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
									<th width="30%">Protocolo SANIPES</th>
									<th width="10%"></th>
								</tr>
							</thead>
							<tbody>
								@foreach($muelles as $muelle)
								<tr>
									<td>{{ $muelle->nombre }}</td>
									<td>{{ $muelle->protocolo }}</td>
									<td>
										<div class="opts">
											@can('admin.muelles.edit')
											<a class="" href="{{ route('admin.muelles.edit',$muelle) }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
											@endcan
											@can('admin.muelles.destroy')
											<form action="{{ route('admin.muelles.destroy',$muelle) }}" method="POST" class="formulario_eliminar">
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
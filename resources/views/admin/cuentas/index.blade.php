{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Cuentas')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.cuentas.index') }}"><i class="fas fa-money-check-alt"></i> Cuentas</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-money-check-alt"></i> Cuentas</h2>
						<ul>
							@can('admin.cuentas.create')
							<li>
								<a href="{{ route('admin.cuentas.create') }}">
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
									<th width="45%">Nombre</th>
									<th width="10%">Moneda</th>
									<th width="15%">Monto Máximo</th>
									<th width="10%">Tipo</th>
									<th width="10%"></th>
								</tr>
							</thead>
							<tbody>
								@foreach($cuentas as $cuenta)
								<tr>
									<td>{{ $cuenta->nombre }}</td>
									<td>{{ $cuenta->moneda }}</td>
									<td>{{ number_format($cuenta->maximo,2) }}</td>
									<td>{{ $cuenta->tipo == 1 ? 'BANCO' : 'CAJA' }}</td>
									<td>
										<div class="opts">
											@can('admin.cuentas.edit')
											<a class="" href="{{ route('admin.cuentas.edit',$cuenta) }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
											@endcan
											@can('admin.cuentas.destroy')
											<form action="{{ route('admin.cuentas.destroy',$cuenta) }}" method="POST" class="formulario_eliminars">
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
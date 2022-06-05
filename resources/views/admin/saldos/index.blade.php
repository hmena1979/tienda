{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Saldos Iniciales')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.saldos.index') }}"><i class="fas fa-window-restore"></i> Saldos Iniciales</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-window-restore"></i> Saldos Iniciales</h2>
						<ul>
							@can('admin.saldos.create')
							<li>
								<a href="{{ route('admin.saldos.create') }}">
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
									<th width="45%">Producto</th>
									<th width="10%">Cantidad</th>
									<th width="15%">Precio</th>
									<th width="10%"></th>
								</tr>
							</thead>
							<tbody>
								@foreach($saldos as $saldo)
								<tr>
									<td>{{ $saldo->producto->nombre .' X ' . $saldo->producto->umedida->nombre }}</td>
									<td>{{ number_format($saldo->saldo,2) }}</td>
									<td>{{ number_format($saldo->precio,2) }}</td>
									<td>
										<div class="opts">
											@can('admin.saldos.edit')
											<a class="" href="{{ route('admin.saldos.edit',$saldo) }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
											@endcan
											@can('admin.cuentas.destroy')
											<form action="{{ route('admin.saldos.destroy',$saldo) }}" method="POST" class="formulario_eliminars">
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
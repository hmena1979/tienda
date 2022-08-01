{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title', 'Inicio')

{{-- @section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/terapias') }}"><i class="fas fa-procedures"></i> Accesos</a>
	</li>
@endsection --}}

{{-- @section('content_header')
    <h1>Inicio</h1>
@stop --}}

{{-- @section('content')
    <p>Contenido.</p>
@stop --}}
@section('contenido')
	<div class="container-fluid">
		<div class="row">
			@if ($productoterminado)
			<div class="col-md-6 mb-4 d-flex">
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-home"></i><strong> Stock Producto Terminado</strong></h2>
						<ul>
							<li>
								<a class="btn mt-1 btn-seleccionado" href="{{ route('admin.excel.resumentrazabilidad') }}">
                                    <i class="far fa-file-excel"></i> T
                                </a>
							</li>
							<li>
								<a class="btn mt-1 btn-seleccionado" href="{{ route('admin.excel.resumencodigo') }}">
                                    <i class="far fa-file-excel"></i> C
                                </a>
							</li>
						</ul>
					</div>
					<div class="inside">
						<div class="row">
							<div class="col-md-12">
								<table class="table table-hover table-sm">
									<thead>
										<tr>
											<th>Producto</th>
											<th class="text-center">Envase</th>
											<th class="text-center">Cantidad</th>
											<th class="text-center">Kilos</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										@foreach ($productoterminado as $det)
										<tr>
											<td>{{ $det->pproceso->nombre }}</td>
											<td>{{ $envase[$det->envase] }}</td>
											<td class="text-center">{{ number_format($det->saldo) }}</td>
											<td class="text-center">{{ number_format($det->kilos) }}</td>
											<td></td>
										</tr>
										@endforeach
										<tr>
											<th colspan="2">TOTAL</th>
											<th class="text-center">{{ number_format($productoterminado->sum('saldo')) }}</th>
											<th class="text-center">{{ number_format($productoterminado->sum('kilos')) }}</th>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>				
				</div>
			</div>
			@endif
			@if ($detparte)
			<div class="col-md-6 mb-4 d-flex">
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-home"></i><strong> Rendimiento Lote {{$parte->lote}}</strong></h2>
					</div>
					<div class="inside">
						<div class="row">
							<div class="col-md-12">
								<table class="table table-hover table-sm">
									<thead>
										<tr>
											<th>Trazabilidad</th>
											<th class="text-center">Rendimiento</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										@foreach ($detparte as $det)
										<tr>
											<td>{{ $det->trazabilidad->nombre }}</td>
											<td class="text-center">{{ $det->rendimiento }} %</td>
											<td></td>
										</tr>
										@endforeach
										<tr>
											<th>TOTAL</th>
											<th class="text-center">{{ $detparte->sum('rendimiento') }} %</th>
											<td></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>				
				</div>
			</div>
			@endif
			@if ($productos)
			<div class="col-md-6 mb-4 d-flex">
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-home"></i><strong> Productos por Debajo de Stock Mínimo(15)</strong></h2>
					</div>
					<div class="inside">
						<div class="row">
							<div class="col-md-12">
								<table class="table table-hover table-sm">
									<thead>
										<tr>
											<th>Producto</th>
											<th class="text-center">Stock</th>
											<th class="text-center">Mínimo</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										@foreach ($productos as $det)
										<tr>
											<td>{{ $det->nombre . ' x ' .$det->umedida->nombre }}</td>
											<td class="text-center">{{ $det->stock }}</td>
											<td class="text-center">{{ $det->stockmin }}</td>
											<td></td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>				
				</div>
			</div>
			@endif
			@if ($rcompras)
			<div class="col-md-6 mb-4 d-flex">
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-home"></i><strong> Cuentas por Pagar(15)</strong></h2>
					</div>
					<div class="inside">
						<div class="row">
							<div class="col-md-12">
								<table class="table table-hover table-sm">
									<thead>
										<tr>
											<th>Proveedor</th>
											<th class="text-center">Saldo</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										@foreach ($rcompras as $det)
										<tr>
											<td>{{ $det->cliente->razsoc }}</td>
											<td class="text-center">{{ number_format($det->saldo,2) }}</td>
											<td></td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>				
				</div>
			</div>
			@endif

		</div>		
	</div>
@endsection


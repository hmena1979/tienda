{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Materias Primas')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.materiaprimas.index') }}"><i class="fas fa-fish"></i> Materias Primas</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-fish"></i> Materias Primas</h2>
						<ul>
							@can('admin.materiaprimas.create')
							<li>
								<a href="{{ route('admin.materiaprimas.create') }}">
									Agregar registro
								</a>
							</li>
							@endcan
						</ul>
					</div>
					<div class="inside">
						<table id= "grid" class="table table-bordered table-responsive table-hover table-sm table-materia-prima">
							<thead>
								<tr>
									<th width='5%'>Ingreso <br> Planta</th>
									<th width='5%'>Chofer</th>
									<th width='5%'>Empresa Transportista</th>
									<th width='5%'>Empresa Acopiadora</th>
									<th width='5%'>Acopiador</th>
									<th width='5%'>Marca</th>
									<th width='5%'>Placa</th>
									<th width='5%'>Lote</th>
									<th width='5%'>Cajas <br> Declaradas</th>
									<th width='5%'>Peso <br> Planta KG</th>
									<th width='5%'>Fecha <br> Partida</th>
									<th width='5%'>Fecha <br> Llegada</th>
									<th width='5%'>Hora <br> Descarga</th>
									<th width='5%'>Proveedor</th>
									<th width='5%'>Precio</th>
									<th width='5%'>Lugar</th>
									<th width='5%'>Tipo Producto</th>
									<th width='5%'>Destare KG</th>
									<th width='5%'>Observaciones</th>
									<th width='5%'></th>
								</tr>
							</thead>
							<tbody>
								@foreach($materiaprimas as $materiaprima)
								<tr>
									<td>{{ $materiaprima->ingplanta }}</td>
									<td>{{ $materiaprima->chofer->nombre }}</td>
									<td>{{ $materiaprima->transportista->nombre }}</td>
									<td>{{ $materiaprima->empacopiadora->nombre }}</td>
									<td>{{ $materiaprima->acopiador->nombre }}</td>
									<td>{{ $materiaprima->camara->marca }}</td>
									<td>{{ $materiaprima->camara->placa }}</td>
									<td>{{ $materiaprima->lote }}</td>
									<td>{{ $materiaprima->cajas }}</td>
									<td>{{ $materiaprima->pplanta }}</td>
									<td>{{ $materiaprima->fpartida }}</td>
									<td>{{ $materiaprima->fllegada }}</td>
									<td>{{ $materiaprima->hdescarga }}</td>
									<td>{{ $materiaprima->cliente->razsoc }}</td>
									<td>{{ $materiaprima->precio }}</td>
									<td>{{ $materiaprima->lugar }}</td>
									<td>{{ $materiaprima->producto->nombre }}</td>
									<td>{{ $materiaprima->destare }}</td>
									<td>{{ $materiaprima->observaciones }}</td>
									<td>
										<div class="opts">
											@can('admin.embarcaciones.edit')
											<a class="" href="{{ route('admin.materiaprimas.edit',$materiaprima) }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
											@endcan
											@can('admin.umedidas.destroy')
											<form action="{{ route('admin.materiaprimas.destroy',$materiaprima) }}" method="POST" class="formulario_eliminar">
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
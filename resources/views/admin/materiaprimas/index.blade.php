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
							<li>
								{{-- <a class="" href="{{ route('admin.pdf.facturacion',1) }}" target="_blank" datatoggle="tooltip" data-placement="top" title="Imprimir"><i class="fas fa-print"></i></a> --}}

								<button class="btn btn-convertir" type="button" id="btnprint" data-toggle="modal" data-target="#print" onclick="limpia()"><i class="fas fa-print"></i></button>
							</li>
							@endcan
						</ul>
					</div>
					<div class="inside">
						<table id= "grid" class="table table-bordered table-responsive table-hover table-sm table-materia-prima">
							<thead>
								<tr>
									<th class="align-middle">Ingreso <br> Planta</th>
									<th class="align-middle">Chofer</th>
									<th class="align-middle">Empresa Transportista</th>
									<th class="align-middle">Empresa Acopiadora</th>
									<th class="align-middle">Acopiador</th>
									<th class="align-middle">Marca</th>
									<th class="align-middle">Placa</th>
									<th class="align-middle">Lote</th>
									<th class="align-middle">Cajas <br> Declaradas</th>
									<th class="align-middle">Peso <br> Planta KG</th>
									<th class="align-middle">Fecha <br> Partida</th>
									<th class="align-middle">Fecha <br> Llegada</th>
									<th class="align-middle">Hora <br> Descarga</th>
									<th class="align-middle">Proveedor</th>
									<th class="align-middle">Precio</th>
									<th class="align-middle">Lugar</th>
									<th class="align-middle">Tipo Producto</th>
									<th class="align-middle">Destare KG</th>
									<th class="align-middle">Observaciones</th>
									<th class="align-middle"></th>
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
						<!-- Modal -->
                        <div class="modal fade" id="print" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
									<div class="modal-header">
										<strong>Ingreso a Planta</strong>
									</div>
									<div class="modal-body">
										<div class="row">
											<div class="col-md-6 form-group">
												{!! Form::label('finicio', 'Desde:') !!}
												{!! Form::date('finicio', null, ['class'=>'form-control']) !!}
											</div>
											<div class="col-md-6 form-group">
												{!! Form::label('ffin', 'Hasta:') !!}
												{!! Form::date('ffin', null, ['class'=>'form-control']) !!}
											</div>
										</div>
									</div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-convertir" id='btnexcel'>Mostrar</button>
                                        <button type="button" class="btn btn-convertir" data-dismiss='modal'>Salir</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Fin Modal -->
					</div>				
				</div>
			</div>

		</div>		
	</div>

@endsection
{{-- @section('css')
    <link rel="stylesheet" href="{{ url('/static/css/admin.css?v='.time()) }}">
@stop --}}
@section('script')
<script>
	var url_global='{{url("/")}}';
	$(document).ready(function(){
		$('#btnexcel').click(function(){
			let desde = $('#finicio').val();
			let hasta = $('#ffin').val();
			let url = url_global + '/admin/excel/' + desde + '/' + hasta +'/materiaprima';
			window.open(url,'_blank');
			$('#print').modal('hide')
		});
	});
</script>
@endsection
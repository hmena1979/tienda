{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Planilla de Envasado')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.envasados.index') }}"><i class="far fa-clipboard"></i> Planilla de Envasado</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="far fa-clipboard"></i> Planilla de Envasado</h2>
						<ul>
							<li>
                                <div class="cita mt-2">
                                    {!! Form::open(['route'=>'admin.envasados.change']) !!}
                                    <div class="input-group tamvar">
                                        {!! Form::select('mes',getMeses(),substr($periodo,0,2),['class'=>'custom-select']) !!}
                                        {!! Form::text('año', substr($periodo,2,4), ['class'=>'form-control','maxlength'=>'4','autocomplete'=>'off']) !!}
                                        <div class="input-group-append">
                                            {!! Form::submit('Mostar', ['class'=>'btn btn-convertir']) !!}
                                        </div>
                                        
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </li>
							@can('admin.envasados.create')
							<li>
								<a href="{{ route('admin.envasados.create') }}">
									Agregar registro
								</a>
							</li>
							@endcan
						</ul>
					</div>
					<div class="inside">
						<table id= "gridv" class="table table-responsive table-hover">
							<thead>
								<tr>
									<th width='10%' class="align-middle">Número</th>
									<th width='20%' class="align-middle">Lote</th>
									<th width='10%' class="align-middle">Fecha</th>
									<th width='10%' class="align-middle">F.Producción</th>
									<th width='30%' class="align-middle">Supervisor</th>
									<th width='10%' class="align-middle">Turno</th>
									<th width='10%' class="align-middle"></th>
								</tr>
							</thead>
							<tbody>
								@foreach($envasados as $envasado)
								<tr class="
								@if ($envasado->estado > 1)
                                negrita
								@endif
								">
									<td>{{ $envasado->numero }}</td>
									<td>{{ $envasado->lote }}</td>
									<td>{{ $envasado->fecha }}</td>
									<td>{{ $envasado->fproduccion }}</td>
									<td>{{ $envasado->supervisor->nombre }}</td>
									<td>{{ $envasado->turno==1?'Dia':'Noche' }}</td>
									<td>
										<div class="opts">
											@can('admin.envasados.edit')
											<a class="" href="{{ route('admin.envasados.edit',$envasado) }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
											@endcan
											@can('admin.envasados.destroy')
											<form action="{{ route('admin.envasados.destroy',$envasado) }}" method="POST" class="formulario_eliminars">
												@csrf
												@method('delete')
												<button type="submit" datatoggle="tooltip" data-placement="top" title="Eliminar">
													<i class="fas fa-trash-alt"></i>
												</button>
											</form>
                                            @endcan
											{{-- <a class="" href="{{ route('admin.pdf.materiaprima',$materiaprima) }}" target="_blank" datatoggle="tooltip" data-placement="top" title="Imprimir"><i class="fas fa-print"></i></a> --}}
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
                                        <button type="button" class="btn btn-convertir" id='btnexcel'>Modelo 01</button>
                                        <button type="button" class="btn btn-convertir" id='btnexcelii'>Modelo 02</button>
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
		$('#btnexcelii').click(function(){
			let desde = $('#finicio').val();
			let hasta = $('#ffin').val();
			let url = url_global + '/admin/excel/' + desde + '/' + hasta +'/materiaprimaii';
			window.open(url,'_blank');
			$('#print').modal('hide')
		});

		$('#gridv').DataTable({
			"order": [[0, 'desc'],[1, 'desc']],
			"paging":   true,
			"ordering": true,
			"info":     true,
			"language":{
				"info": "_TOTAL_ Registros",
				"search": "Buscar",
				"paginate":{
					"next": "Siguiente",
					"previous": "Anterior"
				},
				"lengthMenu": "Mostrar <select>"+
								"<option value='10'>10</option>"+
								"<option value='25'>25</option>"+
								"<option value='50'>50</option>"+
								"<option value='100'>100</option>"+
								"<option value='-1'>Todos</option>"+
								"</select> Registros",
				"loadingRecords": "Cargando...",
				"processing": "Procesando...",
				"emptyTable": "No se encontraton coincidencias",
				"zeroRecords": "No se encontraton coincidencias",
				"infoEmpty": "",
				"infoFiltered": ""
			}
		});
	});
</script>
@endsection
@extends('admin.master')
@section('title','Parte de Producción')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.partes.index') }}"><i class="fas fa-industry"></i> Parte de Producción</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-industry"></i> Parte de Producción</h2>
						<ul>
							<li>
                                <div class="cita mt-2">
                                    {!! Form::open(['route'=>'admin.partes.change']) !!}
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
							@can('admin.partes.create')
							<li>
								<a href="{{ route('admin.partes.create') }}">
									Agregar registro
								</a>
							</li>
							@endcan
						</ul>
					</div>
					<div class="inside">
						<table id= "gridv" class="table table-hover table-sm">
							<thead>
								<tr>
									<th width="15%">Lote</th>
									<th width="10%">Recepción</th>
									<th width="10%">Congelación</th>
									<th width="10%">Empaque</th>
									<th width="15%">Trazabilidad</th>
									<th width="10%"></th>
								</tr>
							</thead>
							<tbody>
								@foreach($partes as $parte)
								<tr>
									<td>{{ $parte->lote }}</td>
									<td>{{ $parte->recepcion }}</td>
									<td>{{ $parte->congelacion }}</td>
									<td>{{ $parte->empaque }}</td>
									<td>{{ $parte->trazabilidad }}</td>
									<td>
										<div class="opts">
											@can('admin.partes.edit')
											<a class="" href="{{ route('admin.partes.edit',$parte) }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
											@endcan
											@can('admin.partes.destroy')
											@if ($parte->detpartes->count() == 0)
											<form action="{{ route('admin.partes.destroy',$parte) }}" method="POST" class="formulario_eliminars">
												@csrf
												@method('delete')
												<button type="submit" datatoggle="tooltip" data-placement="top" title="Eliminar">
													<i class="fas fa-trash-alt"></i>
												</button>
											</form>
                                            @endcan
											@endif
											<a class="" href="{{ route('admin.excel.parte',$parte) }}" datatoggle="tooltip" data-placement="top" title="Imprimir"><i class="fas fa-print"></i></a>
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
@section('script')
<script>
	var url_global='{{url("/")}}';
	$(document).ready(function(){
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
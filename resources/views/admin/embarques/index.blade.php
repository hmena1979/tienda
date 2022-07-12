{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Embarques')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.embarques.index') }}"><i class="fab fa-docker"></i> Embarques</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fab fa-docker"></i> Embarques</h2>
						<ul>
							<li>
                                <div class="cita mt-1">
                                    {!! Form::open(['route'=>'admin.embarques.change']) !!}
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
							@can('admin.embarques.create')
							<li>
								<a href="{{ route('admin.embarques.create') }}">
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
									<th width="35%">Cliente</th>
									<th width="20%">Destino</th>
									<th width="20%">Boocking</th>
									<th width="10%"></th>
								</tr>
							</thead>
							<tbody>
								@foreach($embarques as $embarque)
								<tr> {{ $embarque->country->nombre }}
									<td>{{ $embarque->lote }}</td>
									<td>{{ $embarque->cliente->razsoc }}</td>
									<td>{{ $embarque->country->nombre }}</td>
									<td>{{ $embarque->booking }}</td>
									<td>
										<div class="opts">
											@can('admin.embarques.edit')
											<a class="" href="{{ route('admin.embarques.edit',$embarque) }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
											@endcan
											@can('admin.embarques.destroy')
											<form action="{{ route('admin.embarques.destroy',$embarque) }}" method="POST" class="formulario_eliminar">
												@csrf
												@method('delete')
												<button type="submit" datatoggle="tooltip" data-placement="top" title="Eliminar">
													<i class="fas fa-trash-alt"></i>
												</button>
											</form>
                                            @endcan
											<a class="" href="{{ route('admin.pdf.residuo',$embarque) }}" target="_blank" datatoggle="tooltip" data-placement="top" title="Imprimir"><i class="fas fa-print"></i></a>
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
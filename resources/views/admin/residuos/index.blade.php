{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Residuos Sólidos')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.residuos.index') }}"><i class="far fa-trash-alt"></i> Residuos Sólidos</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="far fa-trash-alt"></i> Residuos Sólidos</h2>
						<ul>
							@can('admin.residuos.create')
							<li>
								<a href="{{ route('admin.residuos.create') }}">
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
									<th width="10%">Especie</th>
									<th width="25%">Cliente</th>
									<th width="10%">Pesaje N°</th>
									<th width="10%">Emisión</th>
									<th width="10%">Guía HL</th>
									<th width="10%">Total Kgs</th>
									<th width="10%"></th>
								</tr>
							</thead>
							<tbody>
								@foreach($residuos as $residuo)
								<tr>
									<td>{{ $residuo->lote }}</td>
									<td>{{ $residuo->especie }}</td>
									<td>{{ $residuo->cliente->razsoc }}</td>
									<td>{{ $residuo->ticket_balanza }}</td>
									<td>{{ $residuo->emision }}</td>
									<td>{{ $residuo->guiahl }}</td>
									<td>{{ $residuo->peso }}</td>
									<td>
										<div class="opts">
											@can('admin.residuos.edit')
											<a class="" href="{{ route('admin.residuos.edit',$residuo) }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
											@endcan
											@can('admin.supervisors.destroy')
											<form action="{{ route('admin.residuos.destroy',$residuo) }}" method="POST" class="formulario_eliminar">
												@csrf
												@method('delete')
												<button type="submit" datatoggle="tooltip" data-placement="top" title="Eliminar">
													<i class="fas fa-trash-alt"></i>
												</button>
											</form>
                                            @endcan
											<a class="" href="{{ route('admin.pdf.residuo',$residuo) }}" target="_blank" datatoggle="tooltip" data-placement="top" title="Imprimir"><i class="fas fa-print"></i></a>
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
{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Lotes')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.lotes.index') }}"><i class="fas fa-barcode"></i> Lotes</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-barcode"></i> Lotes</h2>
						<ul>
							@can('admin.lotes.create')
							<li>
								<a href="{{ route('admin.lotes.create') }}">
									Agregar registro
								</a>
							</li>
							@endcan
						</ul>
					</div>
					<div class="inside">
						<table id= "gridlote" class="table table-hover table-sm">
							<thead>
								<tr>
									<th width="20%">Lote</th>
									<th width="20%">Fecha Inicio</th>
									<th width="20%">Fecha Término</th>
									<th width="10%"></th>
								</tr>
							</thead>
							<tbody>
								@foreach($lotes as $lote)
								<tr>
									<td>{{ $lote->lote }}</td>
									<td>{{ $lote->finicial }}</td>
									<td>{{ $lote->ffinal }}</td>
									<td>
										<div class="opts">
											@can('admin.lotes.edit')
											<a class="" href="{{ route('admin.lotes.edit',$lote) }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
											@endcan
											@can('admin.lotes.destroy')
											<form action="{{ route('admin.lotes.destroy',$lote) }}" method="POST" class="formulario_eliminar">
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

@section('script')
<script>
	$(document).ready(function(){
		$('#gridlote').DataTable({
			"order": [[0, 'desc']],
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
	})
</script>	
@endsection
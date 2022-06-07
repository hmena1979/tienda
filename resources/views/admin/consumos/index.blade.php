{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Consumos')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.consumos.index') }}"><i class="fas fa-cart-arrow-down"></i> Consumos</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-cart-arrow-down"></i> Consumos</h2>
						<ul>
							<li>
                                <div class="cita mt-2">
                                    {!! Form::open(['route'=>'admin.consumos.change']) !!}
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
							@can('admin.consumos.create')
							<li>
								<a href="{{ route('admin.consumos.create') }}">
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
									<th width="10%">Fecha</th>
									<th width="10%">Número</th>
									<th width="25%">Destino</th>
									<th width="25%">Detalle</th>
									{{-- <th width="25%">C.Costo</th> --}}
									<th width="5%"></th>
								</tr>
							</thead>
							<tbody>
								@foreach($rventas as $rventa)
								<tr class="@if($rventa->status==3)rojo @endif">
									<td>
										{{date('Y-m-d',strtotime($rventa->fecha))}}
									</td>
									<td>{{ numDoc($rventa->serie,$rventa->numero) }}</td>
									<td>{{ trim($rventa->detdestino->destino->nombre) }}</td>
									<td>{{ trim($rventa->detdestino->nombre) }}</td>
									{{-- <td>{{ trim($rventa->ccosto->nombre) }}</td> --}}
									<td class="text-center">
										<div class="opts">
											@can('admin.consumos.edit')
											<a class="" href="{{ route('admin.consumos.edit',$rventa) }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
											@endcan
											<a class="" href="{{ route('admin.pdf.facturacion',$rventa) }}" target="_blank" datatoggle="tooltip" data-placement="top" title="Imprimir"><i class="fas fa-print"></i></a>
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
@section('script')
<script>
	$(document).ready(function(){
		$('#gridv').DataTable({
				"order": [[0, 'desc'],[2, 'desc']],
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
{{-- @section('css')
    <link rel="stylesheet" href="{{ url('/static/css/admin.css?v='.time()) }}">
@stop --}}
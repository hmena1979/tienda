{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Registro de Ventas')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.rventas.index') }}"><i class="fas fa-cash-register"></i> Registro de Ventas</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-cash-register"></i> Registro de Ventas</h2>
						<ul>
							<li>
                                <div class="cita mt-2">
                                    {!! Form::open(['route'=>'admin.rventas.change']) !!}
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
							@can('admin.rventas.create')
							<li>
								<a href="{{ route('admin.rventas.create') }}">
									Agregar registro
								</a>
							</li>
							@endcan
						</ul>
					</div>
					<div class="inside">
						{{-- {{ dd($srcompras) }} --}}
						<table id= "gridv" class="table table-hover table-sm">
							<thead>
								<tr>
									<th width="10%">Fecha</th>
									<th width="10%">Moneda</th>
									<th width="10%">Número</th>
									<th width="5%">TD</th>
									<th width="40%">Cliente</th>
									<th class="text-right" width="10%">Total</th>
									<th width="10%"></th>
								</tr>
							</thead>
							<tbody>
								@foreach($rventas as $rventa)
								<tr class="@if($rventa->status==3)rojo @endif">
									<td>
										{{date('Y-m-d',strtotime($rventa->fecha))}}
									</td>
									<td>{{ $rventa->monedas->nombre }}</td>
									<td datatoggle="tooltip" data-placement="top" title="{{ $rventa->cdr }}">{{ numDoc($rventa->serie,$rventa->numero) }}</td>
									<td>{{ $rventa->tipocomprobante_codigo }}</td>
									<td>{{ $rventa->cliente->razsoc }}</td>
									<td class="text-right">{{ number_format($rventa->total,2) }}</td>
									<td class="text-center">
										<div class="opts">
											{{-- @can('admin.rventas.edit')
											<a class="" href="{{ route('admin.rventas.edit',$rventa) }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
											@endcan --}}
											<a class="" href="{{ route('admin.pdf.facturacion',$rventa) }}" target="_blank" datatoggle="tooltip" data-placement="top" title="Imprimir"><i class="fas fa-print"></i></a>
											{{-- <a class="" href="{{ route('admin.sunat.ventas',$rventa) }}" target="_blank" datatoggle="tooltip" data-placement="top" title="XML"><i class="fas fa-print"></i></a> --}}
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
		<div class="row mtop16">
			<div class="col-md-12">
                <div class="panelprin shadow">
                    {{-- <div class="headercontent">
                        <h2 class="title">Impuestos del Periodo</h2>
					</div> --}}
					<div class="inside">
						<div class="row">
							<div class="col-md-10"></div>
							<div class="col-md-2">
								<table class="table table-hover table-sm table-bordered">
									<thead>
										<tr>
											<th class="text-center" width='50%'>IGV S/</th>
											{{-- <th class="text-center" width='50%'>Renta S/</th> --}}
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="text-center">{{ number_format($impuesto,2) }}</td>
											{{-- <td class="text-center">{{ number_format($renta,2) }}</td> --}}
										</tr>
									</tbody>
								</table>
							</div>

						</div>
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
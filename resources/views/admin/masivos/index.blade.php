{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Pagos Masivos')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.masivos.index') }}"><i class="fas fa-file-invoice-dollar"></i> Pagos Masivos</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-file-invoice-dollar"></i> Pagos Masivos</h2>
						<ul>
							<li>
                                <div class="cita mt-2">
                                    {!! Form::open(['route'=>'admin.masivos.change']) !!}
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
							@can('admin.masivos.create')
							<li>
								<a href="{{ route('admin.masivos.create') }}">
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
									<th width="20%">Cuenta</th>
									<th width="15%">Monto</th>
									<th width="45%">Glosa</th>
									<th width="10%"></th>
								</tr>
							</thead>
							<tbody>
								@foreach($masivos as $masivo)
								<tr class="@if($masivo->estado==2)verde negrita @endif @if($masivo->estado==3)azul negrita @endif">
									<td>
										{{date('Y-m-d',strtotime($masivo->fecha))}}
									</td>
									<td>{{ $masivo->cuenta->nombre }}</td>
									<td>{{ number_format($masivo->monto,2) }}</td>
									<td>{{ $masivo->glosa }}</td>
									<td class="text-center">
										<div class="opts">
											@can('admin.masivos.edit')
											<a class="" href="{{ route('admin.masivos.edit',$masivo) }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
											@endcan
											@can('admin.masivos.destroy')
											@if ($masivo->detmasivos()->count() == 0)
											<form action="{{ route('admin.masivos.destroy',$masivo) }}" method="POST" class="formulario_eliminars">
												@csrf
												@method('delete')
												<button type="submit" datatoggle="tooltip" data-placement="top" title="Eliminar">
													<i class="fas fa-trash-alt"></i>
												</button>
											</form>
											@endif
                                            @endcan
											{{-- <a class="" href="{{ route('admin.pdf.facturacion',$rventa) }}" target="_blank" datatoggle="tooltip" data-placement="top" title="Imprimir"><i class="fas fa-print"></i></a> --}}
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
	})
</script>	
@endsection
{{-- @section('css')
    <link rel="stylesheet" href="{{ url('/static/css/admin.css?v='.time()) }}">
@stop --}}
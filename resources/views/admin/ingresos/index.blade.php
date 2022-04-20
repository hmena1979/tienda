{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Ingresos Almacén')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.ingresos.index') }}"><i class="fas fa-plus-circle"></i> Ingresos Almacén</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-plus-circle"></i> Ingresos Almacén</h2>
						<ul>
							<li>
                                <div class="cita mt-2">
                                    {!! Form::open(['route'=>'admin.ingresos.change']) !!}
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
							{{-- @can('admin.rcompras.create')
							<li>
								<a href="{{ route('admin.rcompras.create') }}">
									Agregar registro
								</a>
							</li>
							@endcan --}}
						</ul>
					</div>
					<div class="inside">
						{{-- {{ dd($srcompras) }} --}}
						<table id= "grid" class="table table-hover table-sm">
							<thead>
								<tr>
									<th width="10%">Fecha</th>
									<th width="10%">Moneda</th>
									<th width="10%">Número</th>
									<th width="5%">TD</th>
									<th width="45%">Proveedor</th>
									<th class="text-right" width="10%">Total</th>
									<th width="10%"></th>
								</tr>
							</thead>
							<tbody>
								@foreach($rcompras as $rcompra)
								<tr>
									<td>{{ $rcompra->fecha }}</td>
									<td>{{ $rcompra->monedas->nombre }}</td>
									<td>{{ numDoc($rcompra->serie,$rcompra->numero) }}</td>
									<td>{{ $rcompra->tipocomprobante_codigo }}</td>
									<td>{{ $rcompra->cliente->razsoc }}</td>
									<td class="text-right">{{ number_format($rcompra->afecto+$rcompra->otros,2) }}</td>
									<td>
										<div class="opts">
											@can('admin.ingresos.edit')
											<a class="" href="{{ route('admin.ingresos.edit',$rcompra) }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
											@endcan
											<a class="" href="{{ route('admin.pdf.ingresos',$rcompra) }}" target="_blank" datatoggle="tooltip" data-placement="top" title="Imprimir"><i class="fas fa-print"></i></a>
											{{-- @can('admin.rcompras.destroy')
											<form action="{{ route('admin.rcompras.destroy',$rcompra) }}" method="POST" class="formulario_eliminar">
												@csrf
												@method('delete')
												<button type="submit" datatoggle="tooltip" data-placement="top" title="Eliminar">
													<i class="fas fa-trash-alt"></i>
												</button>
											</form>
                                            @endcan --}}
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
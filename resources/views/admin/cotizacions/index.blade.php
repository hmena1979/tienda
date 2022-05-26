{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Cotizaciones')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.cotizacions.index') }}"><i class="fas fa-file-alt"></i> Cotizaciones</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-file-alt"></i> Cotizaciones</h2>
						<ul>
							<li>
                                <div class="cita mt-2">
                                    {{-- {!! Form::open(['route'=>'admin.cotizacions.change']) !!} --}}
                                    <div class="input-group tamvar">
                                        {!! Form::select('mes',getMeses(),substr($periodo,0,2),['class'=>'custom-select']) !!}
                                        {!! Form::text('año', substr($periodo,2,4), ['class'=>'form-control','maxlength'=>'4','autocomplete'=>'off']) !!}
                                        <div class="input-group-append">
                                            {!! Form::submit('Mostar', ['class'=>'btn btn-convertir']) !!}
                                        </div>
                                        
                                    </div>
                                    {{-- {!! Form::close() !!} --}}
                                </div>
                            </li>
							@can('admin.cotizacions.create')
							<li>
								<a href="{{ route('admin.cotizacions.create') }}">
									Agregar registro
								</a>
							</li>
							@endcan
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
									<th width="45%">Proveedor</th>
									<th class="text-right" width="10%">Total</th>
									<th width="10%"></th>
								</tr>
							</thead>
							<tbody>
								@foreach($cotizacions as $cotizacion)
								<tr>
									<td>{{ $cotizacion->fecha }}</td>
									<td>{{ $cotizacion->moneda }}</td>
									<td>{{ $cotizacion->numero }}</td>
									<td>{{ $cotizacion->cliente->razsoc }}</td>
									<td class="text-right">{{ number_format($cotizacion->total,2) }}</td>
									<td>
										<div class="opts">
											@can('admin.cotizacions.edit')
											<a class="" href="{{ route('admin.cotizacions.edit',$cotizacion) }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
											@endcan
											@can('admin.cotizacions.destroy')
											<form action="{{ route('admin.cotizacions.destroy',$cotizacion) }}" method="POST" class="formulario_eliminars">
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
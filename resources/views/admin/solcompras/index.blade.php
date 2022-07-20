{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Solicitud de Compras')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.solcompras.index') }}"><i class="fas fa-file-archive"></i> Solicitud de Compras</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-file-archive"></i> Solicitud de Compras</h2>
						<ul>
							<li>
                                <div class="cita mt-2">
									{!! Form::open(['route'=>'admin.solcompras.change']) !!}
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
							@can('admin.solcompras.create')
							<li>
								<a href="{{ route('admin.solcompras.create') }}">
									Agregar registro
								</a>
							</li>
							@endcan
						</ul>
					</div>
					<div class="inside">
						<table id= "grid" class="table table-hover table-sm">
							<thead>
								<tr>
									<th width="10%">N°</th>
									<th width="10%">Fecha</th>
									<th width="20%">Usuario</th>
									<th width="15%">Observaciones</th>
									<th width="10%">Estado</th>
									<th width="10%"></th>
								</tr>
							</thead>
							<tbody>
								@foreach($solcompras as $solcompra)
								<tr class="{{ $colores[$solcompra->estado] }}">
									<td>{{ str_pad($solcompra->id, 6, '0', STR_PAD_LEFT) }}</td>
									<td>{{ $solcompra->fecha }}</td>
									<td>{{ $solcompra->user->name }}</td>
									<td>{{ $solcompra->observaciones }}</td>
									<td>{{ $estados[$solcompra->estado] }}</td>
									<td>
										<div class="opts">
											@can('admin.solcompras.edit')
											<a class="" href="{{ route('admin.solcompras.edit',$solcompra) }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
											@endcan
											@can('admin.solcompras.destroy')
											<form action="{{ route('admin.solcompras.destroy',$solcompra) }}" method="POST" class="formulario_eliminars">
												@csrf
												@method('delete')
												<button type="submit" datatoggle="tooltip" data-placement="top" title="Eliminar">
													<i class="fas fa-trash-alt"></i>
												</button>
											</form>
                                            @endcan
											<a class="" href="{{ route('admin.pdf.pedido',$solcompra) }}" target="_blank" datatoggle="tooltip" data-placement="top" title="Imprimir">
												<i class="fas fa-print"></i>
											</a>
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
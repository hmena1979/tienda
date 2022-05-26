{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Pedidos')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.pedidos.index') }}"><i class="fas fa-file-archive"></i> Pedidos</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-file-archive"></i> Pedidos</h2>
						<ul>
							<li>
                                <div class="cita mt-2">
                                    <div class="input-group tamvar">
                                        {!! Form::select('mes',getMeses(),substr($periodo,0,2),['class'=>'custom-select']) !!}
                                        {!! Form::text('año', substr($periodo,2,4), ['class'=>'form-control','maxlength'=>'4','autocomplete'=>'off']) !!}
                                        <div class="input-group-append">
                                            {!! Form::submit('Mostar', ['class'=>'btn btn-convertir']) !!}
                                        </div>
                                    </div>
                                </div>
                            </li>
							@can('admin.pedidos.create')
							<li>
								<a href="{{ route('admin.pedidos.create') }}">
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
									<th width="10%">Fecha</th>
									<th width="20%">Usuario</th>
									<th width="25%">Observaciones</th>
									<th width="25%">Logística</th>
									<th width="10%">Estado</th>
									<th width="10%"></th>
								</tr>
							</thead>
							<tbody>
								@foreach($pedidos as $pedido)
								<tr class="{{ $colores[$pedido->estado] }}">
									<td>{{ $pedido->fecha }}</td>
									<td>{{ $pedido->user->name }}</td>
									<td>{{ $pedido->observaciones }}</td>
									<td>{{ $pedido->obslogistica }}</td>
									<td>{{ $estados[$pedido->estado] }}</td>
									<td>
										<div class="opts">
											@can('admin.pedidos.edit')
											<a class="" href="{{ route('admin.pedidos.edit',$pedido) }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
											@endcan
											@can('admin.pedidos.destroy')
											<form action="{{ route('admin.pedidos.destroy',$pedido) }}" method="POST" class="formulario_eliminars">
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
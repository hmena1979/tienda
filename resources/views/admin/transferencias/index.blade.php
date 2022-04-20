{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Tranferencias Entre Cuentas')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.transferencias.index') }}"><i class="fas fa-money-bill-wave"></i> Tranferencias Entre Cuentas</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-money-bill-wave"></i> Tranferencias Entre Cuentas</h2>
						<ul>
							<li>
                                <div class="cita mt-2">
                                    {!! Form::open(['route'=>'admin.transferencias.change']) !!}
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
							@can('admin.transferencias.create')
							<li>
								<a href="{{ route('admin.transferencias.create') }}">
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
									<th width="30%">Cuenta Cargo</th>
									<th width="30%">Cuenta Abono</th>
									<th width="10%">Soles</th>
									<th width="10%">Dolares</th>
									<th width="10%"></th>
								</tr>
							</thead>
							<tbody>
								@foreach($transferencias as $transferencia)
								<tr>
									<td>{{ $transferencia->fecha }}</td>
									<td>{{ $transferencia->cargo->nombre }}</td>
									<td>{{ $transferencia->abono->nombre }}</td>
									<td>{{ number_format($transferencia->montopen,2) }}</td>
									<td>{{ number_format($transferencia->montousd,2) }}</td>
									<td>
										<div class="opts">
											@can('admin.transferencias.edit')
											<a class="" href="{{ route('admin.transferencias.edit',$transferencia) }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
											@endcan
											@can('admin.transferencias.destroy')
											<form action="{{ route('admin.transferencias.destroy',$transferencia) }}" method="POST" class="formulario_eliminars">
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
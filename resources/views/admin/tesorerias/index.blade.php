{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Caja y Bancos')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.tesorerias.index') }}"><i class="fas fa-funnel-dollar"></i> Caja y Bancos</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
        <div class="row cuentas">
            <div class="col-md-12">
                @foreach($cuentas as $cta)
                    @if($cta->id == $cuenta)
                    <a class='btn btn-convertir' href="{{ route('admin.tesorerias.index',[$periodo,$cta->id]) }}">{{ $cta->nombre }}</a>
                    @else
                    <a class='btn btn-desactivado' href="{{ route('admin.tesorerias.index',[$periodo,$cta->id]) }}">{{ $cta->nombre }}</a>		
                    @endif
                @endforeach
            </div>
        </div>
		<div class="row mtop16">
            {{-- <div class="col-md-1">
                @foreach($cuentas as $cta)
                    @if($cta->id == $cuenta)
                    <a class='btn btn-primary btn-block' href="{{ route('admin.tesorerias.index',[$periodo,$cta->id]) }}">{{ $cta->nombre }}</a>
                    @else
                    <a class='btn btn-outline-primary btn-block' href="{{ route('admin.tesorerias.index',[$periodo,$cta->id]) }}">{{ $cta->nombre }}</a>		
                    @endif
                @endforeach
            </div> --}}
			<div class="col-md-12">
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-funnel-dollar"></i> Caja y Bancos</h2>
						<ul>
							<li>
                                {!! Form::open(['route'=>'admin.tesorerias.change']) !!}
                                <div class="input-group tamvar">
                                    {!! Form::select('mes',getMeses(),substr($periodo,0,2),['class'=>'custom-select']) !!}
                                    {!! Form::text('año', substr($periodo,2,4), ['class'=>'form-control','maxlength'=>'4','autocomplete'=>'off']) !!}
                                    {!! Form::hidden('cuenta', $cuenta) !!}
                                    <div class="input-group-append">
                                        {!! Form::submit('Mostar', ['class'=>'btn btn-convertir']) !!}
                                    </div>
                                    
                                </div>
                                {!! Form::close() !!}
                            </li>
							@can('admin.tesorerias.create')
							<li>
								<a href="{{ route('admin.tesorerias.create', $cuenta) }}">
									Agregar registro
								</a>
							</li>
							@endcan
							
							{{-- <li>
								<a class="mt-1" href="#">
									Filtrar <i class="fas fa-angle-down"></i></a>
								<ul class="shadow">
									<li><a href="{{ url('/admin/usuarios/1') }}"><i class="fas fa-eye"></i> Activos</a></li>
									<li><a href="{{ url('/admin/usuarios/2') }}"><i class="fas fa-eye-slash"></i> No Activos</a></li>
									<li><a href="{{ url('/admin/usuarios/all') }}"><i class="fas fa-globe"></i> Todos</a></li>
								</ul>
							</li> --}}
						</ul>
					</div>
                    
					<div class="inside">
						<table id= "grid" class="table table-responsive-sm table-hover table-sm">
							<thead>
								<tr>
									<th width="10%">Fecha</th>
									<th width="15%">Medio Pago</th>
									<th width="10%">N.Operación</th>
									<th width="40%">Glosa</th>
									<th width="8%">Abono</th>
									<th width="8%">Cargo</th>
									<th width="9%"></th>
								</tr>
							</thead>
							<tbody>
								@foreach($tesorerias as $tesoreria)
                                {{-- {{ dd($tesoreria) }} --}}
								<tr>
									<td>{{ $tesoreria->fecha }}</td>
									<td>{{ mb_substr($tesoreria->mediopagos->nombre,0,18) }}</td>
									<td>{{ $tesoreria->numerooperacion }}</td>
									<td>{{ mb_substr($tesoreria->glosa,0,45) }}</td>
									<td>
										{{ $tesoreria->tipo==1?number_format($tesoreria->monto,2):'' }}
									</td>
									<td>
										{{ $tesoreria->tipo==2?number_format($tesoreria->monto,2):'' }}
									</td>
									<td>
										<div class="opts">
											@if ($tesoreria->edit == 1)
											@can('admin.tesorerias.edit')
											<a class="" href="{{ route('admin.tesorerias.edit',$tesoreria) }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
											@endcan
											@can('admin.tesorerias.destroy')
											<form action="{{ route('admin.tesorerias.destroy',$tesoreria) }}" method="POST" class="formulario_eliminars">
												@csrf
												@method('delete')
												<button type="submit" datatoggle="tooltip" data-placement="top" title="Eliminar">
													<i class="fas fa-trash-alt"></i>
												</button>
											</form>
                                            @endcan
											@endif
											<a class="" href="{{ route('admin.pdf.tesoreria',$tesoreria) }}" target="_blank" datatoggle="tooltip" data-placement="top" title="Imprimir"><i class="fas fa-print"></i></a>
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
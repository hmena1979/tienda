{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Orden de Compra')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.ordcompras.index') }}"><i class="fas fa-file-import"></i> Orden de Compra</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-file-import"></i> Orden de Compra</h2>
						<ul>
							<li>
                                <div class="cita mt-2">
                                    {!! Form::open(['route'=>'admin.ordcompras.change']) !!}
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
							@can('admin.ordcompras.create')
							<li>
								<a href="{{ route('admin.ordcompras.create') }}">
									Agregar registro
								</a>
							</li>
							<li>
								<a href="{{ route('admin.ordcompras.busproducto') }}"datatoggle="tooltip" data-placement="top" title="Buscar"><i class="fas fa-window-restore"></i></a>
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
								@foreach($ordcompras as $ordcompra)
								<tr>
									<td>{{ $ordcompra->fecha }}</td>
									<td>{{ $ordcompra->moneda }}</td>
									<td>{{ str_pad($ordcompra->id, 5, '0', STR_PAD_LEFT) }}</td>
									<td>{{ $ordcompra->cliente->razsoc }}</td>
									<td class="text-right">{{ number_format($ordcompra->total*(1+(session('igv')/100)),2) }}</td>
									<td>
										<div class="opts">
											@can('admin.ordcompras.edit')
											<a class="" href="{{ route('admin.ordcompras.edit',$ordcompra) }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
											@endcan
											@can('admin.ordcompras.destroy')
											<form action="{{ route('admin.ordcompras.destroy',$ordcompra) }}" method="POST" class="formulario_eliminars">
												@csrf
												@method('delete')
												<button type="submit" datatoggle="tooltip" data-placement="top" title="Eliminar">
													<i class="fas fa-trash-alt"></i>
												</button>
											</form>
                                            @endcan
											<a class="" href="{{ route('admin.pdf.ordcompra',$ordcompra) }}" target="_blank" datatoggle="tooltip" data-placement="top" title="Imprimir"><i class="fas fa-print"></i></a>
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
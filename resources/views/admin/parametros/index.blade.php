{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Parametros')
@php
	$aleatorio = '';
	for ($i = 1; $i <= 10; $i++) {
		$aleatorio .= rand(1,80) . ' - ';
	}
@endphp

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.parametros.index') }}"><i class="fas fa-cog"></i> Parametros</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row mtop16">
            <div class="col-md-2">
                @can('admin.parametros.empresaCreate')
                @if ($param->empresa == 1)
                <a class='btn btn-desactivado-sinalto btn-block' datatoggle="tooltip" data-placement="top" title="Agregar Empresa" 
                    href="{{ route('admin.parametros.empresaCreate') }}">
                    <b><i class="fas fa-plus"></i> Empresa</b>
                </a>
                @endif
                @endcan
                @foreach($empresas as $emp)
                    @if($emp->id == $empresa)
                    <a class='btn btn-convertir-sinalto btn-block' href="{{ route('admin.parametros.index',$emp->id) }}">{{ $emp->razsoc }}</a>
                    @else
                    <a class='btn btn-desactivado-sinalto btn-block' href="{{ route('admin.parametros.index',$emp->id) }}">{{ $emp->razsoc }}</a>		
                    @endif
                @endforeach
            </div>
			<div class="col-md-10">
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title">
                            <i class="fas fa-cog"></i> EMPRESA: <strong>{{ $tit->ruc.' - '. $tit->razsoc}}</strong>
                            <span class="ml-2">
                                <a class="txt-convertir-sinfondo" href="{{ route('admin.parametros.empresaEdit',$empresa) }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
                            </span>
                        </h2>
						<ul>
                            @if ($param->sede == 1)
							@can('admin.parametros.sedeCreate')
							<li>
								<a href="{{ route('admin.parametros.sedeCreate', $empresa) }}">
									<i class="fas fa-plus"></i> Sede
								</a>
							</li>
							@endcan                                
                            @endif
						</ul>
					</div>
                    
					<div class="inside">
						{{$aleatorio;}}
						<table id= "grid" class="table table-hover table-sm">
							<thead>
								<tr>
									<th width="50%">Nombre</th>
									<th width="40%">Periodo</th>
									<th width="10%"></th>
								</tr>
							</thead>
							<tbody>
								@foreach($sedes as $sede)
                                {{-- {{ dd($tesoreria) }} --}}
								<tr>
									<td>{{ $sede->nombre }}</td>
									<td>{{ $sede->periodo }}</td>
									<td>
										<div class="opts">
											@can('admin.parametros.sedeEdit')
											<a class="" href="{{ route('admin.parametros.sedeEdit',$sede) }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
											@endcan
											{{-- @can('admin.tesorerias.destroy')
											<form action="{{ route('admin.tesorerias.destroy',$tesoreria) }}" method="POST" class="formulario_eliminars">
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
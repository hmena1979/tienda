{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Categorías')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/categorias') }}"><i class="fas fa-folder-open"></i> Categorías</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
            <div class="col-md-2 text-center mbottom16">
                @foreach(getModulosArray() as $m => $k)
                @if($m == $module)
                <a class='btn btn-primary btn-block' href="{{ url('/admin/categorias/'.$m) }}">{{ $k }}</a>
                @php($nombremodulo = $k)
                @else
                <a class='btn btn-outline-primary btn-block' href="{{ url('/admin/categorias/'.$m) }}">{{ $k }}</a>		
                @endif
                @endforeach
            </div>
			<div class="col-md-10">
				<div class="panelprin shadow">
					<div class="headercontent">
                    <h2 class="title"><i class="fas fa-folder-open"></i> Categorías: <strong>{{ $nombremodulo }}</strong></h2>
						<ul>
                            @can('admin.categorias.create')
							<li>
								{{-- <a href="{{ url('/admin/categoria/add/'.$module) }}"> --}}
								<a class="mt-2" href="{{ route('admin.categorias.create', $module) }}">
									Agregar Registro
								</a>
                            </li>
                            @endcan
						</ul>
					</div>
					<div class="inside">
                        <table id= "grid" class="table table-hover table-sm">
							<thead>
								<tr>
									<th width="20%">{{ $titulo }}</th>
									<th width="70%">Nombre</th>
									<th width="10%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cats as $cat)
								<tr>
                                    <td>{{ $cat->codigo }}</td>
									<td>{{ $cat->nombre }}</td>
									<td>
										<div class="opts">
                                            @can('admin.categorias.edit')
											<a href="{{ route('admin.categorias.edit',$cat) }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
                                            @endcan
                                            @can('admin.categorias.destroy')
											<form action="{{ route('admin.categorias.destroy',$cat) }}" method="POST" class="formulario_eliminars">
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

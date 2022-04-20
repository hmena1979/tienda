{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Productos | Servicios')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.productos.index') }}"><i class="fas fa-window-restore"></i> Productos | Servicios</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-window-restore"></i> Productos | Servicios</h2>
						<ul>
							@can('admin.productos.create')
                            @if($principal == 1)
							<li>
								<a href="{{ route('admin.productos.create') }}">
									Agregar registro
								</a>
							</li>
                            @endif
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
						<table id= "prodw" class="table table-hover table-sm">
							<thead>
								<tr>
									<th width="40%">Nombre</th>
									<th width="15%">U.Medida</th>
									<th class="text-center" width="10%">Stock</th>
									<th class="text-center" width="10%">Precio S/</th>
									<th width="15%">Grupo</th>
									<th width="10%"></th>
								</tr>
							</thead>
							{{-- <tbody>
								@foreach($productos as $producto)
								<tr>
									<td>{{ $producto->nombre }}</td>
									<td>{{ $producto->umedida->codigo_nombre }}</td>
									<td>
										@if (empty($producto->stock))
										-
										@else
										{{ number_format($producto->stock,2) }}
										@endif
									</td>
									<td>
										@if (empty($producto->preventa_pen))
										-
										@else
										{{ number_format($producto->preventa_pen,2) }}
										@endif
									</td>
									<td>{{ $producto->grupo == 1 ? 'Producto' : 'Servicio' }}</td>
									<td>
										<div class="opts">
											@can('admin.productos.edit')
											<a class="" href="{{ route('admin.productos.edit',$producto) }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
											@endcan
											@can('admin.productos.destroy')
											<form action="{{ route('admin.productos.destroy',$producto) }}" method="POST" class="formulario_eliminars">
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
							</tbody> --}}
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
		$('#prodw').DataTable({
			"processing": true,
            "serverSide": true,
            "paging": true,
            "ordering": true,
            "info": true,
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
                    "</select> Registros"
			},
			"ajax": "{{url('/admin/productos/registro')}}",
			"columnDefs":[
				{
					"targets": 2,
					"className": "text-center"
				},
				{
					"targets": 3,
					"className": "text-center"
				}
			],
            "columns": [
                {data: 'nombre'},
                {data: 'umedida',
						render:function(data,type,row){
							return data['codigo_nombre'];
						}
				},
                {data: 'stock',
						render:function(data,type,row){
							if(Empty(data)){
								return '-';
							}else{
								return NumberFormat(data);
							}
						}
				},
                {data: 'preventa_pen',
						render:function(data,type,row){
							if(Empty(data)){
								return '-';
							}else{
								return NumberFormat(data);
							}
						}
				},
                {data: 'grupo',
						render:function(data,type,row){
							switch (data) {
								case 1:
									return 'Producto';
								case 2:
									return 'Servicio';
								case 3:
									return 'Materia Prima';
							}
							// if(data == 1){
							// 	return 'Producto';
							// }else{
							// 	return 'Servicio';
							// }
						}
				},
				{data: 'btn'}
                ]
			
            });
	});
</script>
@endsection
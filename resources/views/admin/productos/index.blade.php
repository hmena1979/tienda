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
						</ul>
					</div>
					<div class="inside">
						<table id= "prodw" class="table table-hover table-sm">
							<thead>
								<tr>
									<th width="40%">Nombre</th>
									<th width="15%">U.Medida</th>
									<th class="text-center" width="10%">Tipo de Producto</th>
									<th width="10%"></th>
								</tr>
							</thead>
							<tbody></tbody>
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
			"ajax": "{{route('admin.productos.registro')}}",
            "columns": [
                {data: 'nombre'},
                {data: 'umedida.nombre'},
                {data: 'tipoproducto.nombre'},
				{data: 'btn'}
                ]
            });
	});
</script>
@endsection
{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Proveedor|Cliente')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.clientes.index') }}"><i class="fas fa-address-card"></i> Proveedor | Cliente</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-address-card"></i> Proveedor | Cliente</h2>
						<ul>
							@can('admin.clientes.create')
							<li>
								{{-- <a href="{{ url('/admin/categoria/add/'.$module) }}"> --}}
								<a href="{{ route('admin.clientes.create') }}">
									Agregar Registro
								</a>
                            </li>
                            @endcan
							{{--  
							<li>
								<a href="#" id='btn_search'>
									Buscar <i class="fas fa-search"></i>
								</a>
							</li>
							--}}
						</ul>
					</div>
					<div class="inside">
						<table id= "pacw" class="table table-hover table-sm">
							<thead>
								<tr>
									<th width="10%">N° Doc</th>
									<th width="50%">Nombre</th>
                                    <th width="10%">Celular</th>
                                    <th width="20%">e-mail</th>
									<th width="10%"></th>
								</tr>
							</thead>
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

@section('script')
<script>
	$(document).ready(function(){
        $('#pacw').DataTable({
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
			"ajax": "{{url('/admin/clientes/registro')}}",
            "columns": [
                {data: 'numdoc'},
                {data: 'razsoc'},
                {data: 'celular'},
                {data: 'email'},
				{data: 'btn'}
                ]
            });
        });
</script>
@endsection
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
							<li>
								<button class="btn btn-convertir" type="button" id="btnprint" data-toggle="modal" data-target="#print" onclick="limpia()"><i class="fas fa-print"></i></button>
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
						<!-- Modal -->
                        <div class="modal fade" id="print" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
									<div class="modal-header">
										<strong>Tipo de Producto</strong>
									</div>
									<div class="modal-body">
										<div class="row no-gutters">
											<div class="col-md-2">
												{!! Form::select('tipo',[1=>'Todos',2=>'Uno'],1,['class'=>'custom-select','id' => 'tipo']) !!}
											</div>
											<div class="col-md-10">
												{!! Form::select('tipoproducto_id',$tipoproductos,null,['class'=>'custom-select','id' => 'tipoproducto_id','disabled']) !!}
											</div>
										</div>
									</div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-convertir" id='btnimp'>Listar</button>
                                        <button type="button" class="btn btn-convertir" data-dismiss='modal'>Salir</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Fin Modal -->
					</div>				
				</div>
			</div>

		</div>		
	</div>

@endsection

@section('script')
<script>
	var url_global='{{url("/")}}';
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
                {data: 'umedida.nombre',orderable:false},
                {data: 'tipoproducto.nombre',orderable:false},
				{data: 'btn'}
                ]
            });
		
		$('#tipo').change(function(){
			if (this.value == 1) {
				$('#tipoproducto_id').prop('disabled', true);
			} else {
				$('#tipoproducto_id').prop('disabled', false);
			}
		});
		
		$('#btnimp').click(function(){
			let tipo = $('#tipo').val();
			let tipoproducto_id = $('#tipoproducto_id').val();
			let url = url_global + '/admin/pdf/' + tipo + '/' + tipoproducto_id +'/productos';
			window.open(url,'_blank');
			$('#print').modal('hide')
		});
	});
</script>
@endsection
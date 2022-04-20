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
				{!! Form::model($producto,['route'=>['admin.productos.update',$producto],'method'=>'put']) !!}
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-window-restore"></i> Productos | Servicios</h2>
						<ul>
							<li>{!! Form::submit('Guardar', ['class'=>'btn btn-convertir mt-2', 'id' => 'guardar']) !!}</li>
						</ul>
					</div>
					<div class="inside">
						{{-- {!! Form::open(['url'=>'/admin/categoria/add/'.$module]) !!} --}}
						<div class="row">
							<div class="col-md-2 form-group">
                                {!! Form::label('grupo', 'Grupo:') !!}
								{!! Form::select('grupo',[1=>'PRODUCTOS',2=>'SERVICIOS'],null,['class'=>'custom-select','disabled']) !!}
							</div>
							<div class="col-md-3 form-group">
                                {!! Form::label('tipoproducto_id', 'Tipo:') !!}
								{!! Form::select('tipoproducto_id',$tipoproductos,null,['class'=>'custom-select','disabled']) !!}
							</div>
							<div class="col-md-5 form-group">
								{!! Form::label('nombre', 'Nombre:') !!}
								{!! Form::text('nombre', null, ['class'=>'form-control mayuscula','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-2 form-group">
								{!! Form::label('umedida_id', 'Unidad Medida:') !!}
								{!! Form::select('umedida_id',$umedidas,null,['class'=>'custom-select','placeholder'=>'']) !!}
							</div>
						</div>
					</div>				
				</div>
				{!! Form::close() !!}
			</div>
		</div>
		<div class="row mtop16">
			<div class="col-md-12">
				<div class="panelprin shadow">
					<div class="inside">
						<div class="row">
							<div class="col-md-12">
								<div class="row">
									<div class="col-md-5 ">
										<div class="row">
											<div class="col-md-5 form-group">
												{!! Form::hidden('tipo',1,['id'=>'tipo']) !!}
												{!! Form::hidden('id',null,['id'=>'id']) !!}
												{!! Form::hidden('producto_id',$producto->id,['id'=>'producto_id']) !!}
												{!! Form::label('marca_id', 'Marca:') !!}
												{!! Form::select('marca_id',$marca,1,['class'=>'custom-select']) !!}
		
											</div>
											<div class="col-md-3 form-group ">
												{!! Form::label('talla_id', 'Talla:') !!}
												{!! Form::select('talla_id',$talla,1,['class'=>'custom-select']) !!}
											</div>
											<div class="col-md-4 form-group ">
												{!! Form::label('color_id', 'Color:') !!}
												{!! Form::select('color_id',$color,1,['class'=>'custom-select']) !!}
											</div>
										</div>
									</div>
									<div class="col-md-3">
										<div class="row">
											<div class="col-md-3 form-group">
												{!! Form::label('afecto', 'Afecto:') !!}
												{!! Form::select('afecto',[1=>'SI',2=>'NO'],1,['class'=>'custom-select']) !!}
											</div>
											<div class="col-md-5 form-group">
												{!! Form::label('preventa', 'Precio:',['title'=>'Precio de Venta, Incl. Impuestos']) !!}
												{!! Form::text('preventa', null, ['class'=>'form-control decimal','autocomplete'=>'off','title'=>'Precio de Venta, Incl. Impuestos']) !!}
											</div>
											<div class="col-md-4 form-group">
												{!! Form::label('preventamin', 'P. Mínimo:',['title'=>'Precio de Venta Mínimo, Incl. Impuestos']) !!}
												{!! Form::text('preventamin', null, ['class'=>'form-control decimal','autocomplete'=>'off','title'=>'Precio de Venta Mínimo, Incl. Impuestos']) !!}
											</div>
										</div>
									</div>
									<div class="col-md-4">
										<div class="row">
											<div class="col-md-3 form-group producto">
												{!! Form::label('lotevencimiento', 'Vence:',['title'=>'Controla Vencimiento y Lote']) !!}
												{!! Form::select('lotevencimiento',[1=>'SI',2=>'NO'],2,['class'=>'custom-select','title'=>'Controla Vencimiento y Lote']) !!}
											</div>
											<div class="col-md-3 form-group producto">
												{!! Form::label('ctrlstock', 'Crtl.Stock:',['title'=>'Controla Stock']) !!}
												{!! Form::select('ctrlstock',[1=>'SI',2=>'NO'],1,['class'=>'custom-select','title'=>'Controla Stock']) !!}
											</div>
											<div class="col-md-4 form-group producto">
												{!! Form::label('stockmin', 'Stock Mínimo:') !!}
												{!! Form::text('stockmin', 0, ['class'=>'form-control','autocomplete'=>'off']) !!}
											</div>
											<div class="col-md-2">
												{{-- {!! Form::submit('+', ['class'=>'btn btn-convertir mtop25', 'id' => 'agregar']) !!} --}}
												<button type="button" id='agregar' class="btn btn-convertir mtop25">+</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="tablaao" id="tdetprod">
									{{-- @include('admin.colaboradors.antocupacional')    --}}
								</div>
							</div>
						</div>
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
    var url_global='{{url("/")}}';

    $(document).ready(function(){
		// alert('Hola');
		verdp();

        if($('#grupo').val() == 1){
            $('.producto').show();
        }else{
            $('.producto').hide();
        }

        $('#guardar').click(function(){
            $('#tipoproducto_id').disabled = false;
            $('#grupo').disabled = false;
        });

        $('#agregar').click(function(){
			if($('#preventa').val().length == 0 || $('#preventa').val() == 0){
				Swal.fire({
					icon:'error',
					title:'Error',
					text:'Ingrese precio de venta'
				});
				return true;
			}
			if($('#preventamin').val().length == 0 || $('#preventamin').val() == 0){
				Swal.fire({
					icon:'error',
					title:'Error',
					text:'Ingrese precio de venta mínimo'
				});
				return true;
			}
			var detp = {
				'tipo' : $('#tipo').val(),
				'id' : $('#id').val(),
				'producto_id' : $('#producto_id').val(),
				'marca_id' : $('#marca_id').val(),
				'talla_id' : $('#talla_id').val(),
				'color_id' : $('#color_id').val(),
				'afecto' : $('#afecto').val(),
				'ctrlstock' : $('#ctrlstock').val(),
				'preventa' : $('#preventa').val(),
				'preventamin' : $('#preventamin').val(),
				'lotevencimiento' : $('#lotevencimiento').val(),
				'stockmin' : $('#stockmin').val()
			};
			var envio = JSON.stringify(detp);
			$.get(url_global+"/admin/productos/"+envio+"/adddp/",function(response){
                verdp();
            });
			$('#tipo').val(1);
			$('#id').val(null);
			$('#marca_id').val(1);
			$('#talla_id').val(1);
			$('#color_id').val(1);
			$('#afecto').val(1);
			$('#ctrlstock').val(1);
			$('#preventa').val(null);
			$('#preventamin').val(null);
			$('#lotevencimiento').val(2);
			$('#stockmin').val(0);
        });
    });

	function verdp(){
        var producto = $('#producto_id').val();
        $.get(url_global+"/admin/productos/"+producto+"/tabla_dp/",function(response){
            $('#tdetprod').empty();
            $('#tdetprod').html(response);
        });
    }

	function editdp(id){
		$.get(url_global+"/admin/productos/"+id+"/showdetp/",function(response){
			$('#tipo').val(2);
			$('#id').val(response['id']);
			$('#marca_id').val(response['marca_id']);
			$('#talla_id').val(response['talla_id']);
			$('#color_id').val(response['color_id']);
			$('#afecto').val(response['afecto']);
			$('#ctrlstock').val(response['ctrlstock']);
			$('#preventa').val(response['preventa']);
			$('#preventamin').val(response['preventamin']);
			$('#lotevencimiento').val(response['lotevencimiento']);
			$('#stockmin').val(response['stockmin']);
        });
	}

	function destroydp(id){
		Swal.fire({
            title: 'Está Seguro de Eliminar el Registro?',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '¡Si, eliminar!',
            cancelButtonText: 'Cancelar'
            }).then((result) => {
            if (result.value) {
                // this.submit();
				$.get(url_global+"/admin/productos/"+id+"/destroydetp/",function(response){
					if(response == 1){
						Swal.fire({
							icon:'success',
							title:'Eliminado',
							text:'Registro Eliminado'
						});
					}
					if(response == 2){
						Swal.fire({
							icon:'error',
							title:'Error',
							text:'El Registro no puede ser eliminado'
						});
					}
				});
            }
            })
	}
	
</script>
@endsection
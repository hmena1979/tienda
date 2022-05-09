@extends('admin.master')
@section('title','Transportistas')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.transportistas.index') }}"><i class="fas fa-truck-moving"></i> Transportistas</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
                    {!! Form::model($transportista,['route'=>['admin.transportistas.update',$transportista],'method'=>'put']) !!}
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-truck-moving"></i> Transportistas</h2>
                        <ul>
                            {!! Form::submit('Guardar', ['class'=>'btn btn-convertir mt-2']) !!}
                        </ul>
                    </div>
					<div class="inside">
                        {!! Form::hidden('empresa_id', session('empresa')) !!}
						<div class="row">
							<div class="col-md-2 form-group">
                                {!! Form::hidden('id', null, ['id'=>'id']) !!}
								{!! Form::label('ruc', 'RUC:') !!}
								{!! Form::text('ruc', null, ['class'=>'form-control numero','maxlength'=>'11','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-6 form-group">
								{!! Form::label('nombre', 'Nombre:') !!}
								{!! Form::text('nombre', null, ['class'=>'form-control mayuscula','maxlength'=>'50','autocomplete'=>'off']) !!}
							</div>
						</div>
                        
					</div>				
                    {!! Form::close() !!}
				</div>
			</div>
		</div>
        <div class="row mtop16">
            <div class="col-md-6">
                <div class="panelprin shadow">
                    <div class="headercontent">
                        <h2 class="title"><i class="far fa-address-card"></i> Choferes</h2>
                        <ul>
                            <button type="button" id='agregar' class="btn btn-convertir mt-2">Agregar</button>
                        </ul>
                    </div>
                    <div class="inside">
                        <div class="oculto mb-3" id="aedet">
                            <div class="row" id="aedet">
                                <div class="col-md-3 form-group">
                                    {!! Form::hidden('idd', null, ['id'=> 'idd']) !!}
                                    {!! Form::hidden('tipo', 1, ['id' => 'tipo']) !!}
                                    {!! Form::label('licencia', 'Licencia:') !!}
                                    {!! Form::text('licencia', null, ['class'=>'form-control mayuscula','maxlength'=>'15','autocomplete'=>'off']) !!}
                                </div>
                                <div class="col-md-6 form-group">
                                    {!! Form::label('nombredet', 'Nombre:') !!}
                                    {!! Form::text('nombredet', null, ['class'=>'form-control mayuscula','maxlength'=>'50','autocomplete'=>'off']) !!}
                                </div>
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button type="button" id='add' class="btn btn-block btn-convertir mtop20" datatoggle="tooltip" data-placement="top" title="Aceptar">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" id='cancel' class="btn btn-block btn-convertir mtop20" datatoggle="tooltip" data-placement="top" title="Descartar">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="detalles">
                            <div class="col-md-12">
                                <div id="tdetitem">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panelprin shadow">
                    <div class="headercontent">
                        <h2 class="title"><i class="fas fa-truck"></i> Cámaras</h2>
                        <ul>
                            <button type="button" id='agregarcamara' class="btn btn-convertir mt-2">Agregar</button>
                        </ul>
                    </div>
                    <div class="inside">
                        <div class="oculto mb-3" id="aedetcamara">
                            <div class="row" id="aedet">
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-8 form-group">
                                            {!! Form::hidden('iddcamara', null, ['id'=> 'iddcamara']) !!}
                                            {!! Form::hidden('tipocamara', 1, ['id' => 'tipocamara']) !!}
                                            {!! Form::label('marca', 'Marca:') !!}
                                            {!! Form::text('marca', null, ['class'=>'form-control mayuscula','maxlength'=>'50','autocomplete'=>'off']) !!}
                                        </div>
                                        <div class="col-md-4 form-group">
                                            {!! Form::label('placa', 'Placa:') !!}
                                            {!! Form::text('placa', null, ['class'=>'form-control mayuscula','maxlength'=>'15','autocomplete'=>'off']) !!}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8 form-group">
                                            {!! Form::label('protocolo', 'Protocolo:') !!}
                                            {!! Form::text('protocolo', null, ['class'=>'form-control mayuscula','maxlength'=>'25','autocomplete'=>'off']) !!}
                                        </div>
                                        <div class="col-md-4 form-group">
                                            {!! Form::label('capacidad', 'Capacidad:') !!}
                                            {!! Form::text('capacidad', null, ['class'=>'form-control decimal','maxlength'=>'15','autocomplete'=>'off']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button type="button" id='addcamara' class="btn btn-block btn-convertir mtop20" datatoggle="tooltip" data-placement="top" title="Aceptar">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" id='cancelcamara' class="btn btn-block btn-convertir mtop20" datatoggle="tooltip" data-placement="top" title="Descartar">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="detallescamara">
                            <div class="col-md-12">
                                <div id="tdetitemcamara">
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
    var tabladet = $(document).ready(function(){
        veritems();
        veritemscamara()
        $('#agregar').click(function(){
            $('#aedet').show();
            $('#detalles').hide();
            $('#idd').val($('#id').val());
            $('#tipo').val(1);
        });
        $('#agregarcamara').click(function(){
            $('#aedetcamara').show();
            $('#detallescamara').hide();
            $('#iddcamara').val($('#id').val());
            $('#tipocamara').val(1);
        });

        $('#add').click(function(){
            var det = {
				'tipo' : $('#tipo').val(),
				'id' : $('#idd').val(),
				'nombre' : $('#nombredet').val(),
				'licencia' : $('#licencia').val(),
			};
			var envio = JSON.stringify(det);
            $.get(url_global+"/admin/transportistas/"+envio+"/aedet/",function(response){
                if (response == 1) {
                    veritems();
                    $('#aedet').hide();
                    $('#detalles').show();
                    $('#nombredet').val(null);
                } else {
                    Swal.fire(
                        'Falló',
                        'Ya se encuentra registrado',
                        'error'
                        );
                }
            });
            
        });

        $('#addcamara').click(function(){
            var det = {
				'tipo' : $('#tipocamara').val(),
				'id' : $('#iddcamara').val(),
				'marca' : $('#marca').val(),
				'placa' : $('#placa').val(),
				'protocolo' : $('#protocolo').val(),
				'capacidad' : $('#capacidad').val(),
			};
			var envio = JSON.stringify(det);
            alert(envio);
            $.get(url_global+"/admin/transportistas/"+envio+"/aedetcamara/",function(response){
                if (response == 1) {
                    veritemscamara();
                    $('#aedetcamara').hide();
                    $('#detallescamara').show();
                    $('#marca').val(null);
                    $('#placa').val(null);
                    $('#protocolo').val(null);
                    $('#capacidad').val(null);
                } else {
                    Swal.fire(
                        'Falló',
                        'Ya se encuentra registrado',
                        'error'
                        );
                }
            });
            
        });

        $('#cancel').click(function(){
            $('#aedet').hide();
            $('#detalles').show();
            $('#marca').val(null);
            $('#placa').val(null);
            $('#protocolo').val(null);
            $('#capacidad').val(null);
        });

        $('#cancelcamara').click(function(){
            $('#aedetcamara').hide();
            $('#detallescamara').show();
            $('#marca').val(null);
            $('#placa').val(null);
        });
    });

    function veritems(){
        $.get(url_global+"/admin/transportistas/"+$('#id').val()+"/tablaitem/",function(response){
            $('#tdetitem').empty();
            $('#tdetitem').html(response);
        });
    }

    function veritemscamara(){
        $.get(url_global+"/admin/transportistas/"+$('#id').val()+"/tablaitemcamara/",function(response){
            $('#tdetitemcamara').empty();
            $('#tdetitemcamara').html(response);
        });
    }

    function edititem (id) {
        $('#aedet').show();
        $('#detalles').hide();
        $('#idd').val(id);
        $('#tipo').val(2);
        
        $.get(url_global+"/admin/transportistas/"+id+"/chofer/",function(response){
            $('#nombredet').val(response['nombre']);
            $('#licencia').val(response['licencia']);
        });
    }

    function edititemcamara (id) {
        $('#aedetcamara').show();
        $('#detallescamara').hide();
        $('#iddcamara').val(id);
        $('#tipocamara').val(2);
        
        $.get(url_global+"/admin/transportistas/"+id+"/camara/",function(response){
            $('#marca').val(response['marca']);
            $('#placa').val(response['placa']);
            $('#protocolo').val(response['protocolo']);
            $('#capacidad').val(response['capacidad']);
        });
    }

    function destroyitem(id){
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
				$.get(url_global+"/admin/transportistas/"+id+"/destroyitem/",function(response){
                    veritems();
                    Swal.fire({
                        icon:'success',
                        title:'Eliminado',
                        text:'Registro Eliminado'
                    });
				});                
            }
            })
	}

    function destroyitemcamara(id){
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
				$.get(url_global+"/admin/transportistas/"+id+"/destroyitemcamara/",function(response){
                    veritemscamara();
                    Swal.fire({
                        icon:'success',
                        title:'Eliminado',
                        text:'Registro Eliminado'
                    });
				});                
            }
            })
	}
</script>
@endsection
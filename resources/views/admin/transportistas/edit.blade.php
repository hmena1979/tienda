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
            <div class="col-md-12">
                <div class="panelprin shadow">
                    <div class="headercontent">
                        <h2 class="title"><i class="fas fa-chart-pie"></i> Choferes</h2>
                        <ul>
                            <button type="button" id='agregar' class="btn btn-convertir mt-2">Agregar</button>
                        </ul>
                    </div>
                    <div class="inside">
                        <div class="oculto mb-3" id="aedet">
                            <div class="row" id="aedet">
                                <div class="col-md-2 form-group">
                                    {!! Form::hidden('idd', null, ['id'=> 'idd']) !!}
                                    {!! Form::hidden('tipo', 1, ['id' => 'tipo']) !!}
                                    {!! Form::label('licencia', 'Licencia:') !!}
                                    {!! Form::text('licencia', null, ['class'=>'form-control mayuscula','maxlength'=>'15','autocomplete'=>'off']) !!}
                                </div>
                                <div class="col-md-6 form-group">
                                    {!! Form::label('nombredet', 'Nombre:') !!}
                                    {!! Form::text('nombredet', null, ['class'=>'form-control mayuscula','maxlength'=>'50','autocomplete'=>'off']) !!}
                                </div>
                                <div class="col-md-1">
                                    <button type="button" id='add' class="btn btn-block btn-convertir mtop20" datatoggle="tooltip" data-placement="top" title="Aceptar">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" id='cancel' class="btn btn-block btn-convertir mtop20" datatoggle="tooltip" data-placement="top" title="Descartar">
                                        <i class="fas fa-times"></i>
                                    </button>
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
        $('#agregar').click(function(){
            $('#aedet').show();
            $('#detalles').hide();
            $('#idd').val($('#id').val());
            $('#tipo').val(1);
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

        $('#cancel').click(function(){
            $('#aedet').hide();
            $('#detalles').show();
            $('#nombredet').val(null);
            $('#licencia').val(null);
        });
    });

    function veritems(){
        $.get(url_global+"/admin/transportistas/"+$('#id').val()+"/tablaitem/",function(response){
            $('#tdetitem').empty();
            $('#tdetitem').html(response);
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
</script>
@endsection
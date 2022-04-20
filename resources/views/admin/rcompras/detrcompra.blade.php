{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Destino')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.rcompras.index') }}"><i class="fas fa-cart-plus"></i> Registro de Compras | Servicios</a>
    </li>
	<li class="breadcrumb-item">
		<a href="{{ route('admin.ingresos.index') }}"><i class="fas fa-chart-pie"></i> Destinos</a>
	</li>
@endsection

@section('contenido')
    <div id="mensaje_error" class="alert alert-danger" style="display:none;">
        <strong id="contenido_error"></strong>
    </div>
	<div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                {!! Form::model($rcompra,['route'=>['admin.ingresos.update',$rcompra],'method'=>'put']) !!}
				<div class="panelprin shadow">
                    <div class="headercontent">
                        <h2 class="title"><i class="fas fa-cart-plus"></i> Comprobante</h2>
                    </div>
					<div class="inside">
                        <div class="row">
                            <div class="col-md-1 form-group">
                                {!! Form::label('periodo', 'Periodo:') !!}
								{!! Form::text('periodo', null, ['class'=>'form-control activo']) !!}
							</div>
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        {!! Form::label('fecha', 'Fecha:') !!}
                                        {!! Form::text('fecha', date('d/m/Y',strtotime($rcompra->fecha)), ['class'=>'form-control activo','disabled']) !!}
                                    </div>
                                    <div class="col-md-6">
                                        {!! Form::label('moneda', 'Moneda:') !!}
                                        {!! Form::select('moneda',['PEN' => 'SOLES','USD'=>'DOLARES'],null,['class'=>'custom-select guarda','disabled']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('tipocomprobante_codigo', 'Tipo Comprobante:') !!}
                                {!! Form::select('tipocomprobante_codigo',$tipocomprobante,null,['class'=>'custom-select guarda','disabled','placeholder'=>'']) !!}
                            </div>
                            <div class="col-md-2">
                                {!! Form::label('numero', 'Número Documento:') !!}
                                <div class="row no-gutters">
                                    <div class="col-md-4">
                                        {!! Form::text('serie', null, ['class'=>'form-control mayuscula guarda','disabled','maxlength'=>'4','autocomplete'=>'off']) !!}
                                    </div>
                                    <div class="col-md-8">								
                                        {!! Form::text('numero', null, ['class'=>'form-control mayuscula guarda','disabled','maxlength'=>'15','autocomplete'=>'off']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                {!! Form::label('cliente_id', 'Proveedor:') !!}
                                {!! Form::select('cliente_id',$clientes,null,['class'=>'custom-select guarda','disabled','id'=>'cliente_id','placeholder'=>'']) !!}
                            </div>
                        </div>
					</div>				
				</div>
                {!! Form::close() !!}
			</div>
		</div>
        <div class="row mtop16 oculto" id="adddetalle">
            <div class="col-md-12">
                {!! Form::open(['route'=>'admin.rcompras.adddestino', 'id'=>'formadddestino']) !!}
                <div class="panelprin shadow">
                    <div class="headercontent">
						<h2 class="title"><i class="fas fa-chart-pie"></i> Destinos</h2>
						<ul>
                            <li>
                                <button type="button" id='agregar' class="btn btn-convertir mt-2">
                                    <i class="fas fa-check"></i> Agregar
                                </button>
                            </li>
                            <li>
                                <button type="button" id='descartar' class="btn btn-convertir mt-2 ">
                                    <i class="fas fa-times"></i> Descartar
                                </button>
                            </li>
						</ul>
					</div>
                    <div class="inside">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                {!! Form::hidden('id', $rcompra->id,['id' => 'id']) !!}
                                                {!! Form::label('destino_id', 'Destino:') !!}
                                                {!! Form::select('destino_id',$destinos,null,['class'=>'custom-select','placeholder'=>'']) !!}
                                            </div>
                                            <div class="col-md-6 form-group">
                                                {!! Form::label('detdestino_id', 'Detalle:') !!}
                                                {!! Form::select('detdestino_id',[],null,['class'=>'custom-select','placeholder'=>'']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="row">
                                            <div class="col-md-9 form-group">
                                                {!! Form::label('ccosto_id', 'C.Costo:') !!}
                                                {!! Form::select('ccosto_id',$ccosto,null,['class'=>'custom-select','placeholder'=>'']) !!}
                                            </div>
                                            <div class="col-md-3 form-group">
                                                {!! Form::label('monto', 'Monto:') !!}
                                                {!! Form::text('monto',null,['class'=>'form-control decimal']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
        <div class="row mtop16 adddetalle">
            <div class="col-md-12">
                <div class="panelprin shadow">
                    <div class="inside">
                        <div id="tdetitem"></div>
                    </div>
                </div>
            </div>
        </div>
	</div>
@endsection
{{-- @section('css')
    <link rel="stylesheet" href="{{ url('/static/css/admin.css?v='.time()) }}">
@stop --}}
{{-- @section('js')
    <script src="{{ url('/static/js/admin.js?v='.time()) }}"></script>
@stop --}}
@section('script')
<script>
    var url_global='{{url("/")}}';
    $('#buslote').prop('disabled',true);
    $(document).ready(function(){
        veritems();
        $('#destino_id').on('select2:close',function(){
            var destino = this.value;
            $.get(url_global+"/admin/destinos/"+destino+"/listdetalle/",function(response){
                $('#detdestino_id').empty();
                for(i=0;i<response.length;i++){
                    $('#detdestino_id').append("<option value='"+response[i].id+"'>"
                        + response[i].nombre
                        + "</option>");
                }
                $('#detdestino_id').val(null);
                $('#detdestino_id').select2({
                    placeholder:"DETALLE"
                });
            });
        });

        $('#additem').click(function(){
            $('#adddetalle').show();
            $('#destino_id').select2({
                placeholder:"DESTINO"
            });
            
            $('#ccosto_id').select2({
                placeholder:"CENTRO DE COSTO"
            });
        });

        $('#agregar').click(function(e){
            e.preventDefault();
            $.ajax({
                url: "{{ route('admin.rcompras.adddestino') }}",
                type: "POST",
                async: true,
                data: $('#formadddestino').serialize(),
                
                success: function(respuesta){
                    $('#adddetalle').hide();
                    $('#destino_id').val(null);
                    $('#detdestino_id').val(null);
                    $('#detdestino_id').select2({
                        placeholder:"DETALLE"
                    });
                    $('#ccosto_id').val(null);
                    $('#monto').val(null);
                    veritems();
                },
                error: function(error){
                    // console.log(error);
                    let html = 'Se encontraron los siguientes errores:';
                    html += "<ul>";
                    for (var i in error.responseJSON.errors) {
                        html += "<li>"+ error.responseJSON.errors[i] +"</li>";
                        console.log(error.responseJSON.errors[i])
                    }
                    html += "</ul>";
                    $('#contenido_error').html(html);
                    $('#mensaje_error').slideDown();
                    setTimeout(function(){ $('#mensaje_error').slideUp(); }, 3000);
                }
            });
        });

        $('#descartar').click(function(){
            $('#adddetalle').hide();
            $('#destino_id').val(null);
            $('#detdestino_id').val(null);
                $('#detdestino_id').select2({
                    placeholder:"DETALLE"
                });
            $('#ccosto_id').val(null);
            $('#monto').val(null);
        });
    });

    function veritems(){
        $.get(url_global+"/admin/rcompras/"+$('#id').val()+"/tablaitem/",function(response){
            $('#tdetitem').empty();
            $('#tdetitem').html(response);
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
				$.get(url_global+"/admin/rcompras/"+id+"/destroyitem/",function(response){
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
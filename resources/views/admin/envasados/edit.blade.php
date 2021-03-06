{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Planilla de Envasado @if ($envasado->tipo == 2) Crudo @endif')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.envasados.index') }}"><i class="far fa-clipboard"></i> Planilla de Envasado @if ($envasado->tipo == 2) Crudo @endif</a>
	</li>
@endsection


@section('contenido')
    <div id="mensaje_error" class="alert alert-danger" style="display:none;">
        <strong id="contenido_error"></strong>
    </div>
	<div class="container-fluid">
		<div class="row" id = 'agregarcomprobante'>
            <div class="col-md-12">
                {!! Form::model($envasado,['route'=>['admin.envasados.update',$envasado], 'method'=>'put']) !!}
				<div class="panelprin shadow">
                    <div class="headercontent">
						<h2 class="title"><i class="far fa-clipboard"></i> Planilla de Envasado @if ($envasado->tipo == 2) Crudo @endif</h2>
						<ul>
                            @if ($envasado->estado == 1)
                            <li>
                                {!! Form::submit('Guardar', ['class'=>'btn btn-convertir mt-1', 'id'=>'guardar']) !!}
                            </li>
                            @can('admin.envasados.aprobar')
                            <li>
                                <a class="btn btn-convertir mt-1" href="{{ route('admin.envasados.aprobar',$envasado) }}">Aprobar</a>
                            </li>
                            @endcan
                            @endif
                            @if ($envasado->estado == 2)
                            @can('admin.envasados.aprobar')
                            <li>
                                <a class="btn btn-convertir mt-1" href="{{ route('admin.envasados.abrir',$envasado) }}">Permitir Editar</a>
                            </li>
                            @endcan
                            @endif
                            <li>
                                <a class="btn btn-convertir mt-1" href="{{ route('admin.pdf.envasado',$envasado) }}" target="_blank" datatoggle="tooltip" data-placement="top" title="Imprimir"><i class="fas fa-print"></i></a>
                            </li>

						</ul>
					</div>
					<div class="inside">
                        <div class="row">
                            <div class="col-md-2">
                                {!! Form::hidden('id', null,['id' => 'id']) !!}
                                {!! Form::label('numero', 'N??mero:') !!}
                                {!! Form::text('numero', null, ['class'=>'form-control numero','maxlength'=>'6','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('fecha', 'Fecha:') !!}
                                {!! Form::date('fecha', null, ['class'=>'form-control']) !!}
                            </div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('fproduccion', 'Fecha Producci??n:') !!}
                                {!! Form::date('fproduccion', null, ['class'=>'form-control']) !!}
                            </div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('lote', 'Lote:') !!}
                                {!! Form::select('lote',$lotes,null,['class'=>'custom-select']) !!}
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-8 form-group">
                                        {!! Form::label('supervisor_id', 'Supervisor:') !!}
                                        {!! Form::select('supervisor_id',$supervisores,null,['class'=>'custom-select','placeholder'=>'']) !!}
                                    </div>
                                    <div class="col-md-4 form-group">
                                        {!! Form::label('turno', 'Turno:') !!}
                                        {!! Form::select('turno',[1 => 'Dia', 2 => 'Noche'],null,['class'=>'custom-select']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                {!! Form::label('observaciones', 'Observaciones:') !!}
                                {!! Form::textarea('observaciones',null,['class'=>'form-control mayuscula', 'rows'=>'3', 'id'=>'editor']) !!}
                            </div>
                        </div>
					</div>				
				</div>
                {!! Form::close() !!}
			</div>
		</div>
        <div class="row mtop16 oculto" id="aeitem">
			<div class="col-md-12">
				<div class="panelprin shadow">
                    <div class="headercontent">
						<h2 class="title"><i class="fas fa-file-alt"></i> Ingrese Productos</h2>
						<ul>
                            <li>
                                <button type="button" id='add' class="btn btn-block btn-convertir mt-2" datatoggle="tooltip" data-placement="top" title="Aceptar">
                                    <i class="fas fa-check"></i> Aceptar
                                </button>
                            </li>
                            <li>
                                <button type="button" id='cancel' class="btn btn-block btn-convertir mt-2" datatoggle="tooltip" data-placement="top" title="Descartar">
                                    <i class="fas fa-times"></i> Descartar
                                </button>
                            </li>
						</ul>
					</div>
					<div class="inside">
                        {!! Form::open(['route'=>'admin.envasados.additem', 'id'=>'formdetalle']) !!}
                        <div class="row">
                            <div class="col-md-2 form-group">
                                {!! Form::hidden('envasado_id', $envasado->id, ['id'=>'envasado_id']) !!}
                                {!! Form::hidden('tipodet', 1, ['id'=>'tipodet']) !!}
                                {!! Form::hidden('iddet', null, ['id'=>'iddet']) !!}
                                {!! Form::label('trazabilidad_id', 'Producto:') !!}
                                {!! Form::select('trazabilidad_id',$trazabilidad,null,['class'=>'custom-select','placeholder'=>'']) !!}
                            </div>
                            <div class="col-md-3 form-group">
                                {!! Form::label('dettrazabilidad_id', 'Clasificaci??n:') !!}
                                {!! Form::select('dettrazabilidad_id',[],null,['class'=>'custom-select','placeholder'=>'']) !!}
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        {!! Form::label('cantidad', 'Cantidad:') !!}
                                        {!! Form::text('cantidad', null, ['class'=>'form-control decimal','id'=>'cantidad']) !!}
                                    </div>
                                    <div class="col-md-4 form-group">
                                        {!! Form::label('peso', 'Peso Unit.:') !!}
                                        {!! Form::text('peso', null, ['class'=>'form-control decimal','id'=>'peso']) !!}
                                    </div>
                                    <div class="col-md-4 form-group">
                                        {!! Form::label('total', 'Total Kg:') !!}
                                        {!! Form::text('total', null, ['class'=>'form-control decimal','id'=>'total','disabled']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        {!! Form::label('equipoenvasado_id', 'Equipo:') !!}
                                        {!! Form::select('equipoenvasado_id',$equipos,null,['class'=>'custom-select','placeholder'=>'']) !!}
                                    </div>
                                    <div class="col-md-6 form-group">
                                        {!! Form::label('hora', 'Hora:') !!}
                                        {!! Form::time('hora', null, ['class'=>'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="row mtop16" id="detalles">
			<div class="col-md-12">
				<div class="panelprin shadow">
					<div class="inside">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="" id="tdetitem">
                                </div>
                            </div>
                        </div>
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
        veritems();
        
        $('#guardar').click(function(){
            $('.activo').prop('disabled',false);
        });

        $('#numero').blur(function(){
            this.value = this.value.replace(/^(0+)/g,'');
        });

        $('#trazabilidad_id').change(function(){
            $.get(url_global+"/admin/pprocesos/"+this.value+"/listdetalle/",function(response){
                $('#dettrazabilidad_id').empty();
                for(i=0;i<response.length;i++){
                    $('#dettrazabilidad_id').append("<option value='"+response[i].id+"'>"
                        + response[i].mpd_codigo
                        + "</option>");
                }
                $('#dettrazabilidad_id').val(null);
            });
        });
   
        $('#cantidad').blur(function(){
            var cantidad = NaNToCero($('#cantidad').val());
            var peso = NaNToCero($('#peso').val());
            $('#total').val(Redondea(cantidad*peso,2))
        });

        $('#peso').blur(function(){
            var cantidad = NaNToCero($('#cantidad').val());
            var peso = NaNToCero($('#peso').val());
            $('#total').val(Redondea(cantidad*peso,2))
        });

        $('#add').click(function(){
            $('#total').prop('disabled',false);
            $.ajax({
                url: "{{ route('admin.envasados.additem') }}",
                type: "POST",
                async: true,
                data: $('#formdetalle').serialize(),                
                success: function(respuesta){
                    $('#trazabilidad_id').val(null);
                    $('#dettrazabilidad_id').val(null);
                    $('#cantidad').val(null);
                    $('#total').val(null);
                    $('#aeitem').hide();
                    veritems();
                    $('#detalles').show();
                    $('#total').prop('disabled',true);
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

        $('#cancel').click(function(){
            $('#aeitem').hide();
            $('#detalles').show();
            $('#tipodet').val(1);
            $('#iddet').val(null);
            $('#trazabilidad_id').val(null);
            $('#dettrazabilidad_id').val(null);
            $('#cantidad').val(null);
            $('#total').val(null);
        });

    });

    function veritems(){
		var id = $('#id').val();
		$.get(url_global+"/admin/envasados/"+id+"/tablaitem/",function(response){
			$('#tdetitem').empty();
			$('#tdetitem').html(response);
		});
	}

    function edititem (id) {
        $('#aeitem').show();
        $('#detalles').hide();
        $('#tipodet').val(2);
        $('#iddet').val(id);
        $('#trazabilidad_id').focus();
        var trazabilidad_id;
        var dettrazabilidad_id;
        
        $.get(url_global+"/admin/envasados/"+id+"/detenvasado/",function(response){
            $('#trazabilidad_id').val(response.trazabilidad_id);
            $('#dettrazabilidad_id').val(response.dettrazabilidad_id);
            $('#peso').val(response.peso);
            $('#cantidad').val(response.cantidad);
            $('#total').val(response.total);
            $('#equipoenvasado_id').val(response.equipoenvasado_id);
            $('#hora').val(response.hora);
            $.get(url_global+"/admin/pprocesos/"+response.trazabilidad_id+"/listdetalle/",function(respuesta){
                $('#dettrazabilidad_id').empty();
                for(i=0;i<respuesta.length;i++){
                    $('#dettrazabilidad_id').append("<option value='"+respuesta[i].id+"'>"
                        + respuesta[i].mpd_codigo
                        + "</option>");
                }
                $('#dettrazabilidad_id').val(response.dettrazabilidad_id);
            })
        });

    }

    function destroyitem(id){
		Swal.fire({
            title: 'Est?? Seguro de Eliminar el Registro?',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '??Si, eliminar!',
            cancelButtonText: 'Cancelar'
            }).then((result) => {
            if (result.value) {
				$.get(url_global+"/admin/envasados/"+id+"/destroyitem/",function(response){
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
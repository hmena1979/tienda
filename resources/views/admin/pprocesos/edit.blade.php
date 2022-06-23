@extends('admin.master')
@section('title','Productos Proceso')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.pprocesos.index') }}"><i class="fas fa-dolly-flatbed"></i> Productos Proceso</a>
	</li>
@endsection

@section('contenido')
    <div id="mensaje_error" class="alert alert-danger" style="display:none;">
        <strong id="contenido_error"></strong>
    </div>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
                    {!! Form::model($pproceso,['route'=>['admin.pprocesos.update',$pproceso],'method'=>'put']) !!}
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-dolly-flatbed"></i> Productos Proceso</h2>
                        <ul>
                            {!! Form::submit('Guardar', ['class'=>'btn btn-convertir mt-1']) !!}
                        </ul>
                    </div>
					<div class="inside">
						<div class="row">
							<div class="col-md-6 form-group">
                                {!! Form::hidden('id', null, ['id'=>'id']) !!}
								{!! Form::label('nombre', 'Nombre:') !!}
								{!! Form::text('nombre', null, ['class'=>'form-control mayuscula','autocomplete'=>'off']) !!}
							</div>
						</div>
                        
					</div>				
                    {!! Form::close() !!}
				</div>
			</div>
		</div>

        <div class="row mtop16">
            <div class="col-md-2">
                {{-- <a class='btn btn-convertir btn-block' href="#"><b><i class="fas fa-plus"></i> Trazabilidad</b></a> --}}
                <button id="btnaddtrazabilidad" class="btn btn-convertir btn-block"><i class="fas fa-plus"></i> Trazabilidad</button>
                {{-- @if ($trazabilidad) --}}
                    @foreach ($pproceso->trazabilidads as $det)
                    @if ($det->id == $trazabilidad->id)
                    <a class='btn btn-primary btn-block' href="{{ route('admin.pprocesos.edit',[$pproceso->id, $det->id]) }}">{{ $det->nombre }}</a>
                    @else
                    <a class='btn btn-outline-primary btn-block' href="{{ route('admin.pprocesos.edit',[$pproceso->id, $det->id]) }}">{{ $det->nombre }}</a>    
                    @endif
                    @endforeach
                {{-- @endif --}}
            </div>
            <div class="col-md-10">
                <div class="panelprin shadow">
                    <div class="headercontent">
                        @if ($trazabilidad)
                        <h2 id="titulodetalle" class="title">
                            Código de Trazabilidad: <strong>{{ $trazabilidad->nombre }}</strong>
                            <button type="button" class="btn ml-4" title="Editar" onclick="editTrazabilidad('{{ $trazabilidad->id }}');">
                                <i class="fas fa-edit"></i>
                            </button>
                            @if ($trazabilidad->dettrazabilidads->count() == 0)
                            <button type="button" class="btn" title="Eliminar" onclick="destroyTrazabilidad('{{ $trazabilidad->id }}');">
                                <i class="fas fa-trash-alt"></i>
                            </button>                                
                            @endif
                        </h2>
                        <ul>
                            <li>
                                <button type="button" id='agregar' class="btn btn-convertir mt-1">Agregar Detalle</button>
                            </li>
                            <li>
                                <button type="button" id='guardaDet' class="btn btn-convertir mt-1 oculto" datatoggle="tooltip" data-placement="top" title="Aceptar">
                                    <i class="fas fa-check"></i> Aceptar
                                </button>
                            </li>
                            <li>
                                <button type="button" id='descartaDet' class="btn btn-convertir mt-1 oculto" datatoggle="tooltip" data-placement="top" title="Descartar">
                                    <i class="fas fa-times"></i> Descartar
                                </button>
                            </li>
                        </ul>
                        @endif
                    </div>
                    <div class="inside">
                        <div class="oculto mb-3" id="formtrazabilidad">
                            {!! Form::open(['route'=>'admin.pprocesos.aetrazabilidad', 'id'=>'formtraz']) !!}
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    {{-- {!! Form::hidden('idTrazabilidad', null, ['id'=> 'idTrazabilidad']) !!} --}}
                                    {!! Form::hidden('pproceso_id', $pproceso->id, ['id' => 'pproceso_id']) !!}
                                    {!! Form::hidden('tipoTrazabilidad', 1, ['id' => 'tipoTrazabilidad']) !!}
                                    @if ($trazabilidad)
                                    {!! Form::hidden('idtrazabilidad', $trazabilidad->id, ['id'=>'idtrazabilidad']) !!}
                                    @endif
                                    {!! Form::label('nombreTrazabilidad', 'Nombre:') !!}
                                    {!! Form::text('nombreTrazabilidad', null, ['class'=>'form-control mayuscula','id'=>'nombreTrazabilidad','maxlength'=>'100','autocomplete'=>'off']) !!}
                                </div>
                                <div class="col-md-1">
                                    <button type="button" id='guardaTrazabilidad' class="btn btn-block btn-convertir mtop20" datatoggle="tooltip" data-placement="top" title="Aceptar">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" id='descartaTrazabilidad' class="btn btn-block btn-convertir mtop20" datatoggle="tooltip" data-placement="top" title="Descartar">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                        <div class="oculto mb-3" id="aedet">
                            {!! Form::open(['route'=>'admin.pprocesos.addeditdet', 'id'=>'formdet']) !!}
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    @if ($trazabilidad)
                                    {!! Form::hidden('trazabilidad_id', $trazabilidad->id, ['id'=>'trazabilidad_id']) !!}
                                    @endif
                                    {!! Form::hidden('iddet', null, ['id'=> 'iddet']) !!}
                                    {!! Form::hidden('tipodet', 1, ['id' => 'tipodet']) !!}
                                    {!! Form::label('mpd_id', 'Materia Prima:') !!}
                                    {!! Form::select('mpd_id',$mpds,null,['class'=>'custom-select','id'=>'mpd_id','placeholder' => '']) !!}
                                </div>
                                <div class="col-md-2 form-group">
                                    {!! Form::label('calidad', 'Calidad:') !!}
                                    {!! Form::select('calidad',[1=>'EXPORT',2=>'M.N.'],null,['class'=>'custom-select activo']) !!}
                                </div>
                                <div class="col-md-2 form-group">
                                    {!! Form::label('sobrepeso', 'Sobre Peso %:') !!}
                                    {!! Form::text('sobrepeso', null, ['class'=>'form-control numero','maxlength'=>'3','autocomplete'=>'off']) !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2 form-group">
                                    {!! Form::label('envase', 'Envase:') !!}
                                    {!! Form::select('envase',[1=>'SACO',2=>'BLOCK'],null,['class'=>'custom-select']) !!}
                                </div>
                                <div class="col-md-2 form-group">
                                    {!! Form::label('codigo', 'Código:') !!}
                                    {!! Form::text('codigo', null, ['class'=>'form-control','maxlength'=>'30','autocomplete'=>'off']) !!}
                                </div>
                                <div class="col-md-2 form-group">
                                    {!! Form::label('peso', 'Peso Unitario Kg:') !!}
                                    {!! Form::text('peso', null, ['class'=>'form-control numero','maxlength'=>'3','autocomplete'=>'off']) !!}
                                </div>
                                <div class="col-md-2 form-group">
                                    {!! Form::label('precio', 'Precio Contrata:') !!}
                                    {!! Form::text('precio', null, ['class'=>'form-control decimal','maxlength'=>'5','autocomplete'=>'off']) !!}
                                </div>
                            </div>
                            {!! Form::close() !!}
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
    $(document).ready(function(){
        $('#btnaddtrazabilidad').click(function(){
            $('#titulodetalle').hide();
            $('#aedet').hide();
            $('#agregar').hide();
            $('#detalles').hide();
            $('#formtrazabilidad').show();
            $('#tipoTrazabilidad').val(1);
        });

        veritems();

        $('#agregar').click(function(){
            $('#aedet').show();
            $('#guardaDet').show();
            $('#descartaDet').show();
            $('#formtrazabilidad').hide();
            $('#detalles').hide();
            $('#agregar').hide();
            $('#tipodet').val(1);
            $('#mpd_id').val(null);
            $('#codigo').val(null);
            $('#precio').val(null);
            $('#sobrepeso').val(10);
            $('#peso').val(20);
        });

        $('#guardaDet').click(function(){
            $.ajax({
                url: "{{ route('admin.pprocesos.addeditdet') }}",
                type: "POST",
                async: true,
                data: $('#formdet').serialize(),                
                success: function(respuesta){
                    $('#aedet').hide();
                    $('#guardaDet').hide();
                    $('#descartaDet').hide();
                    $('#agregar').show();
                    $('#formtrazabilidad').hide();
                    veritems();
                    $('#detalles').show();
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

        $('#descartaDet').click(function(){
            $('#aedet').hide();
            $('#guardaDet').hide();
            $('#descartaDet').hide();
            $('#formtrazabilidad').hide();
            $('#agregar').show();
            $('#detalles').show();
        });

        $('#guardaTrazabilidad').click(function(){
            $.ajax({
                url: "{{ route('admin.pprocesos.aetrazabilidad') }}",
                type: "POST",
                async: true,
                data: $('#formtraz').serialize(),                
                success: function(respuesta){
                    veritems();
                    $('#aedet').hide();
                    $('#formtrazabilidad').hide();
                    $('#detalles').show();
                    $('#agregar').show();
                    $('#nombredet').val(null);
                    $('#titulodetalle').show();
                    location.reload();
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
            var id = null;
            if ($('#tipoTrazabilidad').val() == 1) {
                id = $('#id').val();
            } else {
                id = $('#trazabilidad_id').val();
            }
            var det = {
                'tipo' : $('#tipoTrazabilidad').val(),
                'id' : id,
                'nombre' : $('#nombreTrazabilidad').val(),
            };
			var envio = JSON.stringify(det);
            $.get(url_global+"/admin/pprocesos/"+envio+"/aetrazabilidad/",function(response){
                switch (response) {
                    case '1':
                        veritems();
                        $('#aedet').hide();
                        $('#formtrazabilidad').hide();
                        $('#detalles').show();
                        $('#agregar').show();
                        $('#nombredet').val(null);
                        $('#titulodetalle').show();
                        location.reload();
                        break;
                }
            });            
            
        });

        $('#descartaTrazabilidad').click(function(){
            $('#aedet').hide();
            $('#formtrazabilidad').hide();
            $('#detalles').show();
            $('#agregar').show();
            $('#nombredet').val(null);
            $('#titulodetalle').show();
        });
    });

    function veritems(){
        if ($('#trazabilidad_id').val()) {
            $.get(url_global+"/admin/pprocesos/"+$('#trazabilidad_id').val()+"/tablaitem/",function(response){
                $('#tdetitem').empty();
                $('#tdetitem').html(response);
            });
        }
    }

    function editTrazabilidad(id) {
        $('#titulodetalle').hide();
        $('#aedet').hide();
        $('#agregar').hide();
        $('#detalles').hide();
        $('#formtrazabilidad').show();
        $('#tipoTrazabilidad').val(2);
        $.get(url_global+"/admin/pprocesos/"+id+"/trazabilidad/",function(response){
            $('#nombreTrazabilidad').val(response.nombre);
        });
    }

    function edititem (id) {
        $('#aedet').show();
        $('#guardaDet').show();
        $('#descartaDet').show();
        $('#agregar').hide();
        $('#detalles').hide();
        $('#iddet').val(id);
        $('#tipodet').val(2);
        
        $.get(url_global+"/admin/pprocesos/"+id+"/dettrazabilidad/",function(response){
            $('#mpd_id').val(response.mpd_id);
            $('#calidad').val(response.calidad);
            $('#sobrepeso').val(response.sobrepeso);
            $('#envase').val(response.envase);
            $('#codigo').val(response.codigo);
            $('#peso').val(response.peso);
            $('#precio').val(response.precio);
        });
    }

    function destroyTrazabilidad(id){
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
				$.get(url_global+"/admin/pprocesos/"+id+"/destroytrazabilidad/",function(response){
                    window.open(url_global+"/admin/pprocesos/edit/"+$('#id').val(), '_self');
                    // veritems();
                    // Swal.fire({
                    //     icon:'success',
                    //     title:'Eliminado',
                    //     text:'Registro Eliminado'
                    // });
                    // location.href = url_global+"/admin/pprocesos/edit/"+$('#id').val();
                    // alert(url_global+"/admin/pprocesos/edit/"+$('#id').val());
				});
            }
            })
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
				$.get(url_global+"/admin/pprocesos/"+id+"/destroyitem/",function(response){
                    veritems();
                    Swal.fire({
                        icon:'success',
                        title:'Eliminado',
                        text:'Registro Eliminado'
                    });
                    // location.href = url_global+"/admin/pprocesos/edit/"+$('#id').val();
				}); 
            }
            })
	}
</script>
@endsection
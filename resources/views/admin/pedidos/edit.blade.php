{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Pedidos')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.pedidos.index') }}"><i class="fas fa-file-archive"></i> Pedidos</a>
	</li>
@endsection

@section('contenido')
    <div id="mensaje_error" class="alert alert-danger" style="display:none;">
        <strong id="contenido_error"></strong>
    </div>
	<div class="container-fluid">
		<div class="row" id = 'agregarcomprobante'>
            <div class="col-md-12">
                {!! Form::model($pedido,['route'=>['admin.pedidos.update',$pedido], 'method'=>'put']) !!}
				<div class="panelprin shadow">
                    <div class="headercontent">
						<h2 class="title"><i class="fas fa-file-archive"></i> Pedidos</h2>
						<ul>
                            <li>
                                {!! Form::submit('Guardar', ['class'=>'btn btn-convertir mt-2', 'id'=>'guardar']) !!}
                            </li>
                            @if ($pedido->estado == 1)
                            <li>
                                <button type="button" id='enviar' class="btn btn-convertir mt-2">Realizar Pedido</button>
                            </li>
                            @endif
                            @if ($pedido->estado == 2 && $procesa)
                            <li>
                                <button type="button" id='recepcionado' class="btn btn-convertir mt-2">Recepcionado</button>
                            </li>
                            @endif
                            @if ($pedido->estado == 3 && $procesa)
                            <li>
                                <button type="button" id='atender' class="btn btn-convertir mt-2">Atender</button>
                            </li>
                            <li>
                                <button type="button" id='rechazar' class="btn btn-rechazar mt-2">Rechazar</button>
                            </li>
                            @endif
						</ul>
					</div>
                    {{-- {{ dd($comprobante) }} --}}
					<div class="inside">
                        <div class="row">
                            <div class="col-md-2 form-group">
                                {!! Form::label('fecha', 'Fecha:') !!}
                                {!! Form::date('fecha', null, ['class'=>'form-control activo']) !!}
                                {!! Form::hidden('id', null, ['id'=>'id']) !!}
                                {!! Form::hidden('estado', null, ['id'=>'estado']) !!}
                                {!! Form::hidden('procesa', $procesa, ['id'=>'procesa']) !!}
                            </div>
                            <div class="col-md-3 form-group">
                                {!! Form::label('user_id', 'Solicita:') !!}
                                {!! Form::select('user_id',$users,null,['class'=>'custom-select activo','id'=>'user_id']) !!}
                            </div>
                            <div class="col-md-5">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        {!! Form::label('destino_id', 'Destino:') !!}
                                        {!! Form::select('destino_id',$destinos,$destino,['class'=>'custom-select','placeholder'=>'']) !!}
                                    </div>
                                    <div class="col-md-6 form-group">
                                        {!! Form::label('detdestino_id', 'Detalle:') !!}
                                        {!! Form::select('detdestino_id',$detdestinos,null,['class'=>'custom-select','placeholder'=>'']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('lote', 'Lote:') !!}
                                {!! Form::text('lote', null, ['class'=>'form-control mayuscula','autocomplete'=>'off']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                {!! Form::label('observaciones', 'Observaciones:') !!}
                                {!! Form::textarea('observaciones',null,['class'=>'form-control mayuscula activo', 'rows'=>'2']) !!}
                            </div>
                        </div>
                        @if ($procesa)
                        <div class="row">
                            <div class="col-md-12 form-group">
                                {!! Form::label('obslogistica', 'Respuesta Logística:') !!}
                                {!! Form::textarea('obslogistica',null,['class'=>'form-control mayuscula', 'rows'=>'2']) !!}
                            </div>
                        </div>
                        @else
                            @if ($pedido->obslogistica)
                                {!! Form::label('obslogistica', 'Respuesta Logística:') !!} <br>
                                <span class="negrita colorprin">{{ $pedido->obslogistica }}</span>
                            @endif
                        @endif
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
                        {!! Form::open(['route'=>'admin.pedidos.additem', 'id'=>'formdetalle']) !!}
                        <div class="row">
                            <div class="col-md-4 form-group">
                                {!! Form::hidden('pedido_id', $pedido->id, ['id'=>'pedido_id']) !!}
                                {!! Form::label('producto_id', 'Producto:') !!}
                                {!! Form::select('producto_id',[],null,['class'=>'custom-select','placeholder'=>'']) !!}
                            </div>
                            <div class="col-md-2">
                                {!! Form::label('cantidad', 'Cantidad:') !!}
                                {!! Form::text('cantidad', null, ['class'=>'form-control decimal','id'=>'cantidad']) !!}
                            </div>
                            <div class="col-md-6 form-group">
                                {!! Form::label('glosa', 'Glosa:') !!}
                                {!! Form::text('glosa', null, ['class'=>'form-control mayuscula']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 txt-convertir-conmarco">
                                <div>
                                    <span id='descproducto' class="descproducto"></span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <a id='enlaceimagen' href="{{ url('/static/images/sinproducto.jpg') }}" data-fancybox="gallery">
                                    <img id='imgimagen' class="img img-fluid oculto" src="{{ url('/static/images/sinproducto.jpg') }}" alt="">
                                </a>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="row mtop16 oculto" id="editaritem">
			<div class="col-md-12">
				<div class="panelprin shadow">
                    <div class="headercontent">
						<h2 class="title"><i class="fas fa-file-alt"></i> Editar Pedido</h2>
						<ul>
                            <li>
                                <button type="button" id='editarsi' class="btn btn-block btn-convertir mt-2" datatoggle="tooltip" data-placement="top" title="Aceptar">
                                    <i class="fas fa-check"></i> Aceptar
                                </button>
                            </li>
                            <li>
                                <button type="button" id='editarno' class="btn btn-block btn-convertir mt-2" datatoggle="tooltip" data-placement="top" title="Descartar">
                                    <i class="fas fa-times"></i> Descartar
                                </button>
                            </li>
						</ul>
					</div>
					<div class="inside">
                        {!! Form::open(['route'=>'admin.pedidos.additem', 'id'=>'formdetalle']) !!}
                        <div class="row">
                            <div class="col-md-5 form-group">
                                {!! Form::hidden('detpedido_id', null, ['id'=>'detpedido_id']) !!}
                                {!! Form::hidden('ctrlstock', null, ['id'=>'ctrlstock']) !!}
                                {!! Form::label('detproducto_id', 'Producto:') !!}
                                {!! Form::text('detproducto_id',null,['class'=>'form-control', 'disabled']) !!}
                            </div>
                            <div class="col-md-2">
                                {!! Form::label('detcantidad', 'Cantidad:') !!}
                                {!! Form::text('detcantidad', null, ['class'=>'form-control decimal','id'=>'detcantidad', 'disabled']) !!}
                            </div>
                            <div class="col-md-5 form-group">
                                {!! Form::label('detglosa', 'Glosa:') !!}
                                {!! Form::text('detglosa', null, ['class'=>'form-control mayuscula','id'=>'detglosa', 'disabled']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                {!! Form::label('detstock', 'Stock:') !!}
                                {!! Form::text('detstock', null, ['class'=>'form-control decimal','id'=>'detstock']) !!}
                            </div>
                            <div class="col-md-2">
                                {!! Form::label('catendida', 'Aprobado:') !!}
                                {!! Form::text('catendida', null, ['class'=>'form-control decimal','id'=>'catendida']) !!}
                            </div>
                            <div class="col-md-6 form-group">
                                {!! Form::label('motivo', 'Motivo:') !!}
                                {!! Form::text('motivo', null, ['class'=>'form-control mayuscula','id'=>'motivo']) !!}
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

@section('style')
    <link rel="stylesheet" href="{{ asset('css/jquery.fancybox.min.css') }}">
@stop
@section('script')
<script src="{{ asset('/js/jquery.fancybox.min.js') }}"></script>
<script>
    var url_global='{{url("/")}}';
    $(document).ready(function(){
        veritems();
        
        $('#guardar').click(function(){
            $('.activo').prop('disabled',false);
        });

        if ($('#estado').val() != 1 ) {
            $('.activo').prop('disabled',true);
        }

        if ($('#procesa').val() ) {
            $('.activo').prop('disabled',true);
        }

        $('#destino_id').select2({
            placeholder:"DESTINO"
        });

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

        $('#detdestino_id').select2({
            placeholder:"DETALLE"
        });

        $('#producto_id').on('select2:close',function(){
            var producto = this.value;
            if (!Empty(producto)) {
                $.get(url_global+"/admin/productos/"+producto+"/showdetp/",function(response){
                    // alert(response['detallada']);
                    if (!Empty(response['detallada'])) {
                        $('#descproducto').show();
                        var descripciondetallada = response['detallada'];
                        document.getElementsByClassName('descproducto')[0].innerHTML = descripciondetallada;
                    } else {
                        $('#descproducto').text(null);
                        $('#descproducto').hide();
                    }
                    if (!Empty(response['imagen'])) {
                        $('#imgimagen').show();
                        var imagenproducto = url_global+'/products'+response['imagen'];
                        document.getElementById('imgimagen').setAttribute('src',imagenproducto);
                        document.getElementById('enlaceimagen').setAttribute('href',imagenproducto);
                    } else {
                        var imagenproducto = url_global+'/static/images/sinproducto.jpg';
                        document.getElementById('imgimagen').setAttribute('src',imagenproducto);
                        document.getElementById('enlaceimagen').setAttribute('href',imagenproducto);
                        $('#imgimagen').hide();
                    }
                });
            }
        });

        $('#add').click(function(){
            $.ajax({
                url: "{{ route('admin.pedidos.additem') }}",
                type: "POST",
                async: true,
                data: $('#formdetalle').serialize(),                
                success: function(respuesta){
                    $('#producto_id').val(null);
                    $('#cantidad').val(null);
                    $('#glosa').val(null);
                    $('#aeitem').hide();
                    veritems();
                    $('#detalles').show();
                    $('#descproducto').hide();
                    $('#imgimagen').hide();
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
            $('#producto_id').val(null);
            $('#cantidad').val(null);
            $('#glosa').val(null);
            $('#descproducto').hide();
            $('#imgimagen').hide();
        });

        $('#editarsi').click(function(){
            var det = {
				'id' : $('#detpedido_id').val(),
				'catendida' : $('#catendida').val(),
				'motivo' : $('#motivo').val(),
			};
			var envio = JSON.stringify(det);
            $.get(url_global+"/admin/pedidos/"+envio+"/editdetpedido/",function(response){
                $('#editaritem').hide();
                veritems()
                $('#detalles').show();
            });
        });

        $('#editarno').click(function(){
            $('#editaritem').hide();
            $('#detalles').show();
        });

        $('#enviar').click(function(){
            var id = $('#id').val();
            Swal.fire({
            title: 'Está Seguro que desea Realizar el Pedido?',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '¡Si, realizar!',
            cancelButtonText: 'Cancelar'
            }).then((result) => {
            if (result.value) {
                $.get(url_global+"/admin/pedidos/"+id+"/enviar/",function(response){
                    location.reload();
                });
            }
            })            
        });

        $('#recepcionado').click(function(){
            var id = $('#id').val();
            Swal.fire({
            title: 'Está Seguro que desea Marcar el Pedido como Recepcionado?',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '¡Si, realizar!',
            cancelButtonText: 'Cancelar'
            }).then((result) => {
            if (result.value) {
                $.get(url_global+"/admin/pedidos/"+id+"/recepcionado/",function(response){
                    location.reload();
                });
            }
            })            
        });

        $('#atender').click(function(){
            var id = $('#id').val();
            Swal.fire({
            title: 'Está Seguro que desea Procesar el Pedido?',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '¡Si, realizar!',
            cancelButtonText: 'Cancelar'
            }).then((result) => {
            if (result.value) {
                $.get(url_global+"/admin/pedidos/"+id+"/atender/",function(response){
                    if (response['codigo'] == 2) {
                        Swal.fire(
                            'Error, Saldo Insuficiente',
                            'Alguno de los Productos exede el Stock',
                            'error'
                            )
                    }
                    if (response['codigo'] == 1) {
                        let ancho = 1000;
                        let alto = 800;
                        let x = parseInt((window.screen.width/2) - (ancho / 2));
                        let y = parseInt((window.screen.height/2) - (alto / 2));
                        let url = url_global + '/admin/pdf/' + response['id'] + '/facturacion';
                        let option = "left=" + x + ", top=" + y + ", height=" + alto + ", width=" + ancho + 
                            " ,scrollbar=si, location=no, resizable=si, menubar=no";
                        // window.open(url,'Comprobante',option);
                        window.open(url,'_blank');
                        location.reload();
                    }
                });
            }
            })            
        });

        $('#rechazar').click(function(){
            var id = $('#id').val();
            Swal.fire({
            title: 'Está Seguro que desea Marcar el Pedido como Rechado?',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '¡Si, realizar!',
            cancelButtonText: 'Cancelar'
            }).then((result) => {
            if (result.value) {
                $.get(url_global+"/admin/pedidos/"+id+"/rechazar/",function(response){
                    location.reload();
                });
            }
            })            
        });

        $('#catendida').blur(function(){
            if (this.value > $('#detstock').val() && $('#ctrlstock').val() == 1){
                Swal.fire(
                    'Error, Saldo Insuficiente',
                    'Cantidad es mayor al Stock',
                    'error'
                    )
                this.value = $('#detstock').val();
            }
        });

    });

    function veritems(){
		var id = $('#id').val();
		$.get(url_global+"/admin/pedidos/"+id+"/tablaitem/",function(response){
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
				$.get(url_global+"/admin/pedidos/"+id+"/destroyitem/",function(response){
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

    function edititem(id){
        $.get(url_global+"/admin/pedidos/"+id+"/detpedido/",function(response){
            $('#detpedido_id').val(response['id']);
            $('#detproducto_id').val(response['producto']);
            $('#detcantidad').val(response['cantidad']);
            $('#detglosa').val(response['glosa']);
            $('#detstock').val(response['stock']);
            $('#ctrlstock').val(response['ctrlstock']);
            $('#catendida').val(response['catendida']);
            $('#motivo').val(response['motivo']);
        });
        $('#editaritem').show();
        $('#detalles').hide();
    }

</script>
@endsection
{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Solicitud de Compras')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.solcompras.index') }}"><i class="fas fa-file-archive"></i> Solicitud de Compras</a>
	</li>
@endsection

@section('contenido')
    <div id="mensaje_error" class="alert alert-danger" style="display:none;">
        <strong id="contenido_error"></strong>
    </div>
	<div class="container-fluid">
        <div class="alert alert-warning" role="alert" style="display:none" id = 'buscando'>
			Procesando...
		</div>
		<div class="row" id = 'agregarcomprobante'>
            <div class="col-md-12">
                {!! Form::model($solcompra,['route'=>['admin.solcompras.update',$solcompra], 'method'=>'put']) !!}
				<div class="panelprin shadow">
                    <div class="headercontent">
						<h2 class="title"><i class="fas fa-file-archive"></i> Solicitud de Compras</h2>
						<ul>
                            <li>
                                {!! Form::submit('Guardar', ['class'=>'btn btn-convertir mt-1', 'id'=>'guardar']) !!}
                            </li>
                            {{-- @if ($pedido->estado == 1)
                            <li>
                                <button type="button" id='enviar' class="btn btn-convertir mt-1">Realizar Pedido</button>
                            </li>
                            @endif
                            @if ($pedido->estado == 2 && $procesa)
                            <li>
                                <button type="button" id='recepcionado' class="btn btn-convertir mt-1">Recepcionado</button>
                            </li>
                            @endif
                            @if ($pedido->estado == 3 && $procesa)
                            <li>
                                <button type="button" id='atender' class="btn btn-convertir mt-1">Atender</button>
                            </li>
                            <li>
                                <button type="button" id='rechazar' class="btn btn-rechazar mt-1">Rechazar</button>
                            </li>
                            @endif --}}
                            <li>
                                <a class="btn btn-convertir mt-1" href="{{ route('admin.pdf.solcompra',$solcompra) }}" target="_blank" datatoggle="tooltip" data-placement="top" title="Imprimir">
                                    <i class="fas fa-print"></i>
                                </a>
                            </li>
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
                            </div>
                            <div class="col-md-3 form-group">
                                {!! Form::label('user_id', 'Solicita:') !!}
                                {!! Form::select('user_id',$users,null,['class'=>'custom-select activo','id'=>'user_id']) !!}
                            </div>
                            <div class="col-md-6 form-group">
                                {!! Form::label('observaciones', 'Observaciones:') !!}
                                {!! Form::textarea('observaciones',null,['class'=>'form-control mayuscula activo', 'rows'=>'1']) !!}
                            </div>
                            <div class="col-md-1">
                                {{-- <button class="btn btn-block btn-convertir mt-6" type="button" id="busca" title="Buscar en Pedidos">
                                    <i class="fas fa-file-archive"></i>
                                </button> --}}
                                <a class="btn btn-block btn-convertir mt-6" href="{{ route('admin.solcompras.buscapedidos',$solcompra) }}" datatoggle="tooltip" data-placement="top" title="Buscar en Pedidos">
                                    <i class="fas fa-file-archive"></i>
                                </a>
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
                        {!! Form::open(['route'=>'admin.solcompras.additem', 'id'=>'formdetalle']) !!}
                        <div class="row">
                            <div class="col-md-4 form-group">
                                {!! Form::hidden('solcompra_id', $solcompra->id, ['id'=>'solcompra_id']) !!}
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
                            <div class="col-md-10 d-flex">
                                <div class="card flex-fill">
                                    <div class="card-body">
                                        <span id='descproducto' class="descproducto"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 d-flex">
                                <div class="card flex-fill">
                                    <div class="card-body">
                                        <a id='enlaceimagen' href="{{ url('/static/images/sinproducto.jpg') }}" data-fancybox="gallery">
                                            <img id='imgimagen' class="img img-fluid oculto" src="{{ url('/static/images/sinproducto.jpg') }}" alt="">
                                        </a>
                                    </div>
                                </div>
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
                        {!! Form::open(['route'=>'admin.solcompras.additem', 'id'=>'formdetalle']) !!}
                        <div class="row">
                            <div class="col-md-5 form-group">
                                {!! Form::hidden('detsolcompra_id', null, ['id'=>'detsolcompra_id']) !!}
                                {!! Form::hidden('ctrlstock', null, ['id'=>'ctrlstock']) !!}
                                {!! Form::label('detproducto_id', 'Producto:') !!}
                                {!! Form::text('detproducto_id',null,['class'=>'form-control', 'disabled']) !!}
                            </div>
                            <div class="col-md-2">
                                {!! Form::label('detsolicitado', 'Solicitado:') !!}
                                {!! Form::text('detsolicitado', null, ['class'=>'form-control decimal','id'=>'detsolicitado','disabled']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                {!! Form::label('detstock', 'Stock:') !!}
                                {!! Form::text('detstock', null, ['class'=>'form-control decimal','id'=>'detstock','disabled']) !!}
                            </div>
                            <div class="col-md-2">
                                {!! Form::label('detcantidad', 'Cantidad:') !!}
                                {!! Form::text('detcantidad', null, ['class'=>'form-control decimal','id'=>'detcantidad']) !!}
                            </div>
                            <div class="col-md-6 form-group">
                                {!! Form::label('detglosa', 'Glosa:') !!}
                                {!! Form::text('detglosa', null, ['class'=>'form-control mayuscula','id'=>'detglosa']) !!}
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

        $('#busca').click(function(){
            var id = $('#id').val();
            $.get(url_global+"/admin/solcompras/buscapedidos/",function(response){
                alert(response)
            });
        });

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
                url: "{{ route('admin.solcompras.additem') }}",
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
				'id' : $('#detsolcompra_id').val(),
				'cantidad' : $('#detcantidad').val(),
				'glosa' : $('#detglosa').val(),
			};
			var envio = JSON.stringify(det);
            $.get(url_global+"/admin/solcompras/"+envio+"/editdetsolcompra/",function(response){
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
            title: 'Está Seguro que desea Realizar la Solicitud de Compra?',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '¡Si, realizar!',
            cancelButtonText: 'Cancelar'
            }).then((result) => {
            if (result.value) {
                $.get(url_global+"/admin/solcompras/"+id+"/enviar/",function(response){
                    location.reload();
                    Swal.fire(
                        'Enviado',
                        'Pedido enviado, este atento de la respuesta de Logística',
                        'success'
                        )
                });
            }
            })            
        });

        // $('#recepcionado').click(function(){
        //     var id = $('#id').val();
        //     Swal.fire({
        //     title: 'Está Seguro que desea Marcar el Pedido como Recepcionado?',
        //     text: "",
        //     icon: 'warning',
        //     showCancelButton: true,
        //     confirmButtonColor: '#3085d6',
        //     cancelButtonColor: '#d33',
        //     confirmButtonText: '¡Si, realizar!',
        //     cancelButtonText: 'Cancelar'
        //     }).then((result) => {
        //     if (result.value) {
        //         var det = {
        //             'id' : id,
        //             'respuesta' : $('#obslogistica').val(),
        //         };
        //         var envio = JSON.stringify(det);
        //         $.get(url_global+"/admin/pedidos/"+envio+"/recepcionado/",function(response){
        //             location.reload();
        //         });
        //     }
        //     })            
        // });

        // $('#atender').click(function(){
        //     var id = $('#id').val();
        //     Swal.fire({
        //     title: 'Está Seguro que desea Procesar el Pedido?',
        //     text: "",
        //     icon: 'warning',
        //     showCancelButton: true,
        //     confirmButtonColor: '#3085d6',
        //     cancelButtonColor: '#d33',
        //     confirmButtonText: '¡Si, realizar!',
        //     cancelButtonText: 'Cancelar'
        //     }).then((result) => {
        //     if (result.value) {
        //         var det = {
        //             'id' : id,
        //             'respuesta' : $('#obslogistica').val(),
        //         };
        //         var envio = JSON.stringify(det);
        //         $('#buscando').show();
        //         $.get(url_global+"/admin/pedidos/"+envio+"/atender/",function(response){
        //             document.getElementById('buscando').style.display = 'none';
        //             $('#buscando').hide();
        //             if (response['codigo'] == 2) {
        //                 Swal.fire(
        //                     'Error, Saldo Insuficiente',
        //                     'Alguno de los Productos exede el Stock',
        //                     'error'
        //                     )
        //             }
        //             if (response['codigo'] == 1) {
        //                 let ancho = 1000;
        //                 let alto = 800;
        //                 let x = parseInt((window.screen.width/2) - (ancho / 2));
        //                 let y = parseInt((window.screen.height/2) - (alto / 2));
        //                 let url = url_global + '/admin/pdf/' + response['id'] + '/facturacion';
        //                 let option = "left=" + x + ", top=" + y + ", height=" + alto + ", width=" + ancho + 
        //                     " ,scrollbar=si, location=no, resizable=si, menubar=no";
        //                 window.open(url,'_blank');
        //                 location.reload();
        //             }
        //         });
        //         $('#buscando').hide();
        //     }
        //     })            
        // });

        // $('#rechazar').click(function(){
        //     var id = $('#id').val();
        //     Swal.fire({
        //     title: 'Está Seguro que desea Marcar el Pedido como Rechado?',
        //     text: "",
        //     icon: 'warning',
        //     showCancelButton: true,
        //     confirmButtonColor: '#3085d6',
        //     cancelButtonColor: '#d33',
        //     confirmButtonText: '¡Si, realizar!',
        //     cancelButtonText: 'Cancelar'
        //     }).then((result) => {
        //     if (result.value) {
        //         var det = {
        //             'id' : id,
        //             'respuesta' : $('#obslogistica').val(),
        //         };
        //         var envio = JSON.stringify(det);
        //         $.get(url_global+"/admin/pedidos/"+envio+"/rechazar/",function(response){
        //             location.reload();
        //         });
        //     }
        //     })            
        // });

    });

    function veritems(){
		var id = $('#id').val();
		$.get(url_global+"/admin/solcompras/"+id+"/tablaitem/",function(response){
            // alert(response)
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
				$.get(url_global+"/admin/solcompras/"+id+"/destroyitem/",function(response){
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
        $.get(url_global+"/admin/solcompras/"+id+"/detsolcompra/",function(response){
            $('#detsolcompra_id').val(response['id']);
            $('#detproducto_id').val(response['producto']);
            $('#detsolicitado').val(response['solicitado']);
            $('#detcantidad').val(response['cantidad']);
            $('#detglosa').val(response['glosa']);
            $('#detstock').val(response['stock']);
            $('#ctrlstock').val(response['ctrlstock']);
        });
        $('#editaritem').show();
        $('#detalles').hide();
    }

</script>
@endsection
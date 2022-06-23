{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Consumos')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.consumos.index') }}"><i class="fas fa-cart-arrow-down"></i> Consumos</a>
	</li>
@endsection

@section('contenido')
    <div id="mensaje_error" class="alert alert-danger" style="display:none;">
        <strong id="contenido_error"></strong>
    </div>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
                {!! Form::open(['route'=>'admin.consumos.store','id'=>'formcomprobante']) !!}
				<div class="panelprin shadow">
                    <div class="headercontent">
						<h2 class="title"><i class="fas fa-cart-arrow-down"></i> Consumos</h2>
						<ul>
                            <li>
                                {!! Form::submit('Generar', ['class'=>'btn btn-convertir mt-2', 'id'=>'guardar']) !!}
                            </li>
						</ul>
					</div>
					<div class="inside">
                        {{-- {!! Form::hidden('id', null) !!} --}}
                        {!! Form::hidden('empresa_id', session('empresa')) !!}
                        {!! Form::hidden('sede_id', session('sede')) !!}
                        {!! Form::hidden('key', $key, ['id'=>'key']) !!}
                        {!! Form::hidden('fin', 2, ['id'=>'fin']) !!}
                        <div class="row">
                            <div class="col-md-1 form-group">
                                {!! Form::label('periodo', 'Periodo:') !!}
								{!! Form::text('periodo', session('periodo'), ['class'=>'form-control activo','disabled']) !!}
							</div>
                            <div class="col-md-3 form-group">
                                {!! Form::label('destino_id', 'Destino:') !!}
                                {!! Form::select('destino_id',$destinos,null,['class'=>'custom-select','placeholder'=>'']) !!}
                            </div>
                            <div class="col-md-3 form-group">
                                {!! Form::label('detdestino_id', 'Detalle:') !!}
                                {!! Form::select('detdestino_id',[],null,['class'=>'custom-select','placeholder'=>'']) !!}
                            </div>
                            <div class="col-md-2">
                                {!! Form::label('lotep', 'Lote:') !!}
                                {!! Form::select('lotep',$lotes,null,['class'=>'custom-select','placeholder' => '']) !!}
                                {{-- {!! Form::text('lote', null, ['class'=>'form-control mayuscula activo','autocomplete'=>'off']) !!} --}}
                            </div>
                            {{-- <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        {!! Form::label('ccosto_id', 'C.Costo:') !!}
                                        {!! Form::select('ccosto_id',$ccosto,null,['class'=>'custom-select','placeholder'=>'']) !!}
                                    </div>
                                </div>
                            </div> --}}
                            
                            <div class="col-md-2 form-group">
                                {!! Form::label('fecha', 'Fecha:') !!}
                                {!! Form::date('fecha', Carbon\Carbon::now(), ['class'=>'form-control activo']) !!}
                            </div>
                            <div class="col-md-1">
                                {!! Form::label('tc', 'TC:') !!}
                                {!! Form::text('tc', null, ['class'=>'form-control decimal activo','autocomplete'=>'off']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                {!! Form::label('detalle', 'Recibido por:') !!}
                                {!! Form::text('detalle', null, ['class'=>'form-control mayuscula activo','autocomplete'=>'off']) !!}
                            </div>
                        </div>
					</div>				
				</div>
                {!! Form::close() !!}
			</div>
		</div>
        <div class="row mtop16 add">
            <div class="col-md-12">
                <div id="mensaje_errorp" class="alert alert-danger" style="display:none;">
                    <strong id="contenido_errorp"></strong>
                </div>
                <div class="panelprin shadow">
                    <div class="headercontent">
                        <h2 class="title">
                            Agregar Producto | Servicio
                        </h2>
                        <ul>
                            <li>
                                <button type="button" id='agregar' class="btn btn-convertir mt-2" datatoggle="tooltip" data-placement="top" title="Guardar"><i class="fas fa-check"></i> Guardar</button>
                            </li>
                            <li>
                                <button type="button" id='descartar' class="btn btn-convertir mt-2" datatoggle="tooltip" data-placement="top" title="Descartar"><i class="far fa-times-circle"></i> Descartar</button>
                            </li>
                        </ul>
                    </div>
                    <div class="inside">
                        {!! Form::open(['route'=>'admin.rventas.additem','id'=>'formadditem']) !!}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-3 form-group">
                                        {!! Form::label('grupo', 'Tipo:') !!}
                                        {!! Form::select('grupo',[1=>'Producto'],1,['class'=>'custom-select']) !!}
                                    </div>
                                    <div class="col-md-9 form-group">
                                        {!! Form::label('producto_id', 'Producto | Servicio:') !!}
                                        {!! Form::select('producto_id',[],null,['class'=>'custom-select','placeholder'=>'']) !!}
                                        {!! Form::hidden('bolsas',null,['id'=>'bolsas']) !!}
                                        {!! Form::hidden('lotevencimiento',null,['id'=>'lotevencimiento']) !!}
                                        {!! Form::hidden('ctrlstock',null,['id'=>'ctrlstock']) !!}
                                        {!! Form::hidden('keydet', $key, ['id'=>'keydet']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 form-group">
                                {!! Form::label('adicional', 'Información Adicional:') !!}
                                {!! Form::textarea('adicional',null,['class'=>'form-control mayuscula', 'rows'=>'1']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-7">
                                        {!! Form::label('lote', 'Lote:') !!}
                                        <div class="input-group">
                                            {!! Form::text('lote', null, ['class'=>'form-control activodet','autocomplete'=>'off','disabled']) !!}
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="button" id="buslote" data-toggle="modal" data-target="#buscarLote" onclick="limpia()"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5 form-group">
                                        {!! Form::label('vence', 'Vencimiento:') !!}
                                        {!! Form::text('vence', '', ['class'=>'form-control activodet','autocomplete'=>'off','disabled']) !!}
                                    </div>
                                </div>                                
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        {!! Form::label('stocklote', 'Stock Lote:') !!}
                                        {!! Form::text('stocklote', null, ['class'=>'form-control','disabled']) !!}
                                    </div>
                                    <div class="col-md-4 form-group">
                                        {!! Form::label('stock', 'Stock:') !!}
                                        {!! Form::text('stock', null, ['class'=>'form-control','disabled']) !!}
                                    </div>
                                    <div class="col-md-4 form-group">
                                        {!! Form::label('cantidad', 'Cantidad:') !!}
                                        {!! Form::text('cantidad', null, ['class'=>'form-control decimal']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 oculto">
                                <div class="row">
                                    <div class="col-md-4 form-group consumo">
                                        {!! Form::label('precio', 'Precio:',['id'=>'lblprecio','datatoggle'=>"tooltip", 'data-placement'=>"top"]) !!}
                                        {!! Form::text('precio', null, ['class'=>'form-control decimal']) !!}
                                        {!! Form::hidden('precompra', null, ['id'=>'precompra']) !!}
                                        {!! Form::hidden('premin', null, ['id'=>'premin']) !!}
                                        {!! Form::hidden('prevta', null, ['id'=>'prevta']) !!}
                                    </div>
                                    <div class="col-md-4 form-group consumo">
                                        {!! Form::label('icbper', 'ICBPER:') !!}
                                        {!! Form::text('icbper', null, ['class'=>'form-control activodet','disabled']) !!}
                                    </div>
                                    <div class="col-md-4 form-group consumo">
                                        {!! Form::label('subtotal', 'SubTotal:') !!}
                                        {!! Form::text('subtotal', null, ['class'=>'form-control activodet','disabled']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                        <!-- Modal Buscar Lote-->
                        <div class="modal fade" id="buscarLote" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <input type="text" class='form-control' id= 'buscarl' placeholder = 'Buscar lote' autocomplete='off' autofocus>
                                    </div>
                                    <div class="modal-body">
                                        <div class="cuerpol">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-success" data-dismiss='modal'>Salir</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Fin Modal -->
                    </div>
                </div>
            </div>
        </div>
        <div class="row mtop16">
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
        let fecha = $('#fecha').val();
        $.get(url_global+"/admin/rcompras/"+fecha+"/bustc/",function(response){
            $('#tc').val(response['venta']);
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

        $('#detdestino_id').val(null);

        $('#detdestino_id').select2({
            placeholder:"DETALLE"
        });

        $('#ccosto_id').select2({
            placeholder:"CENTRO DE COSTO"
        });

        $('.add').hide();
        $('.finalizar').hide();
        $('.detraccion').hide();
        // $('#guardar').hide();

        $('#cliente_id').select2({
            placeholder:"Ingrese 4 dígitos del RUC o Razón Social",
            minimumInputLength: 4,
            ajax:{
                url: "{{ route('admin.clientes.seleccionado',3) }}",
                dataType:'json',
                delay:250,
                processResults:function(response){
                    return{
                        results: response
                    };
                },
                cache: true,
            }
        });

        $('#guardar').click(function(e){
            $('.activo').prop('disabled',false);
            e.preventDefault();

            $.ajax({
                url: "{{ route('admin.consumos.store') }}",
                type: "POST",
                async: true,
                data: $('#formcomprobante').serialize(),
                
                success: function(respuesta){
                    let ancho = 1000;
                    let alto = 800;
                    let x = parseInt((window.screen.width/2) - (ancho / 2));
                    let y = parseInt((window.screen.height/2) - (alto / 2));
                    let url = url_global + '/admin/pdf/' + respuesta['id'] + '/facturacion';
                    let option = "left=" + x + ", top=" + y + ", height=" + alto + ", width=" + ancho + 
                        " ,scrollbar=si, location=no, resizable=si, menubar=no";
                    // window.open(url,'Comprobante',option);
                    window.open(url,'_blank');
                    location.reload();
                    // console.log(respuesta);
                },
                error: function(error){
                    $('#periodo').prop('disabled',true);
                    console.log(error);
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

        $('#prueba').click(function(){
            location.reload();
        });

        $('#fecha').blur(function(){
            $.get(url_global+"/admin/rcompras/"+this.value+"/bustc/",function(response){
                $('#tc').val(response['venta']);
            });
        });

        $('#descartar').click(function(){
            $('.add').hide();
            limpiaDetalle();
            $('#grupo').val(1);
            $('#adddetvta').show();
        });

        $('#buslote').prop('disabled',true);

        veritems();

        $('#finalizar').click(function(){
            $('#adddetvta').hide();
            $('.finalizar').show();
            $('#finalizar').hide();
            $('#fin').val(1);
            $('#guardar').show();
            $('#continuar').show();
        });

        $('#continuar').click(function(){
            $('#continuar').hide();
            $('#adddetvta').show();
            $('.finalizar').hide();
            $('#finalizar').show();
            $('#fin').val(2);
            $('#guardar').hide();
        });

        $('#producto_id').select2({
            placeholder:"Ingrese 4 dígitos del Nombre del Producto",
            minimumInputLength: 4,
            ajax:{
                url: "{{ route('admin.productos.seleccionadoc') }}",
                dataType:'json',
                delay:250,
                processResults:function(response){
                    return{
                        results: response
                    };
                },
                cache: true,
            }
        });
        
        // $('#grupo').change(function(){
        //     $('#producto_id').val(null);
        //     $('#producto_id').select2({
        //         placeholder:"Ingrese 4 dígitos del Nombre del Producto",
        //         minimumInputLength: 4,
        //         ajax:{
        //             url: "{{ route('admin.productos.seleccionadoc') }}",
        //             dataType:'json',
        //             delay:250,
        //             processResults:function(response){
        //                 return{
        //                     results: response
        //                 };
        //             },
        //             cache: true,
        //         }
        //     });
        //     limpiaDetalle();
        // });

        $('#producto_id').on('select2:close',function(){
            $('#adicional').val(null);
            $('#lote').val(null);
            $('#vence').val(null);
            $('#stocklote').val(null);
            $('#stock').val(null);
            $('#cantidad').val(null);
            $('#precio').val(null);
            $('#subtotal').val(null);
            var producto = this.value;
            $.get(url_global+"/admin/productos/"+producto+"/showdetp/",function(response){
                $('#ctrlstock').val(response['ctrlstock']);
                $("#lotevencimiento").val(response["lotevencimiento"]);
                if (response['ctrlstock'] == 1 && response['grupo'] == 1) {
                    $("#stock").val(response["stock"]);
                } else {
                    $("#stock").val(null);
                }
                let preventa = 0;
                let premin = 0;
                if($('#moneda').val() == 'PEN'){
                    preventa = response["precompra"];
                    premin = response["precompra"];
                }else{
                    preventa = response["precompra"];
                    premin = response["precompra"];
                }
                $("#precio").val(preventa);
                $("#prevta").val(preventa);
                $("#premin").val(premin);
                $("#precompra").val(response["precompra"]);
                // $('#lblprecio').prop('title', 'Precio Mínimo con Descuento: ' + premin);//text('Precio >= ' + Redondea(response["preventamin"],2));
                if(response["lotevencimiento"] == 2){
                    $('#lote').prop('disabled',true);
                    // $('#vence').prop('disabled',true);
                    $('#buslote').prop('disabled',true);
                }else{
                    $('#lote').prop('disabled',false);
                    // $('#vence').prop('disabled',false);
                    $('#buslote').prop('disabled',false);
                }
            });
        });

        $('#buscarl').keyup(function(){
            tabresultl(this.value);
        });

        $('#lote').blur(function(){
            if(this.value.length >= 1){
                var producto = $('#producto_id').val();
                $.get(url_global+"/admin/productos/"+producto+"/"+this.value+"/buslote/",function(response){
                    if (response!=""){
                        $('#lote').val(response[0].lote);
                        $('#vence').val(response[0].vencimiento);
                        $('#stocklote').val(response[0].saldo);
                    }else{
                        $('#vence').val(null);
                        $('#stocklote').val(null);
                    }
                });
            }
        });

        $('#cantidad').blur(function(){
            const cantidad = NaNToCero(parseFloat($('#cantidad').val()));
            const precio = NaNToCero(parseFloat($('#precio').val()));
            if($('#grupo').val() == 1 && $('#ctrlstock').val() == 1){
                if($('#lotevencimiento').val() == 1){
                    if(cantidad > $('#stocklote').val()){
                        Swal.fire(
                            'Error, Saldo Insuficiente',
                            'Cantidad es mayor al Stock del Lote',
                            'error'
                            )
                        // this.value = $('#stocklote').val();
                        // $('#subtotal').val(Redondea(this.value * precio, 2));
                        return true;
                    }
                    if(cantidad > $('#stock').val()){
                        Swal.fire(
                            'Error, Saldo Insuficiente',
                            'Cantidad es mayor al Stock',
                            'error'
                            )
                        this.value = null;
                        $('#subtotal').val(null);
                        return true;
                    }
                }else{
                    if(cantidad > $('#stock').val()){
                        Swal.fire(
                            'Error, Saldo Insuficiente',
                            'Cantidad es mayor al Stock',
                            'error'
                            )
                        this.value = null;
                        $('#subtotal').val(null);
                        return true;
                    }
                }
                $('#subtotal').val(Redondea(cantidad * precio, 2));
            }else{
                $('#subtotal').val(Redondea(cantidad * precio, 2));
                
            }
        });

        $('#agregar').click(function(e){
            e.preventDefault();
            let html = 'Se encontraron los siguientes errores:';
            html += "<ul>";
            if($('#producto_id').val().length == 0){
                html += "<li>"+ 'Seleccione un Producto | Servicio' +"</li>";
            }
            if($('#cantidad').val().length == 0 || $('#cantidad').val() == 0){
                html += "<li>"+ 'Ingrese Cantidad' +"</li>";
            }
            if($('#precio').val().length == 0 || $('#precio').val() == 0){
                html += "<li>"+ 'Ingrese Precio' +"</li>";
            }
            html += "</ul>";
            if (
                ($('#producto_id').val().length == 0) ||
                ($('#cantidad').val().length == 0 || $('#cantidad').val() == 0) ||
                ($('#precio').val().length == 0 || $('#precio').val() == 0)
                ) {
                    $('#contenido_errorp').html(html);
                    $('#mensaje_errorp').slideDown();
                    setTimeout(function(){ $('#mensaje_errorp').slideUp(); }, 3000);
                    return true;
            }
            $('.activodet').prop('disabled',false)
            $.ajax({
                url: "{{ route('admin.consumos.additem') }}",
                type: "POST",
                async: true,
                data: $('#formadditem').serialize(),
                
                success: function(respuesta){
                    veritems();
                    limpiaDetalle()
                    $('#grupo').val(1);
                    $('#adddetvta').show();
                    $('.add').hide();
                    
                    Swal.fire(
                    'Agregado',
                    'Registro Agregado con Éxito',
                    'success'
                    );
                    // console.log(respuesta);
                },
                error: function(error){
                    Swal.fire(
                        'Falló',
                        'No se agregó el registro',
                        'success'
                        );
                }
            });
        });

    });

    function tabresultl(parbus){
        var html = '';
        var producto = $('#producto_id').val();
        if(parbus.length >= 1){					
            $.get(url_global+"/admin/productos/"+producto+"/"+parbus+"/findlote/",function(response){
                if (response==""){
                    html = 'No se encontraton datos';
                }else{
                    html += "<table class='table table-resposive table-hover table-sm'>";
                    html += "<thead><tr><th>LOTE</th><th>VENCIMIENTO</th><th>STOCK</th><th></th></tr></thead>";
                    html += "<tbody>";
                    var regMostrar = 0;
                    if(response.length <= 10){
                        regMostrar = response.length;
                    }else{
                        regMostrar = 10;
                    }
                    for (var i = 0; i < regMostrar; i++) {
                        valor = response[i].id;
                        html += "<tr><td>"+response[i].lote + "</td><td>" +response[i].vencimiento+"</td><td>"+response[i].saldo+"</td>";
                        html += "<td><div class='opts'><button class='btn btn-primary btn-sm' type='button' datatoggle='tooltip' data-placement='top' title='Seleccionar' data-dismiss='modal' onclick=devLot("+valor+");><i class='fas fa-check'></i></button></div></td></tr>"
                    }
                    html += "</tbody></table>";							
                }
                // document.getElementsByClassName('cuerpol')[0].innerHTML = html;
                $('.cuerpol').eq(0).html(html);
            });								
        }
    }

    function devLot(codigo){
        $.get(url_global+"/admin/productos/"+codigo+"/selectlote/",function(response){
            if (response!=""){
                $('#lote').val(response.lote);
                $('#vence').val(response.vencimiento);
                $('#stocklote').val(response.saldo);
            }else{
                $('#vence').val(null);
                $('#stocklote').val(null);
            }
        });
    }

    function limpia(){
        $('.cuerpol').eq(0).html('');
        $('#buscarl').val(null);
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
				$.get(url_global+"/admin/consumos/"+id+"/destroyitem/",function(response){
                    // vertotales();
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

    function veritems(){
        var key = $('#key').val();
        var moneda = $('#moneda').val();
        $.get(url_global+"/admin/consumos/"+key+"/"+moneda+"/tablaitem/",function(response){
            $('#tdetitem').empty();
            $('#tdetitem').html(response);
        });
    }

    function vertotales(){
        var rventa = 1;
        $.get(url_global+"/admin/consumos/"+rventa+"/tablatotales/",function(response){
            $('#ttotales').empty();
            $('#ttotales').html(response);
        });
    }

    function limpiaDetalle(){
        $('#producto_id').val(null);
        $('#producto_id').empty();
        $('#adicional').val(null);
        $('#cantidad').val(null);
        $('#stock').val(null);
        $('#stocklote').val(null);
        $('#precompra').val(null);
        $('#precio').val(null);
        $('#subtotal').val(null);
        $('#subtotal').prop('disabled',true);
        $('#lote').val(null);
        $('#lote').prop('disabled',true);
        $('#vence').val(null);
        $('#vence').prop('disabled',true);
    }
</script>
@endsection
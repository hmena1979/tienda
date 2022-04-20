{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Registro de Ventas')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.rventas.index') }}"><i class="fas fa-cash-register"></i> Registro de Ventas</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
        <div class="row mtop16">
            <div class="col-md-12">
                {!! Form::model($rventa,['route'=>['admin.rventas.update',$rventa],'method'=>'put']) !!}
                <div class="panelprin shadow">
                    <div class="headercontent">
						<h2 class="title">
                            <i class="fas fa-cash-register"></i> Registro de Ventas - Pedido: <strong>{{ $rventa->id }}</strong><br>
                            <i class="fas fa-cash-register"></i> Operación: <strong>{{ $rventa->tipo==1?'VENTA':'CONSUMO' }}</strong>
                            | Fecha: <strong>{{ $rventa->fecha }}</strong>
                            | Moneda: <strong>{{ $rventa->moneda=='PEN'?'SOLES':'DOLARES' }}</strong>
                            | Cliente: <strong>{{ $rventa->cliente->numdoc_razsoc }}</strong>
                        </h2>
                        <ul>
                            <button type="button" id='finalizar' class="btn btn-convertir mt-3">Finalizar</button>
                            <button type="button" id='continuar' class="btn btn-convertir mt-3 oculto">Continuar</button>
                            {!! Form::submit('Generar Comprobante', ['class'=>'btn btn-convertir mt-3 oculto', 'id' => 'generar']) !!}
                            {{-- <button type="button" id='generar' class="btn btn-convertir mt-3 oculto">Generar Comprobante</button> --}}
						</ul>
					</div>
                    <div class="inside insidetop8 insidebot8">
                        <div class="finalizar">
                            <div class="row">
                                <div class="col-md-2 form-group">
                                    {!! Form::hidden('id', null,['id'=>'id']) !!}
                                    {!! Form::hidden('tc', null,['id'=>'tc']) !!}
                                    {!! Form::hidden('moneda', null,['id'=>'moneda']) !!}
                                    {!! Form::hidden('fecha', null,['id'=>'fecha']) !!}
                                    {!! Form::label('fpago', 'Forma Pago:') !!}
                                    {!! Form::select('fpago',[1=>'CONTADO',2=>'CRÉDITO'],null,['class'=>'custom-select activo']) !!}
                                </div>
                                <div class="col-md-1 form-group">
                                    {!! Form::label('dias', 'Días:') !!}
                                    {!! Form::text('dias', null, ['class'=>'form-control numero activo credito','autocomplete'=>'off','disabled']) !!}
                                </div>
                                <div class="col-md-2 form-group">
                                    {!! Form::label('vencimiento', 'Vencimiento:') !!}
                                    {!! Form::date('vencimiento', null, ['class'=>'form-control activo credito','disabled']) !!}
                                </div>
                                <div class="col-md-7">
                                    <div class="row">
                                        <div class="col-md-5 form-group">
                                            {!! Form::label('mediopago', 'Medio Pago:') !!}
                                            {!! Form::select('mediopago',$mediopago,null,['class'=>'custom-select activo contado','placeholder'=>'']) !!}
                                        </div>
                                        <div class="col-md-4 form-group">
                                            {!! Form::label('cuenta_id', 'Cuenta:') !!}
                                            {!! Form::select('cuenta_id',$cuenta,null,['class'=>'custom-select activo contado','id'=>'cuenta_id','placeholder'=>'']) !!}
                                        </div>
                                        <div class="col-md-3 form-group">
                                            {!! Form::label('numerooperacion', 'N° Operación:') !!}
                                            {!! Form::text('numerooperacion', null, ['class'=>'form-control activo contado','maxlength'=>'15','autocomplete'=>'off']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    {!! Form::label('cliente_id', 'Cliente:') !!}
                                    {!! Form::select('cliente_id',$clientes,null,['class'=>'custom-select activo','id'=>'cliente_id','placeholder'=>'']) !!}
                                </div>
                                <div class="col-md-2 form-group">
                                    {!! Form::label('tipocomprobante_codigo', 'Tipo Comprobante:') !!}
                                    {!! Form::select('tipocomprobante_codigo',$tipocomprobante,null,['class'=>'custom-select activo','placeholder'=>'']) !!}
                                </div>
                                <div class="col-md-1 form-group">
                                    {!! Form::label('detraccion', 'Detracción:') !!}
                                    {!! Form::select('detraccion',[1=>'SI',2=>'NO'],null,['class'=>'custom-select activo']) !!}
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            {!! Form::label('pagacon', 'Paga Con:',['class'=> 'verde']) !!}
                                            {!! Form::text('pagacon', null, ['class'=>'form-control verde decimal activo contado','autocomplete'=>'off']) !!}
                                        </div>
                                        <div class="col-md-6 form-group">
                                            {!! Form::label('vuelto', 'Vuelto:',['class'=> 'rojo']) !!}
                                            {!! Form::text('vuelto', null, ['class'=>'form-control rojo decimal activo contado','autocomplete'=>'off', 'disabled']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-3 form-group detraccion">
                                    {!! Form::label('detraccion_codigo', 'Código Detracción:') !!}
                                    {!! Form::select('detraccion_codigo',$detraccions,null,['class'=>'custom-select activo','placeholder'=>'']) !!}
                                </div>
                                <div class="col-md-3 detraccion">
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            {!! Form::label('detraccion_tasa', 'Tasa:') !!}
                                            {!! Form::text('detraccion_tasa', null, ['class'=>'form-control decimal activo','autocomplete'=>'off']) !!}
                                        </div>
                                        <div class="col-md-6 form-group">
                                            {!! Form::label('detraccion_monto', 'Monto S/:') !!}
                                            {!! Form::text('detraccion_monto', null, ['class'=>'form-control decimal activo','autocomplete'=>'off']) !!}
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
        <div class="row mtop16">
            <div class="col-md-12">
                <div class="panelprin shadow">
                    <div class="inside insidetop8">
                        <div class="add">
                            {!! Form::open(['route'=>'admin.rventas.store']) !!}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-3 form-group">
                                            {!! Form::label('grupo', 'Tipo:') !!}
                                            {!! Form::select('grupo',[1=>'Producto',2=>'Servicio'],null,['class'=>'custom-select']) !!}
                                        </div>
                                        <div class="col-md-9 form-group">
                                            {!! Form::label('producto_id', 'Producto | Servicio:') !!}
                                            {!! Form::select('producto_id',[],null,['class'=>'custom-select','placeholder'=>'']) !!}
                                            {!! Form::hidden('bolsas',null,['id'=>'bolsas']) !!}
                                            {!! Form::hidden('lotevencimiento',null,['id'=>'lotevencimiento']) !!}
                                            {!! Form::hidden('ctrlstock',null,['id'=>'ctrlstock']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 form-group">
                                    {!! Form::label('adicional', 'Información Adicional:') !!}
                                    {!! Form::textarea('adicional',null,['class'=>'form-control mayuscula', 'rows'=>'1']) !!}
                                </div>
                                <div class="col-md-3 form-group">
                                    {!! Form::label('afectacion_id', 'Afectación:') !!}
                                    {!! Form::select('afectacion_id',$afectaciones,null,['class'=>'custom-select']) !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-7">
                                            {!! Form::label('lote', 'Lote:') !!}
                                            <div class="input-group">
                                                {!! Form::text('lote', null, ['class'=>'form-control','autocomplete'=>'off','disabled']) !!}
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="button" id="buslote" data-toggle="modal" data-target="#buscarLote" onclick="limpia()"><i class="fas fa-search"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5 form-group">
                                            {!! Form::label('vence', 'Vencimiento:') !!}
                                            {!! Form::text('vence', '', ['class'=>'form-control','autocomplete'=>'off','disabled']) !!}
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
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-3 form-group consumo">
                                            {!! Form::label('precio', 'Precio:',['id'=>'lblprecio','datatoggle'=>"tooltip", 'data-placement'=>"top"]) !!}
                                            {!! Form::text('precio', null, ['class'=>'form-control decimal']) !!}
                                            {!! Form::hidden('precompra', null, ['id'=>'precompra']) !!}
                                            {!! Form::hidden('premin', null, ['id'=>'premin']) !!}
                                            {!! Form::hidden('prevta', null, ['id'=>'prevta']) !!}
                                        </div>
                                        <div class="col-md-3 form-group consumo">
                                            {!! Form::label('icbper', 'ICBPER:') !!}
                                            {!! Form::text('icbper', null, ['class'=>'form-control','disabled']) !!}
                                        </div>
                                        <div class="col-md-4 form-group consumo">
                                            {!! Form::label('subtotal', 'SubTotal:') !!}
                                            {!! Form::text('subtotal', null, ['class'=>'form-control','disabled']) !!}
                                        </div>
                                        <div class="col-md-2">
                                            {{-- {!! Form::submit('Agregar', ['class'=>'btn btn-convertir mt-4', 'id'=>'agregar1']) !!} --}}
                                            <button type="button" id='agregar' class="btn btn-block btn-convertir mt-4" datatoggle="tooltip" data-placement="top" title="Agregar Item">+</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                            <!-- Modal -->
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
                        
                        <div class="row">
							<div class="col-md-12">
								<div class="tablaao" id="tdetitem">
								</div>
							</div>
						</div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <div class="consumo">
                                    <div class="" id="ttotales">
        
                                    </div>
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
{{-- @section('js')
    <script src="{{ url('/static/js/admin.js?v='.time()) }}"></script>
@stop --}}
@section('script')
<script>
    var url_global='{{url("/")}}';
    $(document).ready(function(){
        // var moneda = {{ $moneda }};
        // alert(moneda)
        $('#buslote').prop('disabled',true);
        $('.finalizar').hide();

        vertotales();
        veritems();

        if({{ $rventa->detraccion }} == 1){
            $('.detraccion').show();
        }else{
            $('.detraccion').hide();
        }

        if($('#fpago').val() == 1){
            $('.contado').prop('disabled',false);
            $('.credito').prop('disabled',true);
        }else{
            $('.contado').prop('disabled',true);
            $('.credito').prop('disabled',false);
        }

        if({{ $rventa->tipo }} == 2){
            $('.consumo').hide();
            $('#fpago').prop('disabled', true);
            $('#mediopago').prop('disabled', true);
            $('#cuenta_id').prop('disabled', true);
            $('#numerooperacion').prop('disabled', true);
            $('#tipocomprobante_codigo').prop('disabled', true);
            $('#detraccion').prop('disabled', true);
            $('#pagacon').prop('disabled', true);
            $('#mediopago').val(null);
            $('#cuenta_id').val(null);
            $('#numerooperacion').val(null);

        }else{
            $('.consumo').show();
        }

        $('#pagacon').change(function(){
            $('#vuelto').val(this.value - $('#total').text());
        });

        $('#fpago').change(function(){
            if(this.value == 1){
            $('.contado').prop('disabled',false);
            $('.credito').prop('disabled',true);
            $('#dias').val(null);
            $('#vencimiento').val(null);
        }else{
            $('.contado').prop('disabled',true);
            $('.credito').prop('disabled',false);
            $('#pagacon').val(null);
            $('#vuelto').val(null);
        }
        });
        
        $('#finalizar').click(function(){
            $('.add').hide();
            $('.finalizar').show();
            $('#finalizar').hide();
            $('#continuar').show();
            $('#generar').show();
            $('#vuelto').prop('disabled',true);
            $('#cliente_id').select2({
                placeholder:"Ingrese 4 dígitos del RUC o Razón Social",
                minimumInputLength: 4,
                ajax:{
                    url: "{{ route('admin.clientes.seleccionado',2) }}",
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

            // Swal.fire(
            // 'Actualizado',
            // 'Registro Actualizado',
            // 'success'
            // );
        });

        $('#continuar').click(function(){
            $('.add').show();
            $('.finalizar').hide();
            $('#finalizar').show();
            $('#continuar').hide();
            $('#generar').hide();
        });

        $('#generar').click(function(){
            $('.activo').prop('disabled', false);
        });

        $('#grupo').change(function(){
            $('#producto_id').val(null);
            if ($('#moneda').val() == 'PEN') {
                $('#producto_id').select2({
                    placeholder:"Ingrese 4 dígitos del Nombre del Producto",
                    minimumInputLength: 4,
                    ajax:{
                        url: "{{ route('admin.productos.seleccionadov') }}"+'/'+'PEN'+'/'+$('#grupo').val(),
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
            } else {
                $('#producto_id').select2({
                    placeholder:"Ingrese 4 dígitos del Nombre del Producto",
                    minimumInputLength: 4,
                    ajax:{
                        url: "{{ route('admin.productos.seleccionadov') }}"+'/'+'USD'+'/'+$('#grupo').val(),
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
            }
            $('#adicional').val(null);
            $('#lote').val(null);
            $('#vence').val(null);
            $('#stocklote').val(null);
            $('#stock').val(null);
            $('#cantidad').val(null);
            $('#precio').val(null);
            $('#icbper').val(null);
            $('#subtotal').val(null);

        });
        if ($('#moneda').val() == 'PEN') {
            $('#producto_id').select2({
                placeholder:"Ingrese 4 dígitos del Nombre del Producto",
                minimumInputLength: 4,
                ajax:{
                    url: "{{ route('admin.productos.seleccionadov') }}"+'/'+'PEN'+'/'+$('#grupo').val(),
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
        } else {
            $('#producto_id').select2({
                placeholder:"Ingrese 4 dígitos del Nombre del Producto",
                minimumInputLength: 4,
                ajax:{
                    url: "{{ route('admin.productos.seleccionadov') }}"+'/'+'USD'+'/'+$('#grupo').val(),
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
        }


        $('#producto_id').on('select2:close',function(){
            $('#adicional').val(null);
            $('#lote').val(null);
            $('#vence').val(null);
            $('#stocklote').val(null);
            $('#stock').val(null);
            $('#cantidad').val(null);
            $('#precio').val(null);
            $('#icbper').val(null);
            $('#subtotal').val(null);
            var producto = this.value;
            $.get(url_global+"/admin/productos/"+producto+"/showdetp/",function(response){
                $('#afectacion_id').val(response['afectacion_id']);
                $('#ctrlstock').val(response['ctrlstock']);
                $("#lotevencimiento").val(response["lotevencimiento"]);
                $("#bolsas").val(response["icbper"]);
                if (response['ctrlstock'] == 1 && response['grupo'] == 1) {
                    $("#stock").val(response["stock"]);
                } else {
                    $("#stock").val(null);
                }
                let preventa = 0;
                let premin = 0;
                if($('#moneda').val() == 'PEN'){
                    preventa = response["preventa_pen"];
                    premin = response["preventamin_pen"];
                }else{
                    preventa = response["preventa_usd"];
                    premin = response["preventamin_usd"];
                }
                if({{ $rventa->tipo }} == 1){
                    $("#precio").val(preventa);
                    $("#prevta").val(preventa);
                    $("#premin").val(premin);
                }else{
                    $("#precio").val(Redondea(response["precompra"],2));
                    $("#prevta").val(Redondea(response["precompra"],2));
                    $("#premin").val(Redondea(response["precompra"],2));
                }
                $("#precompra").val(response["precompra"]);
                // $('#lblprecio').text('Precio >= ' + Redondea(response["preventamin"],2));
                $('#lblprecio').prop('title', 'Precio Mínimo con Descuento: ' + premin);//text('Precio >= ' + Redondea(response["preventamin"],2));
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

        $('#dias').blur(function(){
            var fecha = $('#fecha').val();
            $('#vencimiento').val(sumarDias(fecha,this.value));
        });

        $('#buscarl').keyup(function(){
            tabresultl(this.value);
        });

        $('#lote').blur(function(){
            if(this.value.length >= 1){
                // alert('Sale');
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
            const icbper = {{ session('icbper') }};
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
                if($('#bolsas').val() == 1){
                    $('#icbper').val(cantidad*icbper);
                }
                
            }
        });

        $('#precio').blur(function(){
            let precio = NaNToCero(parseFloat($('#precio').val()));
            const cantidad = NaNToCero(parseFloat($('#cantidad').val()));
            const premin = NaNToCero(parseFloat($('#premin').val()));
            const prevta = NaNToCero(parseFloat($('#prevta').val()));
            if(precio < premin){
                Swal.fire(
                    'Error',
                    'Precio de Venta es menor al Mínimo',
                    'error'
                    )
                this.value = prevta;
            }
            $('#subtotal').val(Redondea(cantidad * this.value, 2));
        });

        $('#agregar').click(function(){
            if($('#producto_id').val().length == 0){
                Swal.fire(
                    'Error',
                    'Seleccione un Producto | Servicio',
                    'error'
                    );
                return true;
            }
            if($('#cantidad').val().length == 0 || $('#cantidad').val() == 0){
                Swal.fire(
                    'Error',
                    'Ingrese Cantidad',
                    'error'
                    );
                return true;
            }
            if($('#precio').val().length == 0 || $('#precio').val() == 0){
                Swal.fire(
                    'Error',
                    'Ingrese Precio',
                    'error'
                    );
                return true;
            }
            let precompra;
            if($('#precompra').val().length == 0){
                precompra = null;
            }else{
                precompra = $('#precompra').val();
            }
            let icbper;
            if($('#icbper').val().length == 0){
                icbper = null;
            }else{
                icbper = $('#icbper').val();
            }
            let detvta = {
                'rventa_id' : $('#id').val(),
                'producto_id' : $('#producto_id').val(),
                'adicional' : $('#adicional').val(),
                'grupo' : $('#grupo').val(),
                'cantidad' : $('#cantidad').val(),
                'preprom' : precompra,
                'precio' : $('#precio').val(),
                'subtotal' : $('#subtotal').val(),
                'icbper' : icbper,
                'afectacion_id' : $('#afectacion_id').val(),
                'lote' :$('#lote').val(),
                'vence' : $('#vence').val()
            };
            let envio = JSON.stringify(detvta);
            $.get(url_global+"/admin/rventas/"+envio+"/additem/",function(response){
                vertotales();
                veritems();
                $('#producto_id').val(null);
                $('#producto_id').empty();
                $('#adicional').val(null);
                $('#grupo').val(1);
                $('#cantidad').val(null);
                $('#stock').val(null);
                $('#stocklote').val(null);
                $('#precompra').val(null);
                $('#precio').val(null);
                $('#subtotal').val(null);
                $('#icbper').val(null);
                $('#afectacion_id').val(null);
                $('#lote').val(null);
                $('#vence').val(null);
                
                Swal.fire(
                'Agregado',
                'Registro Agregado con Éxito',
                'success'
                );
            });
        });

        $('#detraccion').change(function(){
            if(this.value == 1){
                $('.detraccion').show();
            }else{
                $('.detraccion').hide();
                $('#detraccion_codigo').val(null);
                $('#detraccion_tasa').val(null);
                $('#detraccion_monto').val(null);
            }
        });

        $('#detraccion_codigo').change(function(){
            $.get(url_global+"/admin/detraccions/"+this.value+"/tasa/",function(response){
                var tasa = response;
                $('#detraccion_tasa').val(tasa);
                var totdetrac = 0.00;
                if($('#moneda').val() == 'PEN'){
                    totdetrac = Redondea($('#total').text()*(tasa/100),2);
                }else{
                    let mont = $('#total').text() * $('#tc').val();
                    totdetrac = Redondea(mont*(tasa/100),2);
                }
                $('#detraccion_monto').val(totdetrac);
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
				$.get(url_global+"/admin/rventas/"+id+"/destroyitem/",function(response){
                    vertotales();
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
        var rventa = {{ $rventa->id }};
        $.get(url_global+"/admin/rventas/"+rventa+"/tablaitem/",function(response){
            $('#tdetitem').empty();
            $('#tdetitem').html(response);
        });
    }

    function vertotales(){
        var rventa = {{ $rventa->id }};
        $.get(url_global+"/admin/rventas/"+rventa+"/tablatotales/",function(response){
            $('#ttotales').empty();
            $('#ttotales').html(response);
        });
    }

</script>
@endsection
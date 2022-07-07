{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Orden de Compra')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.ordcompras.index') }}"><i class="fas fa-file-import"></i> Orden de Compra</a>
	</li>
@endsection

@section('contenido')
    <div id="mensaje_error" class="alert alert-danger" style="display:none;">
        <strong id="contenido_error"></strong>
    </div>
	<div class="container-fluid">
		<div class="row" id = 'agregarcomprobante'>
            <div class="col-md-12">
                {!! Form::model($ordcompra,['route'=>['admin.ordcompras.update',$ordcompra], 'method'=>'put','files' => true]) !!}
				<div class="panelprin shadow">
                    <div class="headercontent">
						<h2 class="title"><i class="fas fa-file-import"></i> Orden de Compra</h2>
						<ul>
                            @if ($ordcompra->estado == 1)
                            <li>
                                {!! Form::submit('Guardar', ['class'=>'btn btn-convertir mt-1', 'id'=>'guardar']) !!}
                            </li>
                            <li>
                                <button type="button" id='finalizar' class="btn btn-convertir mt-1">Finalizar</button>
                            </li>
                            @endif
                            @if ($ordcompra->estado == 2)
                            <li>
                                <button type="button" id='autorizar' class="btn btn-convertir mt-1">Autorizar</button>
                            </li>
                            @endif
                            @if ($ordcompra->estado <> 1)
                            <li>
                                <a class="btn btn-convertir mt-1" href="{{ route('admin.ordcompras.abrir',$ordcompra) }}">
                                    Abrir
                                </a>
                            </li>
                            @endif
                            <li>
                                <a class="btn btn-convertir mt-1" href="{{ route('admin.pdf.ordcompra',$ordcompra) }}" target="_blank" datatoggle="tooltip" data-placement="top" title="Imprimir">
                                    <i class="fas fa-print"></i>
                                </a>
                            </li>
						</ul>
					</div>
                    {{-- {{ dd($ordcompra) }} --}}
					<div class="inside">
                        <div class="row">
                            <div class="col-md-2 form-group">
                                {!! Form::hidden('id', null, ['id'=>'id']) !!}
                                {!! Form::label('fpago', 'Forma Pago:') !!}
								{!! Form::select('fpago',[1=>'CONTADO',2=>'CRÉDITO'],null,['class'=>'custom-select activo']) !!}
							</div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('fecha', 'Fecha:') !!}
                                {!! Form::date('fecha', null, ['class'=>'form-control activo']) !!}
                            </div>
                            <div class="col-md-1 form-group">
                                {!! Form::label('dias', 'Días:') !!}
                                {!! Form::text('dias', null, ['class'=>'form-control numero activo','autocomplete'=>'off','disabled']) !!}
							</div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('vencimiento', 'Vencimiento:') !!}
                                {!! Form::date('vencimiento', null, ['class'=>'form-control activo','disabled']) !!}
							</div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('moneda', 'Moneda:') !!}
                                {!! Form::select('moneda',['PEN'=>'SOLES','USD'=>'DOLARES'],null,['class'=>'custom-select activo']) !!}
                            </div>
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        {!! Form::label('cotizacion', 'Cotizacion N°:') !!}
                                        {!! Form::text('cotizacion', null, ['class'=>'form-control mayuscula activo','maxlength'=>'15','autocomplete'=>'off']) !!}
                                    </div>
                                    <div class="col-md-6 form-group">
                                        {!! Form::label('numero', 'Número OC:') !!}
                                        {!! Form::text('numero', str_pad($ordcompra->id, 5, '0', STR_PAD_LEFT), ['class'=>'form-control mayuscula activo','maxlength'=>'15','autocomplete'=>'off','disabled']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5 form-group">
                                {!! Form::label('cliente_id', 'Proveedor:') !!}
                                <div class="row no-gutters">
                                    <div class="col-md-10">
                                        {!! Form::select('cliente_id',$clientes,null,['class'=>'custom-select activo','id'=>'cliente_id','placeholder'=>'']) !!}
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-block btn-convertir" type="button" id="addcliente" title="Agregar Cliente"><i class="fas fa-user-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 form-group">
                                {!! Form::label('detcliente_id', 'Cuenta:') !!}
								{!! Form::select('detcliente_id',$cuentas,null,['class'=>'custom-select activo', 'placeholder'=>'Selecione Cuenta']) !!}
							</div>
                            <div class="col-md-4 form-group">
                                {!! Form::label('contacto', 'Contacto:') !!}
                                {!! Form::text('contacto', null, ['class'=>'form-control mayuscula','autocomplete'=>'off']) !!}
							</div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                {!! Form::label('observaciones', 'Observaciones:') !!}
                                {!! Form::textarea('observaciones',null,['class'=>'form-control mayuscula', 'rows'=>'3', 'id'=>'editor']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 form-group">
                                {!! Form::label('creado', 'Creado Por:') !!}
								{!! Form::select('creado',$users,null,['class'=>'custom-select activo', 'placeholder'=>'Creado por','disabled']) !!}
							</div>
                            <div class="col-md-3 form-group">
                                {!! Form::label('solicitado', 'Solicitado Por:') !!}
								{!! Form::select('solicitado',$users,null,['class'=>'custom-select activo', 'placeholder'=>'Solicitado por']) !!}
							</div>
                            <div class="col-md-3 form-group">
                                {!! Form::label('autorizado', 'Autorizado Por:') !!}
								{!! Form::select('autorizado',$users,null,['class'=>'custom-select activo', 'placeholder'=>'Autorizado por','disabled']) !!}
							</div>
                            <div class="col-md-1 form-group">
                                {!! Form::label('ajuste', 'Ajuste:') !!}
                                {!! Form::text('ajuste', null, ['class'=>'form-control decimal','autocomplete'=>'off']) !!}
							</div>
                        </div>
					</div>				
				</div>
                {!! Form::close() !!}
			</div>
		</div>
        <div class="row mtop16 oculto" id = 'agregarcliente'>
            <div class="col-md-12">
                {!! Form::open(['route'=>'admin.clientes.store', 'id'=>'formcliente']) !!}
                <div class="panelprin shadow">
                    <div class="headercontent">
                        <h2 class="title"><i class="far fa-address-card"></i> Agregar Cliente</h2>
                        <ul>
                            <li>
                                <button type="button" id='storecliente' class="btn btn-convertir mt-2" datatoggle="tooltip" data-placement="top" title="Guardar"><i class="fas fa-check"></i> Guardar</button>
                            </li>
                            <li>
                                <button type="button" id='cancelcliente' class="btn btn-convertir mt-2" datatoggle="tooltip" data-placement="top" title="Descartar"><i class="far fa-times-circle"></i> Descartar</button>
                            </li>
                        </ul>
                    </div>
                    <div class="inside">
                        <div class="alert alert-warning oculto" role="alert" id = 'buscando'>
                            Buscando número de documento
                        </div>
						<div class="row">
							<div class="col-md-4 form-group">
                                {!! Form::label('tipdoc_id', 'Tipo documento:') !!}
								{!! Form::select('tipdoc_id',$tipdoc,'6',['class'=>'custom-select']) !!}
							</div>
							<div class="col-md-2 form-group">
                                {!! Form::label('numdoc', 'Número documento:') !!}
								{!! Form::text('numdoc', null, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-6 form-group">
                                {!! Form::label('razsoc', 'Razón social:') !!}
								{!! Form::text('razsoc', null, ['class'=>'form-control mayuscula','autocomplete'=>'off']) !!}
							</div>
						</div>
						<div class="row">
							<div class="col-md-4 form-group">
                                {!! Form::label('ape_pat', 'Apellido Paterno:') !!}
								{!! Form::text('ape_pat', null, ['class'=>'form-control mayuscula','autocomplete'=>'off', 'disabled']) !!}
							</div>
							<div class="col-md-4 form-group">
                                {!! Form::label('ape_mat', 'Apellido Materno:') !!}
								{!! Form::text('ape_mat', null, ['class'=>'form-control mayuscula','autocomplete'=>'off', 'disabled']) !!}
							</div>
							<div class="col-md-4 form-group">
                                {!! Form::label('nombres', 'Nombres:') !!}
								{!! Form::text('nombres', null, ['class'=>'form-control mayuscula','autocomplete'=>'off', 'disabled']) !!}
							</div>
						</div>
						<div class="row">							
							<div class="col-md-6 form-group">
                                {!! Form::label('nomcomercial', 'Nombre comercial:') !!}
								{!! Form::text('nomcomercial', null, ['class'=>'form-control mayuscula','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-6 form-group">
                                {!! Form::label('contacto', 'Contacto:') !!}
								{!! Form::text('contacto', null, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
						</div>
						<div class="row">							
							<div class="col-md-4 form-group">
                                {!! Form::label('dircliente', 'Dirección:') !!}
								{!! Form::text('dircliente', null, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-4 form-group">
                                {!! Form::label('email', 'E-mail:') !!}
								{!! Form::text('email', null, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-2 form-group">
                                {!! Form::label('celular', 'Celular:') !!}
								{!! Form::text('celular', null, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-2 form-group">
                                {!! Form::label('telefono', 'Teléfono:') !!}
								{!! Form::text('telefono', null, ['class'=>'form-control','autocomplete'=>'off']) !!}
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
                        {!! Form::open(['route'=>'admin.ordcompras.additem', 'id'=>'formdetalle']) !!}
                        <div class="row">
                            <div class="col-md-4 form-group">
                                {!! Form::hidden('ordcompra_id', $ordcompra->id, ['id'=>'ordcompra_id']) !!}
                                {!! Form::hidden('iddet', null, ['id'=>'iddet']) !!}
                                {!! Form::hidden('tipo', 1, ['id'=>'tipo']) !!}
                                {!! Form::label('producto_id', 'Producto:') !!}
                                {!! Form::select('producto_id',[],null,['class'=>'custom-select','placeholder'=>'']) !!}
                            </div>
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        {!! Form::label('cantidad', 'Cantidad:') !!}
                                        {!! Form::text('cantidad', null, ['class'=>'form-control decimal subtotal','id'=>'cantidad']) !!}
                                    </div>
                                    <div class="col-md-6 form-group">
                                        {!! Form::label('pre_ini', 'Precio Inicial:') !!}
                                        {!! Form::text('pre_ini', null, ['class'=>'form-control decimal subtotal','id'=>'pre_ini']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        {!! Form::label('igv', 'IGV:') !!}
                                        {!! Form::select('igv',['1'=>'Incluído','2'=>'No Incluído'],null,['class'=>'custom-select subtotal','id'=>'igv']) !!}
                                    </div>
                                    <div class="col-md-4 form-group">
                                        {!! Form::label('precio', 'Precio:') !!}
                                        {!! Form::text('precio', null, ['class'=>'form-control decimal subtotal','id'=>'precio']) !!}
                                    </div>
                                    <div class="col-md-4 form-group">
                                        {!! Form::label('subtotal', 'SubTotal:') !!}
                                        {!! Form::text('subtotal', null, ['class'=>'form-control decimal','id'=>'subtotal','disabled']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                {!! Form::label('glosa', 'Glosa:') !!}
                                {!! Form::textarea('glosa',null,['class'=>'form-control mayuscula', 'rows'=>'3']) !!}
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
        if($('#fpago').val() == 1){
            $('#dias').prop('disabled',true);
            $('#vencimiento').prop('disabled',true);
        }else{
            $('#dias').prop('disabled',false);
            $('#vencimiento').prop('disabled',false);
        }

        veritems();

        $('#cliente_id').select2({
            placeholder:"Ingrese 4 dígitos del RUC o Razón Social",
            minimumInputLength: 4,
            ajax:{
                url: "{{ route('admin.clientes.seleccionado',1) }}",
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

        $('#cliente_id').on('select2:close',function(){
            var cliente = this.value;
            $.get(url_global+"/admin/clientes/"+cliente+"/cuentas/",function(response){
                // alert(response[0].banco.nombre);
                $('#detcliente_id').empty();
                for(i=0;i<response.length;i++){
                    $('#detcliente_id').append("<option value='"+response[i].id+"'>"
                        + response[i].banco.nombre + ' ' + response[i].cuenta
                        + "</option>");
                }
                $('#detcliente_id').val(null);
            });
        });

        $('#finalizar').click(function(){
            var id = $('#id').val();
            Swal.fire({
            title: 'Está Seguro que desea Finalizar la Orden de Compra?',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '¡Si, realizar!',
            cancelButtonText: 'Cancelar'
            }).then((result) => {
            if (result.value) {
                $.get(url_global+"/admin/ordcompras/"+id+"/finalizar/",function(response){
                    location.reload();
                });
            }
            })            
        });

        $('#autorizar').click(function(){
            var id = $('#id').val();
            Swal.fire({
            title: 'Está Seguro que desea Autorizar la Orden de Compra?',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '¡Si, realizar!',
            cancelButtonText: 'Cancelar'
            }).then((result) => {
            if (result.value) {
                $.get(url_global+"/admin/ordcompras/"+id+"/autorizar/",function(response){
                    location.reload();
                });
            }
            })            
        });

        $('#fpago').change(function(){
            if(this.value == 1){
                $('#dias').prop('disabled',true);
                $('#dias').val(null);
                $('#vencimiento').prop('disabled',true);
                $('#vencimiento').val(null);
            }else{
                $('#dias').prop('disabled',false);
                $('#vencimiento').prop('disabled',false);
            }
        });

        $('#dias').blur(function(){
            var fecha = $('#fecha').val();
            $('#vencimiento').val(sumarDias(fecha,this.value));
        });

        $('#fecha').blur(function(){
            if($('#fpago').val() == 1){
                $('#vencimiento').val(null);
            }else{
                var dias = $('#dias').val();
                $('#vencimiento').val(sumarDias(this.value,dias));
            }
        });
        
        $('#guardar').click(function(){
            $('.activo').prop('disabled',false);
        });

        $('#addcliente').click(function(){
            $('#agregarcliente').show();
            $('#agregarcomprobante').hide();
        });

        $('#cancelcliente').click(function(){
            $('#agregarcliente').hide();
            $('#agregarcomprobante').show();
        });

        // Inicio Agregar Cliente
        $('#storecliente').click(function(e){
            e.preventDefault();
            $('#razsoc').prop('disabled', false);
            $('#ape_pat').prop('disabled', false);
            $('#ape_mat').prop('disabled', false);
            $('#nombres').prop('disabled', false);
            // $("#sexo_id").prop('disabled', false);
            // $("#estciv_id").prop('disabled', false);
            $.ajax({
                url: "{{ route('admin.clientes.storeAjax') }}",
                type: "POST",
                async: true,
                data: $('#formcliente').serialize(),
                
                success: function(respuesta){
                    var data = {
                        id: respuesta.id,
                        text: respuesta.numdoc+'-'+respuesta.razsoc
                    };
                    var newOption = new Option(data.text, data.id, false, false);
                    $('#cliente_id').append(newOption).trigger('change');
                    $('#cliente_id').val(respuesta.id);
                    $('#agregarcliente').hide();
                    $('#agregarcomprobante').show();
                },
                error: function(error){
                    if ($('#tipdoc_id').val() == '6' || $('#tipdoc_id').val() == '0') {
                        $("#ape_pat").prop('disabled', true);
                        $("#ape_mat").prop('disabled', true);
                        $("#nombres").prop('disabled', true);
                        $("#razsoc").prop('disabled', false);
                        // $("#sexo_id").prop('disabled', true);
                        // $("#estciv_id").prop('disabled', true);
                    } else {
                        $("#ape_pat").prop('disabled', false);
                        $("#ape_mat").prop('disabled', false);
                        $("#nombres").prop('disabled', false);
                        $("#razsoc").prop('disabled', true);
                        // $("#sexo_id").prop('disabled', false);
                        // $("#estciv_id").prop('disabled', false);
                    }
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

        $('#numdoc').blur(function(){
            var td = $('#tipdoc_id').val();
            var numdoc = this.value;
            var entidad = '';
            var mensaje = 1;
            let repetido = 0;

            if (td == '1') {
                entidad = 'RENIEC';
            }
            if (td == '6') {
                entidad = 'SUNAT';
            }
            if (numdoc.length != 0) {
                if (td == '1' && numdoc.length != 8) {
                    mensaje = 0;
                    this.focus();
                    Swal.fire(
                        'Error!',
                        'DNI debe contener 8 dígitos!',
                        'error'
                        );
                    return true;
                }

                if (td == '6' && numdoc.length != 11) {
                    mensaje = 0;
                    this.focus();
                    Swal.fire(
                        'Error!',
                        'RUC debe contener 11 dígitos!',
                        'error'
                        );
                    return true;
                }
                
                if (td == '1' || td == '6') {
                    $('#buscando').show();
                    $.get(url_global+"/admin/clientes/"+td+"/"+numdoc+"/0/busapi/",function(response){
                        $('#buscando').hide();
                        if(response['success'] == false){
                            Swal.fire(
                                'Error!',
                                'Documento no existe en la Base de datos de ' + entidad,
                                'error'
                                )
                        }else if(response == 'REPETIDO'){
                            Swal.fire(
                                'Error!',
                                'Número de documento ya se encuentra registrado',
                                'error'
                                )
                        }else{
                            if (td == '1') {
                                $('#ape_pat').val(response['apellidoPaterno']);                                
                                $('#ape_mat').val(response['apellidoMaterno']);                                
                                $('#nombres').val(response['nombres']);

                                $('#razsoc').val(
                                    response['apellidoPaterno'] + ' ' 
                                    + response['apellidoMaterno'] + ' '
                                    + response['nombres']
                                    );
                                
                                    $('#nomcomercial').val(
                                    response['apellidoPaterno'] + ' ' 
                                    + response['apellidoMaterno'] + ' '
                                    + response['nombres']
                                    );
                            }
                            if (td == '6') {
                                $('#nomcomercial').val(response['razonSocial']);
                                if(numdoc.substr(0,2) == '20'){
                                    $('#ape_pat').prop('disabled', true);
                                    $('#ape_mat').prop('disabled', true);
                                    $('#nombres').prop('disabled', true);
                                    $('#ape_pat').val(null);
                                    $('#ape_mat').val(null);
                                    $('#nombres').val(null);
                                    $('#dircliente').val(response['direccion']);
                                    $('#razsoc').val(response['razonSocial']);
                                } else {
                                    $('#dircliente').val(null);
                                    var razsoc = response['razonSocial'];
                                    var espacio1 = razsoc.indexOf(" ");
                                    var espacio2 = razsoc.indexOf(" ",espacio1+1);
                                    $('#ape_pat').val(razsoc.substr(0,espacio1));
                                    $('#ape_mat').val(razsoc.substr(espacio1+1,espacio2-espacio1));
                                    $('#nombres').val(razsoc.substr(espacio2+1));
                                    $('#razsoc').val(response['razonSocial']);
                                    $('#ape_pat').prop('disabled', false);
                                    $('#ape_mat').prop('disabled', false);
                                    $('#nombres').prop('disabled', false);
                                }                            
                            }
                        }
                    });
                }
                
            }
        });

        $('#tipdoc_id').change(function(){
            $('#numdoc').val(null);
            $("#razsoc").val(null);
            $("#ape_pat").val(null);
            $("#ape_mat").val(null);
            $("#nombres").val(null);
            $("#nomcomercial").val(null);
            if (this.value == '6' || this.value == '0') {
                $("#ape_pat").prop('disabled', true);
                $("#ape_mat").prop('disabled', true);
                $("#nombres").prop('disabled', true);
                $("#razsoc").prop('disabled', false);
                // $("#sexo_id").prop('disabled', true);
                // $("#estciv_id").prop('disabled', true);
            } else {
                $("#ape_pat").prop('disabled', false);
                $("#ape_mat").prop('disabled', false);
                $("#nombres").prop('disabled', false);
                $("#razsoc").prop('disabled', true);
                // $("#sexo_id").prop('disabled', false);
                // $("#estciv_id").prop('disabled', false);
            }
        });

        $('#razsoc').blur(function(){
            $('#nomcomercial').val(this.value);
        });
        // Fin Agregar Cliente

        // $('#cantidad').blur(function(){
        //     var cantidad = NaNToCero($('#cantidad').val());
        //     var precio = NaNToCero($('#precio').val());
        //     $('#subtotal').val(Redondea(cantidad*precio,2))
        // });

        // $('#precio').blur(function(){
        //     var cantidad = NaNToCero($('#cantidad').val());
        //     var precio = NaNToCero($('#precio').val());
        //     $('#subtotal').val(Redondea(cantidad*precio,2))
        // });

        $('.subtotal').blur(function(){
            const cantidad = NaNToCero($('#cantidad').val());
            const pre_ini = NaNToCero($('#pre_ini').val());
            const igv = NaNToCero($('#igv').val());
            const porigv = {{ session('igv') }} / 100;
            if (pre_ini > 0) {
                if(igv == 1){
                    $('#precio').val(Redondea(pre_ini / (1+porigv),6));
                }else{
                    $('#precio').val(pre_ini);
                }
                $('#subtotal').val(Redondea(cantidad * $('#precio').val(),6));
            }
        });

        $('#add').click(function(){
            $('#subtotal').prop('disabled',false);
            $.ajax({
                url: "{{ route('admin.ordcompras.additem') }}",
                type: "POST",
                async: true,
                data: $('#formdetalle').serialize(),                
                success: function(respuesta){
                    $('#producto_id').val(null);
                    $('#cantidad').val(null);
                    $('#pre_ini').val(null);
                    $('#igv').val(1);
                    $('#precio').val(null);
                    $('#subtotal').val(null);
                    $('#glosa').val(null);
                    $('#aeitem').hide();
                    veritems();
                    $('#detalles').show();
                    $('#subtotal').prop('disabled',true);
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
            $('#pre_ini').val(null);
            $('#igv').val(1);
            $('#precio').val(null);
            $('#subtotal').val(null);
            $('#glosa').val(null);
            $('#subtotal').prop('disabled',true);
        });

    });

    function veritems(){
		var id = $('#id').val();
		$.get(url_global+"/admin/ordcompras/"+id+"/tablaitem/",function(response){
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
				$.get(url_global+"/admin/ordcompras/"+id+"/destroyitem/",function(response){
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

    function edititem(id) {
        $.get(url_global+"/admin/ordcompras/"+id+"/edititem/",function(response){
            $('#detalles').hide();
            $('#aeitem').show();
            $('#ordcompra_id').val(response.ordcompra_id);
            $('#iddet').val(response.id);
            $('#tipo').val(2);
            $('#producto_id').select2({
                placeholder:"Ingrese 4 dígitos del Nombre del Producto",
                minimumInputLength: 4,
                ajax:{
                    url: "{{ route('admin.productos.seleccionadot') }}",
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
            var data = {
                id: response.producto_id,
                text: response.producto.nombre
            };
            var newOption = new Option(data.text, data.id, false, false);
            $('#producto_id').append(newOption).trigger('change');
            $('#producto_id').val(response.producto_id);

            $('#cantidad').val(response.cantidad);
            $('#pre_ini').val(response.pre_ini);
            $('#igv').val(response.igv);
            $('#precio').val(response.precio);
            $('#subtotal').val(response.subtotal);
            $('#glosa').val(response.glosa);
        })
    }

</script>
@endsection
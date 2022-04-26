{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Registro de Ventas')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.rventas.index') }}"><i class="fas fa-cash-register"></i> Registro de Ventas</a>
	</li>
@endsection

@section('contenido')
    <div id="mensaje_error" class="alert alert-danger" style="display:none;">
        <strong id="contenido_error"></strong>
    </div>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
                {!! Form::open(['route'=>'admin.rventas.store','id'=>'formcomprobante']) !!}
				<div class="panelprin shadow">
                    <div class="headercontent">
						<h2 class="title"><i class="fas fa-cash-register"></i> Registro de Ventas</h2>
						<ul>
                            <li>
                                {!! Form::submit('Generar Comprobante', ['class'=>'btn btn-convertir mt-2 oculto', 'id'=>'guardar']) !!}
                            </li>
                            <li>
                                <button type="button" id='finalizar' class="btn btn-convertir mt-2">Finalizar</button>
                            </li>
                            <li>
                                <button type="button" id='continuar' class="btn btn-convertir mt-2 oculto">Continuar</button>
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
                            <div class="col-md-2 form-group">
                                {!! Form::label('tipocomprobante_codigo', 'Tipo Comprobante:') !!}
                                {!! Form::select('tipocomprobante_codigo',$tipocomprobante,null,['class'=>'custom-select activo','placeholder'=>'Elija Comprobante',]) !!}
                            </div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('fecha', 'Fecha:') !!}
                                {!! Form::date('fecha', Carbon\Carbon::now(), ['class'=>'form-control activo']) !!}
                            </div>
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        {!! Form::label('moneda', 'Moneda:') !!}
                                        {!! Form::select('moneda',['PEN'=>'SOLES','USD'=>'DOLARES'],1,['class'=>'custom-select activo']) !!}
                                    </div>
                                    <div class="col-md-6 form-group">
                                        {!! Form::label('tc', 'TC:') !!}
                                        {!! Form::text('tc', null, ['class'=>'form-control decimal activo','autocomplete'=>'off']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 form-group">
                                {!! Form::label('cliente_id', 'Cliente:') !!}
                                <div class="row no-gutters">
                                    <div class="col-md-10">
                                        {!! Form::select('cliente_id',[],null,['class'=>'custom-select activo','id'=>'cliente_id','placeholder'=>'']) !!}
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-convertir" type="button" id="addcliente" title="Agregar Cliente"><i class="fas fa-user-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row finalizar">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="row">
                                            <div class="col-md-5 form-group">
                                                {!! Form::label('fpago', 'Forma Pago:') !!}
                                                {!! Form::select('fpago',[1=>'CONTADO',2=>'CRÉDITO'],null,['class'=>'custom-select activo']) !!}
                                            </div>
                                            <div class="col-md-2 form-group">
                                                {!! Form::label('dias', 'Días:') !!}
                                                {!! Form::text('dias', null, ['class'=>'form-control numero activo credito','autocomplete'=>'off','disabled']) !!}
                                            </div>
                                            <div class="col-md-5 form-group">
                                                {!! Form::label('vencimiento', 'Vencimiento:') !!}
                                                {!! Form::date('vencimiento', null, ['class'=>'form-control activo credito','disabled']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="row">
                                            <div class="col-md-5 form-group">
                                                {!! Form::label('mediopago', 'Medio Pago:') !!}
                                                {!! Form::select('mediopago',$mediopago,session('mediopago'),['class'=>'custom-select activo contado','placeholder'=>'']) !!}
                                            </div>
                                            <div class="col-md-4 form-group">
                                                {!! Form::label('cuenta_id', 'Cuenta:') !!}
                                                {!! Form::select('cuenta_id',$cuenta,session('cuenta'),['class'=>'custom-select activo contado','id'=>'cuenta_id','placeholder'=>'']) !!}
                                            </div>
                                            <div class="col-md-3 form-group">
                                                {!! Form::label('numerooperacion', 'N° Operación:') !!}
                                                {!! Form::text('numerooperacion', numeroOperacion(Carbon\Carbon::now()), ['class'=>'form-control activo contado','maxlength'=>'15','autocomplete'=>'off']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row finalizar">
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-md-10 form-group">
                                        {!! Form::label('direccion', 'Direccion:') !!}
                                        {!! Form::text('direccion', null, ['class'=>'form-control activo','autocomplete'=>'off']) !!}
                                    </div>
                                    <div class="col-md-2 form-group">
                                        {!! Form::label('detraccion', 'Detracción:') !!}
                                        {!! Form::select('detraccion',[1=>'SI',2=>'NO'],2,['class'=>'custom-select activo']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <table class="table table-responsive-md table-bordered table-estrecha-ventas">
                                    <thead>
                                        <tr>
                                            <th width='33%' class="text-center azul">TOTAL</th>
                                            <th width='33%' class="text-center verde">PAGA CON</th>
                                            <th width='33%' class="text-center rojo">VUELTO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th class="text-center align-middle azul">
                                                <span id='totaldoc'></span>
                                            </th>
                                            <td>
                                                {!! Form::text('pagacon', null, ['class'=>'form-control verde decimal activo contado','id'=>'pagacon','autocomplete'=>'off']) !!}
                                            </td>
                                            <th class="text-center align-middle rojo">
                                                <span id='vuelto'></span>
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row finalizar">
                            <div class="col-md-6 form-group">
                                {!! Form::label('detalle', 'Observaciones:') !!}
                                {!! Form::text('detalle', null, ['class'=>'form-control activo','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-3 form-group detraccion">
                                {!! Form::label('detraccion_codigo', 'Código Detracción:') !!}
                                {!! Form::select('detraccion_codigo',$detraccions,null,['class'=>'custom-select activo','placeholder'=>'']) !!}
                            </div>
                            <div class="col-md-1 form-group detraccion">
                                {!! Form::label('detraccion_tasa', 'Tasa:') !!}
                                {!! Form::text('detraccion_tasa', null, ['class'=>'form-control decimal activo','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-2 form-group detraccion">
                                {!! Form::label('detraccion_monto', 'Monto S/:') !!}
                                {!! Form::text('detraccion_monto', null, ['class'=>'form-control decimal activo','autocomplete'=>'off']) !!}
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
							<div class="col-md-2 form-group">
                                {!! Form::label('fecnac', 'Fecha nacimiento:') !!}
								{!! Form::date('fecnac', null, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-2 form-group">
                                {!! Form::label('sexo_id', 'Sexo:') !!}
                                {!! Form::select('sexo_id',$sexo,null,['class'=>'custom-select','placeholder'=>'','disabled']) !!}
							</div>
							<div class="col-md-2 form-group">
                                {!! Form::label('estciv_id', 'Estado Civil:') !!}
                                {!! Form::select('estciv_id',$estciv,null,['class'=>'custom-select','placeholder'=>'','disabled']) !!}
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
                                        {!! Form::select('grupo',[1=>'Producto',2=>'Servicio'],1,['class'=>'custom-select']) !!}
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
                            <div class="col-md-3 form-group">
                                {!! Form::label('afectacion_id', 'Afectación:') !!}
                                {!! Form::select('afectacion_id',$afectaciones,null,['class'=>'custom-select']) !!}
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
                            <div class="col-md-4">
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

        $('.add').hide();
        $('.finalizar').hide();
        $('.detraccion').hide();
        // $('#guardar').hide();

        if($('#detraccion').val() == 1){
            $('.detraccion').show();
        }else{
            $('.detraccion').hide();
        }

        $('#addcliente').click(function(){
            $('#agregarcliente').show();
        });

        $('#cancelcliente').click(function(){
            $('#agregarcliente').hide();
        });

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

        $('#cliente_id').on('select2:close',function(){
            $.get(url_global+"/admin/clientes/"+this.value+"/valores/",function(response){
                $('#direccion').val(response['direccion']);
            });
        });

        // Inicio Agregar Cliente
        $('#storecliente').click(function(e){
            e.preventDefault();
            $('#razsoc').prop('disabled', false);
            $('#ape_pat').prop('disabled', false);
            $('#ape_mat').prop('disabled', false);
            $('#nombres').prop('disabled', false);
            $("#sexo_id").prop('disabled', false);
            $("#estciv_id").prop('disabled', false);
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
                    $('#direccion').val(respuesta.direccion);
                    if (respuesta.tipdoc_id == '6') {
                        $('#tipocomprobante_codigo').val('01')
                    } else {
                        $('#tipocomprobante_codigo').val('03')
                    }
                    $('#agregarcliente').hide();
                },
                error: function(error){
                    if ($('#tipdoc_id').val() == '6' || $('#tipdoc_id').val() == '0') {
                        $("#ape_pat").prop('disabled', true);
                        $("#ape_mat").prop('disabled', true);
                        $("#nombres").prop('disabled', true);
                        $("#razsoc").prop('disabled', false);
                        $("#sexo_id").prop('disabled', true);
                        $("#estciv_id").prop('disabled', true);
                    } else {
                        $("#ape_pat").prop('disabled', false);
                        $("#ape_mat").prop('disabled', false);
                        $("#nombres").prop('disabled', false);
                        $("#razsoc").prop('disabled', true);
                        $("#sexo_id").prop('disabled', false);
                        $("#estciv_id").prop('disabled', false);
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
                $("#sexo_id").prop('disabled', true);
                $("#estciv_id").prop('disabled', true);
            } else {
                $("#ape_pat").prop('disabled', false);
                $("#ape_mat").prop('disabled', false);
                $("#nombres").prop('disabled', false);
                $("#razsoc").prop('disabled', true);
                $("#sexo_id").prop('disabled', false);
                $("#estciv_id").prop('disabled', false);
            }
        });

        $('#razsoc').blur(function(){
            $('#nomcomercial').val(this.value);
        });
        // Fin Agregar Cliente
        
        $('#guardar').click(function(e){
            $('.activo').prop('disabled',false);
            $('#agregarcliente').hide();
            e.preventDefault();
            if ($('#moneda').val() == 'PEN' ) {
                var total = NaNToCero(parseFloat($('#total').text()));
            } else {
                var total = Redondea(NaNToCero(parseFloat($('#total').text())) * $('#tc').val(),2);
            }
            var maximo = {{ session('maximoboleta') }};
            if (total > maximo && ($('#cliente_id').val() == 1 || Empty($('#cliente_id').val()))){
                let html = 'Se encontraron los siguientes errores:';
                html += "<ul>";
                html += "<li>"+ 'Total excede S/ ' + maximo + ', es necesario identificar Cliente' +"</li>";
                html += "</ul>";
                $('#contenido_error').html(html);
                $('#mensaje_error').slideDown();
                setTimeout(function(){ $('#mensaje_error').slideUp(); }, 3000);
                $('#periodo').prop('disabled',true);
                if($('#fpago').val() == 1){
                    $('.contado').prop('disabled',false);
                    $('.credito').prop('disabled',true);
                }else{
                    $('.contado').prop('disabled',true);
                    $('.credito').prop('disabled',false);
                }
                if($('#detraccion').val() == 1){
                    $('.detraccion').show();
                }else{
                    $('.detraccion').hide();
                }
                return true;
            }
            $.ajax({
                url: "{{ route('admin.rventas.store') }}",
                type: "POST",
                async: true,
                data: $('#formcomprobante').serialize(),
                
                success: function(respuesta){
                    if (respuesta['status'] == 3) {
                        let html = 'Se encontraron los siguientes errores:';
                        html += "<ul>";
                        html += "<li>"+ respuesta['cdr'] +"</li>";
                        html += "<li>"+ 'El documento se anulará, revise su información y vuelva a generar' +"</li>";
                        html += "</ul>";
                        $('#contenido_error').html(html);
                        $('#mensaje_error').slideDown();
                        setTimeout(function(){ $('#mensaje_error').slideUp();location.reload(); }, 5000);
                        // location.reload();
                    } else {
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
                    }
                },
                error: function(error){
                    $('#periodo').prop('disabled',true);
                    if($('#fpago').val() == 1){
                        $('.contado').prop('disabled',false);
                        $('.credito').prop('disabled',true);
                    }else{
                        $('.contado').prop('disabled',true);
                        $('.credito').prop('disabled',false);
                    }
                    if($('#detraccion').val() == 1){
                        $('.detraccion').show();
                    }else{
                        $('.detraccion').hide();
                    }
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
            if ($('#fpago').val() == 1) {
                $('#numerooperacion').val(numeroOperacion(this.value));
            } else {
                let fecha = this.value;
                let dias = $('#dias').val();
                $('#vencimiento').val(sumarDias(fecha,dias));
            }
        });

        $('#descartar').click(function(){
            $('.add').hide();
            limpiaDetalle();
            $('#grupo').val(1);
            $('#adddetvta').show();
        });

        $('#buslote').prop('disabled',true);

        veritems();

        if($('#fpago').val() == 1){
            $('.contado').prop('disabled',false);
            $('.credito').prop('disabled',true);
        }else{
            $('.contado').prop('disabled',true);
            $('.credito').prop('disabled',false);
        }

        $('#pagacon').blur(function(){
            if ($('#total').text() > Number(this.value)) {
                Swal.fire(
                    'Error',
                    'Importe Ingresado es menor que el Total',
                    'error'
                    )
                this.value = null;
            }else{
                $('#vuelto').text(NumberFormat(this.value - $('#total').text(),2));
            }
        });

        if ($('#fpago').val() == 1) {
            $('.contado').prop('disabled',false);
            $('.credito').prop('disabled',true);
            $('#dias').val(null);
            $('#vencimiento').val(null);

        } else {
            $('.contado').prop('disabled',true);
            $('.credito').prop('disabled',false);
            $('#pagacon').val(null);
            $('#vuelto').val(null);
            $('#mediopago').val(null);
            $('#cuenta_id').val(null);
            $('#numerooperacion').val(null);
        }

        $('#fpago').change(function(){
            if (this.value == 1) {
                $('.contado').prop('disabled',false);
                $('.credito').prop('disabled',true);
                $('#dias').val(null);
                $('#vencimiento').val(null);
                $('#mediopago').val('{{ session('mediopago') }}');
                $('#cuenta_id').val({{ session('cuenta') }});
                $('#numerooperacion').val(numeroOperacion($('#fecha').val()));
            } else {
                $('.contado').prop('disabled',true);
                $('.credito').prop('disabled',false);
                $('#pagacon').val(null);
                $('#vuelto').val(null);
                $('#mediopago').val(null);
                $('#cuenta_id').val(null);
                $('#numerooperacion').val(null);
            }
        });
        
        $('#finalizar').click(function(){
            $('#agregarcliente').hide();
            if ($('#items').text() == 0){
                let html = 'Se encontraron los siguientes errores:';
                html += "<ul>";
                html += "<li>"+ 'Aun no se han ingresado Productos | Servicios' +"</li>";
                html += "</ul>";
                $('#contenido_error').html(html);
                $('#mensaje_error').slideDown();
                setTimeout(function(){ $('#mensaje_error').slideUp(); }, 3000);
                return true;
            }
            if ($('#moneda').val() == 'PEN' ) {
                var total = NaNToCero(parseFloat($('#total').text()));
            } else {
                var total = Redondea(NaNToCero(parseFloat($('#total').text())) * $('#tc').val(),2);
            }
            var maximo = {{ session('maximoboleta') }};
            if (total > maximo && ($('#cliente_id').val() == 1 || Empty($('#cliente_id').val()))){
                let html = 'Se encontraron los siguientes errores:';
                html += "<ul>";
                html += "<li>"+ 'Total excede S/ ' + maximo + ', es necesario identificar Cliente' +"</li>";
                html += "</ul>";
                $('#contenido_error').html(html);
                $('#mensaje_error').slideDown();
                setTimeout(function(){ $('#mensaje_error').slideUp(); }, 3000);
                return true;
            }
            $('#adddetvta').hide();
            $('#totaldoc').text(NumberFormat($('#total').text(),2));
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

        // if ($('#fin').val() == 1) {
        //     $('.finalizar').show();
        //     $('#finalizar').hide();
        //     $('#adddetvta').hide();
        //     $('#guardar').show();
        // }

        $('#grupo').change(function(){
            $('#producto_id').val(null);
            $('#producto_id').select2({
                placeholder:"Ingrese 4 dígitos del Nombre del Producto",
                minimumInputLength: 4,
                ajax:{
                    url: "{{ route('admin.productos.seleccionadov') }}"+'/'+$('#moneda').val()+'/'+$('#grupo').val(),
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
            limpiaDetalle();

        });

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
                $("#precio").val(preventa);
                $("#prevta").val(preventa);
                $("#premin").val(premin);
                $("#precompra").val(response["precompra"]);
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
                url: "{{ route('admin.rventas.additem') }}",
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
                let total = NaNToCero(parseFloat($('#total').text()));
                $('#detraccion_tasa').val(tasa);
                var totdetrac = 0.00;
                if($('#moneda').val() == 'PEN'){
                    totdetrac = Redondea(total*(tasa/100),2);
                }else{
                    let mont = total * $('#tc').val();
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
        $.get(url_global+"/admin/rventas/"+key+"/"+moneda+"/tablaitem/",function(response){
            $('#tdetitem').empty();
            $('#tdetitem').html(response);
        });
    }

    function vertotales(){
        var rventa = 1;
        $.get(url_global+"/admin/rventas/"+rventa+"/tablatotales/",function(response){
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
        $('#icbper').val(null);
        $('#icbper').prop('disabled',true);
        $('#afectacion_id').val(null);
        $('#lote').val(null);
        $('#lote').prop('disabled',true);
        $('#vence').val(null);
        $('#vence').prop('disabled',true);
    }
</script>
@endsection
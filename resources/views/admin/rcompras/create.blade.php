{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Registro de Compras | Servicios')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.rcompras.index') }}"><i class="fas fa-cart-plus"></i> Registro de Compras | Servicios</a>
	</li>
@endsection

@section('contenido')
    <div id="mensaje_error" class="alert alert-danger" style="display:none;">
        <strong id="contenido_error"></strong>
    </div>
	<div class="container-fluid">
		<div class="row"  id = 'agregarcomprobante'>
            <div class="col-md-12">
                {!! Form::open(['route'=>'admin.rcompras.store']) !!}
				<div class="panelprin shadow">
                    <div class="headercontent">
						<h2 class="title"><i class="fas fa-cart-plus"></i> Registro de Compras | Servicios</h2>
						<ul>
                            <li>
                                {!! Form::submit('Guardar', ['class'=>'btn btn-convertir mt-2', 'id'=>'guardar']) !!}
                            </li>
						</ul>
					</div>
					<div class="inside">
                        {!! Form::hidden('empresa_id', session('empresa')) !!}
                        {!! Form::hidden('sede_id', session('sede')) !!}
                        <div class="row">
                            <div class="col-md-1 form-group">
                                {!! Form::label('periodo', 'Periodo:') !!}
								{!! Form::text('periodo', session('periodo'), ['class'=>'form-control activo','disabled']) !!}
							</div>
                            <div class="col-md-1 form-group">
                                {!! Form::label('contable', 'Contable:') !!}
								{!! Form::select('contable',[1=>'SI',2=>'NO'],1,['class'=>'custom-select activo']) !!}
							</div>
                            <div class="col-md-1 form-group">
                                {!! Form::label('almacen', 'Almacén:') !!}
								{!! Form::select('almacen',[1=>'SI',2=>'NO'],2,['class'=>'custom-select activo']) !!}
							</div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('fpago', 'Forma Pago:') !!}
								{!! Form::select('fpago',[1=>'CONTADO',2=>'CRÉDITO'],1,['class'=>'custom-select activo']) !!}
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
                                {!! Form::label('cancelacion', 'Cancelación:') !!}
                                {!! Form::date('cancelacion', null, ['class'=>'form-control activo','disabled']) !!}
							</div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="row">
                                    <div class="col-md-3 form-group">
                                        {!! Form::label('moneda', 'Moneda:') !!}
                                        {!! Form::select('moneda',$moneda,1,['class'=>'custom-select activo']) !!}
                                    </div>
                                    <div class="col-md-3 form-group">
                                        {!! Form::label('tc', 'TC:') !!}
                                        {!! Form::text('tc', null, ['class'=>'form-control decimal activo','autocomplete'=>'off']) !!}
                                    </div>
                                    <div class="col-md-6 form-group">
                                        {!! Form::label('tipocomprobante_codigo', 'Tipo Comprobante:') !!}
                                        {!! Form::select('tipocomprobante_codigo',$tipocomprobante,null,['class'=>'custom-select activo','placeholder'=>'']) !!}
                                    </div>
                                </div>
                            </div>                            
                            <div class="col-md-2">
                                {!! Form::label('numero', 'Número Documento:') !!}
                                <div class="row no-gutters">
                                    <div class="col-md-4">
                                        {!! Form::text('serie', null, ['class'=>'form-control mayuscula activo','maxlength'=>'4','autocomplete'=>'off']) !!}
                                    </div>
                                    <div class="col-md-8">								
                                        {!! Form::text('numero', null, ['class'=>'form-control mayuscula activo','maxlength'=>'15','autocomplete'=>'off']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 form-group">
                                {!! Form::label('cliente_id', 'Proveedor:') !!}
                                <div class="row no-gutters">
                                    <div class="col-md-10">
                                        {!! Form::select('cliente_id',[],null,['class'=>'custom-select activo','id'=>'cliente_id','placeholder'=>'']) !!}
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-block btn-convertir" type="button" id="addcliente" title="Agregar Cliente"><i class="fas fa-user-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-3 form-group">
                                        {!! Form::label('afecto', 'Afecto:') !!}
                                        {!! Form::text('afecto', null, ['class'=>'form-control decimal activo','autocomplete'=>'off']) !!}
                                    </div>
                                    <div class="col-md-3 form-group">
                                        {!! Form::label('exonerado', 'Exonerado:') !!}
                                        {!! Form::text('exonerado', null, ['class'=>'form-control decimal activo','autocomplete'=>'off']) !!}
                                    </div>
                                    <div class="col-md-3 form-group">
                                        {!! Form::label('impuesto', 'IGV('.session('igv').'%)') !!}
                                        {!! Form::text('impuesto', null, ['class'=>'form-control decimal activo','autocomplete'=>'off']) !!}
                                    </div>
                                    <div class="col-md-3 form-group">
                                        {!! Form::label('renta', 'Renta('.session('renta').'%)') !!}
                                        {!! Form::text('renta', null, ['class'=>'form-control decimal activo','autocomplete'=>'off']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        {!! Form::label('isc', 'ISC:') !!}
                                        {!! Form::text('isc', null, ['class'=>'form-control decimal activo','autocomplete'=>'off']) !!}
                                    </div>
                                    <div class="col-md-4 form-group">
                                        {!! Form::label('otros', 'Otros:') !!}
                                        {!! Form::text('otros', null, ['class'=>'form-control decimal activo','autocomplete'=>'off']) !!}
                                    </div>
                                    <div class="col-md-4 form-group">
                                        {!! Form::label('icbper', 'ICBPER:') !!}
                                        {!! Form::text('icbper', null, ['class'=>'form-control decimal activo','autocomplete'=>'off']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('total', 'Total:') !!}
                                {!! Form::text('total', null, ['class'=>'form-control activo','autocomplete'=>'off','disabled']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 form-group">
                                {!! Form::label('tipooperacion_id', 'Tipo Operación:') !!}
                                {!! Form::select('tipooperacion_id',$tipooperacion,null,['class'=>'custom-select activo','placeholder'=>'']) !!}
                            </div>
                            <div class="col-md-3 form-group">
                                {!! Form::label('mediopago', 'Medio Pago:') !!}
                                {!! Form::select('mediopago',$mediopago,null,['class'=>'custom-select activo','placeholder'=>'']) !!}
                            </div>
                            <div class="col-md-3 form-group">
                                {!! Form::label('cuenta_id', 'Cuenta:') !!}
                                {!! Form::select('cuenta_id',$cuenta,null,['class'=>'custom-select activo','placeholder'=>'']) !!}
                            </div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('numerooperacion', 'N° Operación:') !!}
                                {!! Form::text('numerooperacion', null, ['class'=>'form-control activo','maxlength'=>'15','autocomplete'=>'off']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1 form-group">
                                {!! Form::label('detraccion', 'Detracción:') !!}
								{!! Form::select('detraccion',[1=>'SI',2=>'NO'],2,['class'=>'custom-select activo']) !!}
							</div>
                            <div class="col-md-3 form-group">
                                {!! Form::label('detraccion_codigo', 'Código Detracción:') !!}
                                {!! Form::select('detraccion_codigo',$detraccions,null,['class'=>'custom-select activo','placeholder'=>'','disabled']) !!}
                            </div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('detraccion_tasa', 'Tasa:') !!}
                                {!! Form::text('detraccion_tasa', null, ['class'=>'form-control decimal activo','autocomplete'=>'off','disabled']) !!}
                            </div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('detraccion_monto', 'Monto:') !!}
                                {!! Form::text('detraccion_monto', null, ['class'=>'form-control decimal activo','autocomplete'=>'off','disabled']) !!}
                            </div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('detraccion_constancia', 'Constancia:') !!}
                                {!! Form::text('detraccion_constancia', null, ['class'=>'form-control decimal activo','autocomplete'=>'off','disabled']) !!}
                            </div>
                        </div>
                        <div class="row referencia mt-1">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="colorprin">Documento de Referencia:</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-2 form-group">
                                                {!! Form::label('dr_fecha', 'Fecha:') !!}
                                                {!! Form::date('dr_fecha', null, ['class'=>'form-control activo']) !!}
                                            </div>
                                            <div class="col-md-6 form-group">
                                                {!! Form::label('dr_tipocomprobante_codigo', 'Tipo Comprobante:') !!}
                                                {!! Form::select('dr_tipocomprobante_codigo',$tipocomprobante,null,['class'=>'custom-select activo','placeholder'=>'']) !!}
                                            </div>
                                            <div class="col-md-3">
                                                {!! Form::label('dr_numero', 'Número Documento:') !!}
                                                <div class="row no-gutters">
                                                    <div class="col-md-3">
                                                        {!! Form::text('dr_serie', null, ['class'=>'form-control mayuscula activo','maxlength'=>'4','autocomplete'=>'off']) !!}
                                                    </div>
                                                    <div class="col-md-9">								
                                                        {!! Form::text('dr_numero', null, ['class'=>'form-control mayuscula activo','maxlength'=>'15','autocomplete'=>'off']) !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                {!! Form::label('detalle', 'Glosa:') !!}
                                {!! Form::textarea('detalle',null,['class'=>'form-control mayuscula', 'rows'=>'3', 'id'=>'editor']) !!}
                            </div>
                        </div>
                        
						{{-- <div class="row">
							<div class="col-md-4 form-group">
                                {!! Form::label('tipdoc_id', 'Tipo documento:') !!}
								{!! Form::select('tipdoc_id',$tipdoc,'1',['class'=>'custom-select']) !!}
							</div>
							<div class="col-md-2 form-group">
                                {!! Form::label('numdoc', 'Número documento:') !!}
								{!! Form::text('numdoc', null, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-6 form-group">
                                {!! Form::label('razsoc', 'Razón social:') !!}
								{!! Form::text('razsoc', null, ['class'=>'form-control','autocomplete'=>'off','disabled']) !!}
							</div>
						</div> --}}

						
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

        $('.referencia').hide();
        
        $('#guardar').click(function(){
            $('.activo').prop('disabled',false);
        });

        $('#fpago').change(function(){
            if(this.value == 1){
                $('#dias').prop('disabled',true);
                $('#dias').val(null);
                $('#vencimiento').prop('disabled',true);
                $('#vencimiento').val(null);
                $('#cancelacion').val($('#fecha').val());
                $('#mediopago').prop('disabled',false);
                $('#cuenta_id').prop('disabled',false);
                $('#numerooperacion').prop('disabled',false);
                $('#mediopago').val(null);
                $('#origenpago_id').val(null);
                $('#numerooperacion').val(null);
            }else{
                $('#dias').prop('disabled',false);
                $('#vencimiento').prop('disabled',false);
                $('#cancelacion').val(null);
                $('#mediopago').prop('disabled',true);
                $('#cuenta_id').prop('disabled',true);
                $('#numerooperacion').prop('disabled',true);
                $('#mediopago').val(null);
                $('#origenpago_id').val(null);
                $('#numerooperacion').val(null);
            }
        });

        $('#dias').blur(function(){
            var fecha = $('#fecha').val();
            $('#vencimiento').val(sumarDias(fecha,this.value));
        });

        $('#fecha').blur(function(){
            if($('#fpago').val() == 1){
                $('#vencimiento').val(null);
                $('#cancelacion').val(this.value);
            }else{
                var dias = $('#dias').val();
                $('#vencimiento').val(sumarDias(this.value,dias));
                $('#cancelacion').val(null);
            }
            $.get(url_global+"/admin/rcompras/"+this.value+"/bustc/",function(response){
                $('#tc').val(response['venta']);
            });
        });

        $('#moneda').change(function(){
            var moneda = this.value;
            $.get(url_global+"/admin/cuentas/"+moneda+"/moneda/",function(response){
                $('#cuenta_id').empty();
                for(i=0;i<response.length;i++){
                    $('#cuenta_id').append("<option value='"+response[i].id+"'>"+response[i].nombre+"</option>");
                }
                $('#cuenta_id').val(null);
            });
        });

        $('#detraccion_codigo').change(function(){
            $.get(url_global+"/admin/detraccions/"+this.value+"/tasa/",function(response){
                var tasa = response;
                $('#detraccion_tasa').val(tasa);
                $('#detraccion_monto').val($('#total').val()*(tasa/100));
            });
        });

        $('#tipocomprobante_codigo').change(function(){
            // alert(this.value);
            if(this.value == '07' || this.value == '08'){
                $('.referencia').show();
            }else{
                $('.referencia').hide();
            }
            $.get(url_global+"/admin/tipocomprobantes/"+this.value+"/search/",function(response){
                $('#afecto').val(null);
                $('#exonerado').val(null);
                $('#impuesto').val(null);
                $('#renta').val(null);
                $('#isc').val(null);
                $('#otros').val(null);
                $('#icbper').val(null);
                $('#total').val(null);
                $('#tipooperacion_id').val(null);
                $('#detraccion').val(2);

                switch (response){
                    case '1':
                        $('#afecto').prop('disabled',false);
                        $('#exonerado').prop('disabled',false);
                        $('#impuesto').prop('disabled',false);
                        $('#renta').prop('disabled',true);
                        $('#isc').prop('disabled',false);
                        $('#otros').prop('disabled',false);
                        $('#icbper').prop('disabled',false);
                        $('#tipooperacion_id').prop('disabled',false);
                        $('#detraccion').prop('disabled',false);
                        break;
                    case '2':
                        $('#afecto').prop('disabled',true);
                        $('#exonerado').prop('disabled',false);
                        $('#impuesto').prop('disabled',true);
                        $('#renta').prop('disabled',false);
                        $('#isc').prop('disabled',true);
                        $('#otros').prop('disabled',true);
                        $('#icbper').prop('disabled',true);
                        $('#tipooperacion_id').prop('disabled',true);
                        $('#detraccion').prop('disabled',true);
                        break;
                    case '3':
                        $('#afecto').prop('disabled',true);
                        $('#exonerado').prop('disabled',true);
                        $('#impuesto').prop('disabled',true);
                        $('#renta').prop('disabled',true);
                        $('#isc').prop('disabled',true);
                        $('#otros').prop('disabled',false);
                        $('#icbper').prop('disabled',true);
                        $('#tipooperacion_id').prop('disabled',true);
                        $('#detraccion').prop('disabled',true);
                        break;
                }
            });
        });

        $('#numero').blur(function(){
            this.value = this.value.replace(/^(0+)/g,'');
        });

        $('.decimal').blur(function(event){
            suma();
        });        

        $('#afecto').blur(function(){
            var igv = {{ session('igv') }} / 100;
            $('#impuesto').val(Redondea(igv * this.value,2));
            suma();
        });

        $('#exonerado').blur(function(){
            var mrenta = {{ session('mrenta') }};
            if($('#tipocomprobante_codigo').val() == '02' && this.value > mrenta){
                var renta = {{ session('renta') }} / 100;
                $('#renta').val(Redondea(renta * this.value,2));
                suma();
            }
            
        });

        $('#detraccion').change(function(){
            if(this.value == 1){
                $('#detraccion_codigo').prop('disabled',false);
                $('#detraccion_tasa').prop('disabled',false);
                $('#detraccion_monto').prop('disabled',false);
                $('#detraccion_constancia').prop('disabled',false);
            }else{
                $('#detraccion_codigo').prop('disabled',true);
                $('#detraccion_tasa').prop('disabled',true);
                $('#detraccion_monto').prop('disabled',true);
                $('#detraccion_constancia').prop('disabled',true);
            }
            $('#detraccion_codigo').val(null);
            $('#detraccion_tasa').val(null);
            $('#detraccion_monto').val(null);
            $('#detraccion_constancia').val(null);
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
                    if (respuesta.tipdoc_id == '6') {
                        $('#tipocomprobante_codigo').val('01')
                    } else {
                        $('#tipocomprobante_codigo').val('03')
                    }
                    $('#agregarcliente').hide();
                    $('#agregarcomprobante').show();
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

    });
    function suma(){
        var afecto = NaNToCero(parseFloat($('#afecto').val()));
        var exonerado = NaNToCero(parseFloat($('#exonerado').val()));
        var impuesto = NaNToCero(parseFloat($('#impuesto').val()));
        var renta = NaNToCero(parseFloat($('#renta').val()));
        var isc = NaNToCero(parseFloat($('#isc').val()));
        var otros = NaNToCero(parseFloat($('#otros').val()));
        var icbper = NaNToCero(parseFloat($('#icbper').val()));
        var total;
        total = Redondea(afecto + exonerado + impuesto + isc + otros + icbper - renta,2);
        $('#total').val(total);
    }

</script>
@endsection
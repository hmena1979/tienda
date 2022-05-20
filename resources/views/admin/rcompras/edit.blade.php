{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Registro de Compras')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.rcompras.index') }}"><i class="fas fa-cart-plus"></i> Registro de Compras</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					<div class="inside">
						{!! Form::model($rcompra,['route'=>['admin.rcompras.update',$rcompra],'method'=>'put']) !!}
                        <div class="row">
                            <div class="col-md-1 form-group">
                                {!! Form::label('periodo', 'Periodo:') !!}
								{!! Form::text('periodo', null, ['class'=>'form-control activo','disabled']) !!}
							</div>
                            <div class="col-md-1 form-group">
                                {!! Form::label('contable', 'Contable:') !!}
								{!! Form::select('contable',[1=>'SI',2=>'NO'],null,['class'=>'custom-select activo']) !!}
							</div>
                            <div class="col-md-1 form-group">
                                {!! Form::label('almacen', 'Almacén:') !!}
								{!! Form::select('almacen',[1=>'SI',2=>'NO'],null,['class'=>'custom-select activo']) !!}
							</div>
                            <div class="col-md-2 form-group">
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
                                {!! Form::label('cancelacion', 'Cancelación:') !!}
                                {!! Form::date('cancelacion', null, ['class'=>'form-control activo','disabled']) !!}
							</div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="row">
                                    <div class="col-md-3 form-group">
                                        {!! Form::label('moneda', 'Moneda:') !!}
                                        {!! Form::select('moneda',$moneda,null,['class'=>'custom-select activo']) !!}
                                    </div>
                                    <div class="col-md-3 form-group">
                                        {!! Form::label('tc', 'TC:') !!}
                                        {!! Form::text('tc', null, ['class'=>'form-control decimal activo','autocomplete'=>'off']) !!}
                                    </div>
                                    <div class="col-md-6 form-group">
                                        {!! Form::text('tipocomprobante_tipo', null, ['class'=>'form-control','id'=>'tipocomprobante_tipo2','hidden']) !!}
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
                            <div class="col-md-5">
                                {!! Form::label('cliente_id', 'Proveedor:') !!}
                                {!! Form::select('cliente_id',$clientes,null,['class'=>'custom-select activo','id'=>'cliente_id','placeholder'=>'']) !!}
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
                                        {!! Form::label('renta', 'Renta') !!}
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
                                {!! Form::select('cuenta_id',$cuenta,null,['class'=>'custom-select activo','id'=>'cuenta_id','placeholder'=>'']) !!}
                            </div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('numerooperacion', 'N° Operación:') !!}
                                {!! Form::text('numerooperacion', null, ['class'=>'form-control activo','maxlength'=>'15','autocomplete'=>'off']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 form-group">
                                {!! Form::label('lote', 'Lote:') !!}
                                {!! Form::text('lote', null, ['class'=>'form-control mayuscula','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-1 form-group">
                                {!! Form::label('detraccion', 'Detracción:') !!}
								{!! Form::select('detraccion',[1=>'SI',2=>'NO'],null,['class'=>'custom-select activo']) !!}
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

						{!! Form::submit('Guardar', ['class'=>'btn btn-convertir', 'id'=>'guardar']) !!}
						{!! Form::close() !!}
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

    if($('#moneda').val() == 'PEN'){
        $('#tc').prop('disabled',true);
    }else{
        $('#tc').prop('disabled',false);
    }

    if($('#tipocomprobante_codigo').val() == '07' || $('#tipocomprobante_codigo').val() == '08'){
        // alert($('#tipocomprobante_codigo').val())
        $('.referencia').show();
    }else{
        $('.referencia').hide();
    }

    if($('#fpago').val() == 1){
        $('#dias').prop('disabled',true);
        $('#vencimiento').prop('disabled',true);
        $('#mediopago').prop('disabled',false);
        $('#cuenta_id').prop('disabled',false);
        $('#numerooperacion').prop('disabled',false);
    }else{
        $('#dias').prop('disabled',false);
        $('#vencimiento').prop('disabled',false);
        $('#mediopago').prop('disabled',true);
        $('#cuenta_id').prop('disabled',true);
        $('#numerooperacion').prop('disabled',true);
    }

    if ($('#detraccion').val() == 1) {
        $('#detraccion_codigo').prop('disabled',false);
        $('#detraccion_tasa').prop('disabled',false);
        $('#detraccion_monto').prop('disabled',false);
        $('#detraccion_constancia').prop('disabled',false);
    }
    
    if($('#tipocomprobante_tipo2').val() == 1){
        $('#afecto').prop('disabled',false);
        $('#exonerado').prop('disabled',false);
        $('#impuesto').prop('disabled',false);
        $('#renta').prop('disabled',true);
        $('#isc').prop('disabled',false);
        $('#otros').prop('disabled',false);
        $('#icbper').prop('disabled',false);
        $('#tipooperacion_id').prop('disabled',false);
        $('#detraccion').prop('disabled',false);
    }else if($('#tipocomprobante_tipo2').val() == 2){
        if ($('#tipocomprobante_codigo').val() == '04') {
            $('#afecto').prop('disabled',false);
            $('#tipooperacion_id').prop('disabled',false);
            $('#detraccion').prop('disabled',false);
        } else {
            $('#afecto').prop('disabled',true);
            $('#tipooperacion_id').prop('disabled',true);
            $('#detraccion').prop('disabled',true);
        }
        $('#exonerado').prop('disabled',false);
        $('#impuesto').prop('disabled',true);
        $('#renta').prop('disabled',false);
        $('#isc').prop('disabled',true);
        $('#otros').prop('disabled',true);
        $('#icbper').prop('disabled',true);
    }else{
        $('#afecto').prop('disabled',true);
        $('#exonerado').prop('disabled',true);
        $('#impuesto').prop('disabled',true);
        $('#renta').prop('disabled',true);
        $('#isc').prop('disabled',true);
        $('#otros').prop('disabled',false);
        $('#icbper').prop('disabled',true);
        $('#tipooperacion_id').prop('disabled',true);
        $('#detraccion').prop('disabled',true);
    }

    $(document).ready(function(){
        $('#cliente_id').select2({
            placeholder:"Ingrese 4 dígitos del RUC o Razón Social",
            minimumInputLength: 4,
            ajax:{
                url: "{{ route('admin.clientes.seleccionado') }}",
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
                $('#origenpago_id').prop('disabled',false);
                $('#numerooperacion').prop('disabled',false);
                $('#mediopago').val(null);
                $('#cuenta_id').val(null);
                $('#numerooperacion').val(null);
            }else{
                $('#dias').prop('disabled',false);
                $('#vencimiento').prop('disabled',false);
                $('#cancelacion').val(null);
                $('#mediopago').prop('disabled',true);
                $('#cuenta_id').prop('disabled',true);
                $('#origenpago_id').prop('disabled',true);
                $('#numerooperacion').prop('disabled',true);
                $('#mediopago').val(null);
                $('#cuenta_id').val(null);
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

///////////////////////////////////////////////////////////////////////////////////////////////////////
        $('#detraccion_codigo').change(function(){
            $.get(url_global+"/admin/detraccions/"+this.value+"/tasa/",function(response){
                var tasa = response;
                $('#detraccion_tasa').val(tasa);
                $('#detraccion_monto').val($('#total').val()*(tasa/100));

            });
        });

        $('#tipocomprobante_codigo').change(function(){
            var td = this.value;
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
                        if (td == '04') {
                            $('#afecto').prop('disabled',false);
                            $('#tipooperacion_id').prop('disabled',false);
                        } else {
                            $('#afecto').prop('disabled',true);
                            $('#tipooperacion_id').prop('disabled',true);
                        }
                        // $('#afecto').prop('disabled',true);
                        $('#exonerado').prop('disabled',false);
                        $('#impuesto').prop('disabled',true);
                        $('#renta').prop('disabled',false);
                        $('#isc').prop('disabled',true);
                        $('#otros').prop('disabled',true);
                        $('#icbper').prop('disabled',true);
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
            var renta = {{ session('rentalq') }} / 100;
            if ($('#tipocomprobante_codigo').val() == '04') {
                $('#renta').val(Redondea(renta * this.value,2));
            } else {
                $('#impuesto').val(Redondea(igv * this.value,2));
            }
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
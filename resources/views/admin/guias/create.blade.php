{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Guías de Remisión')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.guias.index') }}"><i class="fas fa-receipt"></i> Guías de Remisión</a>
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
						<h2 class="title"><i class="fas fa-receipt"></i> Guías de Remisión</h2>
						<ul>
                            <li>
                                {!! Form::submit('Generar Guía', ['class'=>'btn btn-convertir mt-2', 'id'=>'guardar']) !!}
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
                                {!! Form::label('fecha', 'Fecha:') !!}
                                {!! Form::date('fecha', Carbon\Carbon::now(), ['class'=>'form-control activo']) !!}
                            </div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('fechatraslado', 'Inicio Traslado:') !!}
                                {!! Form::date('fechatraslado', Carbon\Carbon::now(), ['class'=>'form-control activo']) !!}
                            </div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('motivotraslado_id', 'Motivo Traslado:') !!}
                                {!! Form::select('motivotraslado_id',$motivoTraslado,null,['class'=>'custom-select activo','placeholder'=>'Elija Motivo de Traslado']) !!}
                            </div>
                            <div class="col-md-3 form-group">
                                {!! Form::label('tipdoc_relacionado_id', 'Tipo Documento Relacionado:') !!}
                                {!! Form::select('tipdoc_relacionado_id',$docRelacionados,null,['class'=>'custom-select activo','placeholder'=>'Elija Tipo Documento Relacionado']) !!}
                            </div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('numdoc_relacionado', 'Número Documento:') !!}
								{!! Form::text('numdoc_relacionado', null, ['class'=>'form-control mayuscula','autocomplete'=>'off','maxlength'=>'15']) !!}
							</div>
                        </div>
                        <div class="row">
                            <div class="col-md-1 form-group">
                                {!! Form::label('puerto', 'Puerto:') !!}
                                {!! Form::text('puerto', null, ['class'=>'form-control activo','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('transbordo', 'Transbordo:') !!}
                                {!! Form::select('transbordo',[true => 'SI',false => 'NO'],false,['class'=>'custom-select']) !!}
                            </div>
                            <div class="col-md-3 form-group">
                                {!! Form::label('modalidadtraslado_id', 'Modalidad Transporte:') !!}
                                {!! Form::select('modalidadtraslado_id',$modalidadTraslado,null,['class'=>'custom-select']) !!}
                            </div>
                            <div class="col-md-2 form-group publico">
                                {!! Form::label('tipodoctransportista_id', 'TD Transportista:') !!}
                                {!! Form::select('tipodoctransportista_id',$tipdoc,null,['class'=>'custom-select','placeholder'=>'Elija Tipo Documento']) !!}
                            </div>
                            <div class="col-md-2 form-group publico">
                                {!! Form::label('numdoctransportista', 'N.Doc Transportista:') !!}
                                {!! Form::text('numdoctransportista', null, ['class'=>'form-control mayuscula','autocomplete'=>'off','maxlength'=>'15']) !!}
                            </div>
                            <div class="col-md-2 form-group publico">
                                {!! Form::label('razsoctransportista', 'R.Social Transportista:') !!}
                                {!! Form::text('razsoctransportista', null, ['class'=>'form-control mayuscula','autocomplete'=>'off','maxlength'=>'60']) !!}
                            </div>
                            <div class="col-md-2 form-group privado">
                                {!! Form::label('placa', 'Placa:') !!}
                                {!! Form::text('placa', null, ['class'=>'form-control mayuscula','autocomplete'=>'off','maxlength'=>'10']) !!}
                            </div>
                            <div class="col-md-2 form-group privado">
                                {!! Form::label('tipodocchofer_id', 'TD Chofer:') !!}
                                {!! Form::select('tipodocchofer_id',$tipdoc,null,['class'=>'custom-select','placeholder'=>'Elija Tipo Documento']) !!}
                            </div>
                            <div class="col-md-2 form-group privado">
                                {!! Form::label('documentochofer', 'N.Doc Chofer:') !!}
                                {!! Form::text('documentochofer', null, ['class'=>'form-control mayuscula','autocomplete'=>'off','maxlength'=>'15']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 form-group">
                                {!! Form::label('cliente_id', 'Destinatario:') !!}
                                <div class="row no-gutters">
                                    <div class="col-md-10">
                                        {!! Form::select('cliente_id',[],null,['class'=>'custom-select activo','id'=>'cliente_id','placeholder'=>'']) !!}
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-convertir" type="button" id="addcliente" title="Agregar Cliente"><i class="fas fa-user-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 form-group">
                                {!! Form::label('tercero_id', 'Tercero:') !!}
                                {!! Form::select('tercero_id',[],null,['class'=>'custom-select activo','id'=>'tercero_id','placeholder'=>'']) !!}
                            </div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('pesototal', 'Peso Total KGM:') !!}
                                {!! Form::text('pesototal', null, ['class'=>'form-control decimal','autocomplete'=>'off','maxlength'=>'10']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 form-group">
                                {!! Form::label('departamento_partida', 'Departamento:') !!}
                                {!! Form::select('departamento_partida',$departamentos,null,['class'=>'custom-select','placeholder'=>'']) !!}
							</div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('provincia_partida', 'Provincia:') !!}
                                {!! Form::select('provincia_partida',[],null,['class'=>'custom-select','placeholder'=>'']) !!}
							</div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('ubigeo_partida', 'Ubigeo Partida:') !!}
                                {!! Form::select('ubigeo_partida',[],null,['class'=>'custom-select','placeholder'=>'']) !!}
							</div>
                            <div class="col-md-6 form-group">
                                {!! Form::label('punto_partida', 'Punto de Partida:') !!}
                                {!! Form::text('punto_partida', null, ['class'=>'form-control mayuscula','autocomplete'=>'off']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 form-group">
                                {!! Form::label('departamento_llegada', 'Departamento:') !!}
                                {!! Form::select('departamento_llegada',$departamentos,null,['class'=>'custom-select','placeholder'=>'']) !!}
							</div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('provincia_llegada', 'Provincia:') !!}
                                {!! Form::select('provincia_llegada',[],null,['class'=>'custom-select','placeholder'=>'']) !!}
							</div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('ubigeo_llegada', 'Ubigeo Llegada:') !!}
                                {!! Form::select('ubigeo_llegada',[],null,['class'=>'custom-select','placeholder'=>'']) !!}
							</div>
                            <div class="col-md-6 form-group">
                                {!! Form::label('punto_llegada', 'Punto de Llegada:') !!}
                                {!! Form::text('punto_llegada', null, ['class'=>'form-control mayuscula','autocomplete'=>'off']) !!}
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
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        {!! Form::label('cantidad', 'Cantidad:') !!}
                                        {!! Form::text('cantidad', null, ['class'=>'form-control decimal']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
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
        $('.add').hide();
        $('.finalizar').hide();
        $('.privado').hide();

        $('#modalidadtraslado_id').change(function(){
            if (this.value == '01') {
                $('.privado').hide();
                $('.publico').show();
            } else {
                $('.privado').show();
                $('.publico').hide();
            }
        });

        $('#departamento_partida').select2({
            placeholder:"Departamento"
        });

        $('#departamento_llegada').select2({
            placeholder:"Departamento"
        });

        $('#provincia_partida').select2({
            placeholder:"Provincia"
        });

        $('#provincia_llegada').select2({
            placeholder:"Provincia"
        });

        $('#ubigeo_partida').select2({
            placeholder:"Ubigeo"
        });

        $('#ubigeo_llegada').select2({
            placeholder:"Ubigeo"
        });

        $('#departamento_partida').on('select2:close',function(){
            var departamento = this.value;
            $.get(url_global+"/admin/busquedas/"+departamento+"/provincia/",function(response){
                $('#provincia_partida').empty();
                for(i=0;i<response.length;i++){
                    $('#provincia_partida').append("<option value='"+response[i].codigo+"'>"
                        + response[i].nombre
                        + "</option>");
                }
                $('#provincia_partida').val(null);
                $('#ubigeo_partida').empty();
            });
        });

        $('#departamento_llegada').on('select2:close',function(){
            var departamento = this.value;
            $.get(url_global+"/admin/busquedas/"+departamento+"/provincia/",function(response){
                $('#provincia_llegada').empty();
                for(i=0;i<response.length;i++){
                    $('#provincia_llegada').append("<option value='"+response[i].codigo+"'>"
                        + response[i].nombre
                        + "</option>");
                }
                $('#provincia_llegada').val(null);
                $('#ubigeo_llegada').empty();
            });
        });

        $('#provincia_partida').on('select2:close',function(){
            var provincia = this.value;
            $.get(url_global+"/admin/busquedas/"+provincia+"/ubigeo/",function(response){
                $('#ubigeo_partida').empty();
                for(i=0;i<response.length;i++){
                    $('#ubigeo_partida').append("<option value='"+response[i].codigo+"'>"
                        + response[i].nombre
                        + "</option>");
                }
            });
        });

        $('#provincia_llegada').on('select2:close',function(){
            var provincia = this.value;
            $.get(url_global+"/admin/busquedas/"+provincia+"/ubigeo/",function(response){
                $('#ubigeo_llegada').empty();
                for(i=0;i<response.length;i++){
                    $('#ubigeo_llegada').append("<option value='"+response[i].codigo+"'>"
                        + response[i].nombre
                        + "</option>");
                }
            });
        });

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

        $('#tercero_id').select2({
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
            $.ajax({
                url: "{{ route('admin.guias.store') }}",
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
                        let url = url_global + '/admin/pdf/' + respuesta['id'] + '/guia';
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

        $('#descartar').click(function(){
            $('.add').hide();
            limpiaDetalle();
            $('#grupo').val(1);
            $('#adddetvta').show();
        });

        veritems();

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

        $('#producto_id').on('select2:close',function(){
            $('#adicional').val(null);
            $('#cantidad').val(null);
        });

        $('#agregar').click(function(e){
            e.preventDefault();
            let html = 'Se encontraron los siguientes errores:';
            html += "<ul>";
            if($('#producto_id').val().length == 0){
                html += "<li>"+ 'Seleccione un Producto | Servicio' +"</li>";
            }
            html += "</ul>";
            if ($('#producto_id').val().length == 0)  {
                $('#contenido_errorp').html(html);
                $('#mensaje_errorp').slideDown();
                setTimeout(function(){ $('#mensaje_errorp').slideUp(); }, 3000);
                return true;
            }
            $('.activodet').prop('disabled',false)
            $.ajax({
                url: "{{ route('admin.guias.additem') }}",
                type: "POST",
                async: true,
                data: $('#formadditem').serialize(),
                
                success: function(respuesta){
                    veritems();
                    limpiaDetalle()
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
				$.get(url_global+"/admin/guias/"+id+"/destroyitem/",function(response){
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
        $.get(url_global+"/admin/guias/"+key+"/tablaitem/",function(response){
            $('#tdetitem').empty();
            $('#tdetitem').html(response);
        });
    }

    function limpiaDetalle(){
        $('#producto_id').val(null);
        $('#producto_id').empty();
        $('#adicional').val(null);
    }
</script>
@endsection
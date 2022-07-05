{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Cotizaciones')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.cotizacions.index') }}"><i class="fas fa-file-alt"></i> Cotizaciones</a>
	</li>
@endsection

@section('contenido')
    <div id="mensaje_error" class="alert alert-danger" style="display:none;">
        <strong id="contenido_error"></strong>
    </div>
	<div class="container-fluid">
		<div class="row"  id = 'agregarcomprobante'>
            <div class="col-md-12">
                {!! Form::open(['route'=>'admin.cotizacions.store']) !!}
				<div class="panelprin shadow">
                    <div class="headercontent">
						<h2 class="title"><i class="fas fa-file-alt"></i> Cotizaciones</h2>
						<ul>
                            <li>
                                {!! Form::submit('Guardar', ['class'=>'btn btn-convertir mt-2', 'id'=>'guardar']) !!}
                            </li>
						</ul>
					</div>
                    {{-- {{ dd($comprobante) }} --}}
					<div class="inside">
                        {!! Form::hidden('empresa_id', session('empresa')) !!}
                        {!! Form::hidden('sede_id', session('sede')) !!}
                        {!! Form::hidden('periodo', session('periodo')) !!}
                        <div class="row">
                            <div class="col-md-2 form-group">
                                {!! Form::label('fecha', 'Fecha:') !!}
                                {!! Form::date('fecha', null, ['class'=>'form-control activo']) !!}
                            </div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('moneda', 'Moneda:') !!}
                                {!! Form::select('moneda',['PEN'=>'SOLES','USD'=>'DOLARES'],'PEN',['class'=>'custom-select activo']) !!}
                            </div>
                            <div class="col-md-2">
                                {!! Form::label('numero', 'Número:') !!}
                                {!! Form::text('numero', null, ['class'=>'form-control mayuscula activo','maxlength'=>'15','autocomplete'=>'off']) !!}
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
                            <div class="col-md-12 form-group">
                                {!! Form::label('observaciones', 'Observaciones:') !!}
                                {!! Form::textarea('observaciones',null,['class'=>'form-control mayuscula', 'rows'=>'3', 'id'=>'editor']) !!}
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
	</div>
@endsection
{{-- @section('css')
    <link rel="stylesheet" href="{{ url('/static/css/admin.css?v='.time()) }}">
@stop --}}
{{-- @section('js')
    <script src="{{ url('/static/js/admin.js?v='.time()) }}"></script>
@stop --}}
@section('script')
{{-- <script src="{{ asset('/static/js/ckeditor.js') }}"></script> --}}
<script>
    var url_global='{{url("/")}}';
    $(document).ready(function(){
        // ClassicEditor
        // .create( document.querySelector( '#editor' ) )
        // .catch( error => {
        //     console.error( error );
        // } );
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

        $('#numero').blur(function(){
            this.value = this.value.replace(/^(0+)/g,'');
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

    });

</script>
@endsection
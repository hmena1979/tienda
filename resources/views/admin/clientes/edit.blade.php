{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Proveedor|Cliente')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.clientes.index') }}">
            <i class="fas fa-address-card"></i> Proveedor | Cliente: <strong>{{ $cliente->razsoc }}</strong>
        </a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
        <div class="alert alert-warning" role="alert" style="display:none" id = 'buscando'>
			Buscando número de documento
		</div>
        {!! Form::model($cliente,['route'=>['admin.clientes.update',$cliente], 'method' => 'put']) !!}
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
                    <div class="headercontent">
						<h2 class="title"><i class="fas fa-address-card"></i> Proveedor | Cliente: <strong>{{ $cliente->razsoc }}</h2>
						<ul>
                            <li>
                                {!! Form::submit('Guardar', ['class'=>'btn btn-convertir mt-1', 'id'=>'guardar']) !!}
                            </li>
						</ul>
					</div>
					<div class="inside">
                        {!! Form::hidden('id', null,['id'=>'id']) !!}
						<div class="row">
							<div class="col-md-4 form-group">
                                {!! Form::label('tipdoc_id', 'Tipo documento:') !!}
								{!! Form::select('tipdoc_id',$tipdoc,null,['class'=>'custom-select']) !!}
							</div>
							<div class="col-md-2 form-group">
                                {!! Form::label('numdoc', 'Número documento:') !!}
								{!! Form::text('numdoc', null, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-6 form-group">
                                {!! Form::label('razsoc', 'Razón social:') !!}
								{!! Form::text('razsoc', null, ['class'=>'form-control', 'id' => 'razsoc','autocomplete'=>'off']) !!}
							</div>
						</div>
						<div class="row">
							<div class="col-md-4 form-group">
                                {!! Form::label('ape_pat', 'Apellido Paterno:') !!}
								{!! Form::text('ape_pat', null, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-4 form-group">
                                {!! Form::label('ape_mat', 'Apellido Materno:') !!}
								{!! Form::text('ape_mat', null, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-4 form-group">
                                {!! Form::label('nombres', 'Nombres:') !!}
								{!! Form::text('nombres', null, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							{{-- <div class="col-md-3 form-group">
                                {!! Form::label('nombre2', '2do Nombre:') !!}
								{!! Form::text('nombre2', null, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div> --}}
						</div>
						<div class="row">							
							<div class="col-md-6 form-group">
                                {!! Form::label('nomcomercial', 'Nombre comercial:') !!}
								{!! Form::text('nomcomercial', null, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-6 form-group">
                                {!! Form::label('contacto', 'Contacto:') !!}
								{!! Form::text('contacto', null, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							{{-- <div class="col-md-2 form-group">
                                {!! Form::label('fecnac', 'Fecha nacimiento:') !!}
								{!! Form::date('fecnac', null, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-2 form-group">
                                {!! Form::label('sexo_id', 'Sexo:') !!}
                                {!! Form::select('sexo_id',$sexo,null,['class'=>'custom-select','placeholder'=>'']) !!}
							</div>
							<div class="col-md-2 form-group">
                                {!! Form::label('estciv_id', 'Estado Civil:') !!}
                                {!! Form::select('estciv_id',$estciv,null,['class'=>'custom-select','placeholder'=>'']) !!}
							</div> --}}
						</div>
						<div class="row">							
							<div class="col-md-4 form-group">
                                {!! Form::label('direccion', 'Dirección:') !!}
								{!! Form::text('direccion', null, ['class'=>'form-control','autocomplete'=>'off']) !!}
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
			</div>
		</div>
        @can('admin.clientes.confidencial')
        <div class="row mtop16">
			<div class="col-md-12">
				<div class="panelprin shadow">
					<div class="inside">
                        <div class="row">
                            <div class="col-md-2 form-group">
                                {!! Form::label('confidencial', 'Confidencial:') !!}
                                {!! Form::select('confidencial',[1=>'SI',2=>'NO'],null,['class'=>'custom-select']) !!}
                            </div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('country_id', 'Pais Destino:') !!}
                                {!! Form::select('country_id',$countries,null,['class'=>'custom-select']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endcan
        {!! Form::close() !!}
        @can('admin.clientes.cuenta')
        <div class="row mtop16 oculto" id="addcuenta">
			<div class="col-md-12">
                {!! Form::open(['route'=>['admin.clientes.storedetalle',$cliente]]) !!}
                {!! Form::hidden('tipreg', 1,['id'=>'tipreg']) !!}
                {!! Form::hidden('idregistro', null,['id'=>'idregistro']) !!}
				<div class="panelprin shadow">
                    <div class="headercontent">
						<h2 class="title"><i class="fas fa-address-card"></i> Agregar | Editar Cuenta</h2>
						<ul>
                            <li>
                                {!! Form::submit('Aceptar', ['class'=>'btn btn-convertir', 'id'=>'add']) !!}
                            </li>
                            {{-- <li>
                                <button type="button" id='add' class="btn btn-block btn-convertir mt-2" datatoggle="tooltip" data-placement="top" title="Aceptar">
                                    <i class="fas fa-check"></i> Aceptar
                                </button>
                            </li> --}}
                            <li>
                                <button type="button" id='cancel' class="btn btn-block btn-convertir mt-1" datatoggle="tooltip" data-placement="top" title="Descartar">
                                    Descartar
                                </button>
                            </li>
						</ul>
					</div>
					<div class="inside">
                        <div class="row">
                            <div class="col-md-2 form-group">
								{!! Form::label('banco_id', 'Banco:') !!}
								{!! Form::select('banco_id',$bancos,null,['class'=>'custom-select activo','placeholder' => 'Seleccione Banco']) !!}
							</div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('moneda', 'Moneda:') !!}
                                {!! Form::select('moneda',['PEN'=>'SOLES','USD'=>'DOLARES'],null,['class'=>'custom-select activo']) !!}
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-5 form-group">
                                        {!! Form::label('tipo', 'Tipo:') !!}
                                        {!! Form::select('tipo',$tipos,null,['class'=>'custom-select activo']) !!}
                                    </div>
                                    <div class="col-md-7 form-group">
                                        {!! Form::label('cuenta', 'Número Cuenta:') !!}
                                        {!! Form::text('cuenta', null, ['class'=>'form-control numero','autocomplete'=>'off']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 form-group">
								{!! Form::label('cci', 'CCI:') !!}
								{!! Form::text('cci', null, ['class'=>'form-control numero','autocomplete'=>'off']) !!}
							</div>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
        @endcan
        <div class="row mtop16" id='detalles'>
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
{{-- @section('css')
    <link rel="stylesheet" href="{{ url('/static/css/admin.css?v='.time()) }}">
@stop --}}
@section('script')
<script>
    var url_global='{{url("/")}}';
    $(document).ready(function(){
        document.getElementById('guardar').addEventListener("click",function(){
            document.getElementById("razsoc").disabled = false;
            document.getElementById("ape_pat").disabled = false;
            document.getElementById("ape_mat").disabled = false;
            document.getElementById("nombres").disabled = false;
            // document.getElementById("nombre2").disabled = false;
        });

        veritems();

        $('#numdoc').blur(function(e){
            e.preventDefault();
            var id = $('#id').val();
            var td = $('#tipdoc_id').val();
            var numdoc = this.value;
            var entidad = '';
            var mensaje = 1;
            let repetido = 0;

            if(td == '1'){
                entidad = 'RENIEC';
            }
            if(td == '6'){
                entidad = 'SUNAT';
            }
            if(numdoc.length != 0){
                if(td == '1' && numdoc.length != 8){
                    mensaje = 0;
                    this.focus();
                    // alert('DNI debe contener 8 dígitos');
                    Swal.fire(
                        'Error!',
                        'DNI debe contener 8 dígitos!',
                        'error'
                        );
                        return false;
                }

                if(td == '6' && numdoc.length != 11){
                    mensaje = 0;
                    // alert('RUC debe contener 11 dígitos');
                    this.focus();
                    Swal.fire(
                        'Error!',
                        'RUC debe contener 11 dígitos!',
                        'error'
                        );
                    return false;
                }
                
                if(((td == '1') || (td == '6')) && (mensaje == 1)){
                    document.getElementById('buscando').style.display = 'block';
                    $.get(url_global+"/admin/clientes/"+td+"/"+numdoc+"/"+id+"/busapi/",function(response){
                        document.getElementById('buscando').style.display = 'none';
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
                            if(td == '1'){
                                document.getElementById('guardar').style.display = 'block';
                                // var nombres = response['nombres'];
                                // var espacio = nombres.indexOf(" ");
                                // var nombre1 = espacio!=-1?nombres.substr(0,espacio):nombres;
                                // var nombre2 = espacio!=-1?nombres.substr(espacio+1):'';
                                
                                document.getElementById("ape_pat").value = response['apellidoPaterno'];
                                document.getElementById("ape_mat").value = response['apellidoMaterno'];
                                document.getElementById("nombres").value = response['nombres'];
                                // document.getElementById("nombre2").value = nombre2;

                                document.getElementById("razsoc").value = document.getElementById("ape_pat").value + ' '
                                    + document.getElementById("ape_mat").value + ' '
                                    + document.getElementById("nombres").value; // + ' '
                                    // + document.getElementById("nombre2").value;
                                document.getElementById("nomcomercial").value = $('#razsoc').val();
                                    
                            }
                            if(td == '6'){
                                document.getElementById('guardar').style.display = 'block';
                                document.getElementById("nomcomercial").value = response['razonSocial'];
                                
                                if(numdoc.substr(0,2) == '20'){
                                    document.getElementById("ape_pat").value = '';
                                    document.getElementById("ape_pat").disabled = true;
                                    document.getElementById("ape_mat").value = '';
                                    document.getElementById("ape_mat").disabled = true;
                                    document.getElementById("nombres").value = '';
                                    document.getElementById("nombres").disabled = true;
                                    // document.getElementById("nombre2").value = '';
                                    // document.getElementById("nombre2").disabled = true;
                                    document.getElementById("direccion").value = response['direccion']+' '+response['distrito']+' '+
                                    response['provincia']+' '+response['departamento'];
                                    document.getElementById("razsoc").value = response['razonSocial'];
                                }else{
                                    document.getElementById("direccion").value = '';
                                    var razsoc = response['razonSocial'];
                                    var espacio1 = razsoc.indexOf(" ");
                                    var espacio2 = razsoc.indexOf(" ",espacio1+1);
                                    document.getElementById("ape_pat").value = razsoc.substr(0,espacio1);
                                    document.getElementById("ape_pat").disabled = false;
                                    document.getElementById("ape_mat").value = razsoc.substr(espacio1+1,espacio2-espacio1);
                                    document.getElementById("ape_mat").disabled = false;
                                    document.getElementById("nombres").value = razsoc.substr(espacio2+1);
                                    document.getElementById("nombres").disabled = false;
                                    document.getElementById("razsoc").value = response['razonSocial'];
                                    // document.getElementById("nombre2").disabled = false;
                                }                            
                            }
                        }
                    });
                }
                
            }
        });

        $('#razsoc').blur(function(){
            this.value = this.value.toUpperCase();
            $('#nomcomercial').val(this.value);
        });

        $('#nomcomercial').blur(function(){
            this.value = this.value.toUpperCase();
        });

        $('#direccion').blur(function(){
            this.value = this.value.toUpperCase();
        });

        document.getElementById('ape_pat').addEventListener("blur",function(){
            var td = $('#tipdoc_id').val();
            var numdoc = $('#numdoc').val().substr(0,2);            
            if((td =='6') && (numdoc == '20')){
            }else{
                this.value = this.value.toUpperCase();
                document.getElementById("razsoc").value = document.getElementById("ape_pat").value + ' '
                    + document.getElementById("ape_mat").value + ' '
                    + document.getElementById("nombres").value;// + ' '
                    // + document.getElementById("nombre2").value;
                $('#nomcomercial').val($('#razsoc').val());
            }
        });

        document.getElementById('ape_mat').addEventListener("blur",function(){
            var td = $('#tipdoc_id').val();
            var numdoc = $('#numdoc').val().substr(0,2);            
            if((td =='6') && (numdoc == '20')){
            }else{
                this.value = this.value.toUpperCase();
                document.getElementById("razsoc").value = document.getElementById("ape_pat").value + ' '
                    + document.getElementById("ape_mat").value + ' '
                    + document.getElementById("nombres").value;// + ' '
                    // + document.getElementById("nombre2").value;
                $('#nomcomercial').val($('#razsoc').val());
            }
        });

        document.getElementById('nombres').addEventListener("blur",function(){
            var td = $('#tipdoc_id').val();
            var numdoc = $('#numdoc').val().substr(0,2);            
            if((td =='6') && (numdoc == '20')){
            }else{
                this.value = this.value.toUpperCase();
                document.getElementById("razsoc").value = document.getElementById("ape_pat").value + ' '
                    + document.getElementById("ape_mat").value + ' '
                    + document.getElementById("nombres").value;// + ' '
                    // + document.getElementById("nombre2").value;
                $('#nomcomercial').val($('#razsoc').val());
            }
        });

        $('#cuenta').blur(function(){
            var longitud = this.value.length;
            if ($('#banco_id').val() == 2) {
                if ($('#tipo').val() == 1 && longitud != 14) {
                    Swal.fire(
                        'Error!',
                        'Cuenta Ahorro BCP debe contener 14 dígitos!',
                        'error'
                        );
                }
                if ($('#tipo').val() == 2 && longitud != 13) {
                    Swal.fire(
                        'Error!',
                        'Cuenta Corriente BCP debe contener 13 dígitos!',
                        'error'
                        );
                }
                if ($('#tipo').val() == 3 && longitud != 13) {
                    Swal.fire(
                        'Error!',
                        'Cuenta Maestra BCP debe contener 13 dígitos!',
                        'error'
                        );
                }
            }
            if ($('#banco_id').val() == 3 && longitud != 18) {
                Swal.fire(
                    'Error!',
                    'Cuenta BBVA debe contener 18 dígitos!',
                    'error'
                    );
            }
            
        });

        $('#cancel').click(function(){
            $('#addcuenta').hide();
            $('#detalles').show();
            $('#tipreg').val(1);
            $('#idregistro').val(null);
            $('#banco_id').val(null);
            $('#moneda').val('PEN');
            if ($('#tipdoc_id').val() == '6' && $('#numdoc').val().substr(0,2) == '20') {
                $('#tipo').val(2);
            } else {
                $('#tipo').val(1);
            }
            $('#cuenta').val(null);
            $('#cci').val(null);
        });

        function veritems(){
            var id = $('#id').val();
            $.get(url_global+"/admin/clientes/"+id+"/tablaitem/",function(response){
                $('#tdetitem').empty();
                $('#tdetitem').html(response);
            });
        }

    });
    function edititem(id) {
        $('#tipreg').val(2);
        $.get(url_global+"/admin/clientes/"+id+"/detcliente/",function(response){
            $('#idregistro').val(response.id);
            $('#banco_id').val(response.banco_id);
            $('#moneda').val(response.moneda);
            $('#tipo').val(response.tipo);
            $('#cuenta').val(response.cuenta);
            $('#cci').val(response.cci);
            $('#addcuenta').show();
            $('#detalles').hide();
        });
    }

    function additem() {
        if ($('#tipdoc_id').val() == '6' && $('#numdoc').val().substr(0,2) == '20') {
            $('#tipo').val(2);
        } else {
            $('#tipo').val(1);
        }
        $('#addcuenta').show();
        $('#detalles').hide();
    }

</script>
@endsection
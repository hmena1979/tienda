{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Proveedor|Cliente')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.clientes.index') }}"><i class="fas fa-address-card"></i> Proveedor | Cliente</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
        <div class="alert alert-warning" role="alert" style="display:none" id = 'buscando'>
			Buscando número de documento
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					<div class="inside">
						{!! Form::open(['route'=>'admin.clientes.store']) !!}
						<div class="row">
							<div class="col-md-4 form-group">
                                {!! Form::hidden('empresa_id', session('empresa')) !!}
                                {!! Form::label('tipdoc_id', 'Tipo documento:') !!}
								{!! Form::select('tipdoc_id',$tipdoc,'6',['class'=>'custom-select']) !!}
							</div>
							<div class="col-md-2 form-group">
                                {!! Form::label('numdoc', 'Número documento:') !!}
								{!! Form::text('numdoc', null, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-6 form-group">
                                {!! Form::label('razsoc', 'Razón social:') !!}
								{!! Form::text('razsoc', null, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
						</div>
						<div class="row">
							<div class="col-md-4 form-group">
                                {!! Form::label('ape_pat', 'Apellido Paterno:') !!}
								{!! Form::text('ape_pat', null, ['class'=>'form-control','autocomplete'=>'off', 'disabled']) !!}
							</div>
							<div class="col-md-4 form-group">
                                {!! Form::label('ape_mat', 'Apellido Materno:') !!}
								{!! Form::text('ape_mat', null, ['class'=>'form-control','autocomplete'=>'off', 'disabled']) !!}
							</div>
							<div class="col-md-4 form-group">
                                {!! Form::label('nombres', 'Nombres:') !!}
								{!! Form::text('nombres', null, ['class'=>'form-control','autocomplete'=>'off', 'disabled']) !!}
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
							<div class="col-md-2 form-group">
                                {!! Form::label('fecnac', 'Fecha nacimiento:') !!}
								{!! Form::date('fecnac', null, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-2 form-group">
                                {!! Form::label('sexo_id', 'Sexo:') !!}
                                {!! Form::select('sexo_id',$sexo,null,['class'=>'custom-select','placeholder'=>'', 'disabled']) !!}
							</div>
							<div class="col-md-2 form-group">
                                {!! Form::label('estciv_id', 'Estado Civil:') !!}
                                {!! Form::select('estciv_id',$estciv,null,['class'=>'custom-select','placeholder'=>'', 'disabled']) !!}
							</div>
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
@section('script')
<script>
    var url_global='{{url("/")}}';
    $(document).ready(function(){
        document.getElementById('guardar').addEventListener("click",function(){
            $("#ape_pat").prop('disabled', false);
            $("#ape_mat").prop('disabled', false);
            $("#nombres").prop('disabled', false);
            $("#razsoc").prop('disabled', false);
            $("#sexo_id").prop('disabled', false);
            $("#estciv_id").prop('disabled', false);
            // document.getElementById("nombre2").disabled = false;
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

        $('#numdoc').blur(function(e){
            e.preventDefault();
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
                    $.get(url_global+"/admin/clientes/"+td+"/"+numdoc+"/0/busapi/",function(response){
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
                                    document.getElementById("direccion").value = response['direccion'];
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

        $('#tipdoc_id').blur(function(e){
            // e.preventDefault();
            $("#razsoc").val('');
            $("#ape_pat").val('');
            $("#ape_mat").val('');
            $("#nombres").val('');
            $("#nomcomercial").val('');
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
        
        // document.getElementById('nombre2').addEventListener("blur",function(){
        //     this.value = this.value.toUpperCase();
        //     document.getElementById("razsoc").value = document.getElementById("ape_pat").value + ' '
        //         + document.getElementById("ape_mat").value + ' '
        //         + document.getElementById("nombres").value;// + ' '
        //         // + document.getElementById("nombre2").value;
        // });
    });
</script>
@endsection
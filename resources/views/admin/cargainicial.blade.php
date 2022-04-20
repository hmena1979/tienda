{{-- @extends('adminlte::page') --}}
@extends('admin.master')

@section('title', 'Parámetros del Sistema')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin') }}"><i class="fas fa-cogs"></i> Parámetros del Sistema</a>
	</li>
@endsection

{{-- @section('content_header')
    <h1>Inicio</h1>
@stop --}}

{{-- @section('content')
    <p>Contenido.</p>
@stop --}}
@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-cogs"></i><strong> Parámetros del Sistema</strong></h2>
						<ul>
							{{-- @if(kvfj(Auth::user()->permissions,'terapia_add')) --}}
							{{-- <li>
								<a class="btn btn-agregar mt-2" href="{{ url('/admin/terapia/add') }}">
									Agregar Evaluación
								</a>
                            </li> --}}
							{{-- @endif --}}
						</ul>
					</div>
					<div class="inside">
                        {!! Form::open(['route'=>'admin.cargainicial']) !!}
                        <label class="h2 mb-3">DATOS DE LA EMPRESA:</label>
                        <div class="row">
                            <div class="col-md-2 form-group">
								{!! Form::label('ruc', 'RUC') !!}
								{!! Form::text('ruc', null, ['class'=>'form-control','autocomplete'=>'off']) !!}	
							</div>
                            <div class="col-md-10 form-group">
								{!! Form::label('razsoc', 'Razón Social:') !!}
								{!! Form::text('razsoc', null, ['class'=>'form-control','autocomplete'=>'off']) !!}	
							</div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 form-group">
								{!! Form::label('usuario', 'Usuario(SUNAT - SOL):') !!}
								{!! Form::text('usuario', 'MODDATOS', ['class'=>'form-control','autocomplete'=>'off']) !!}	
							</div>
                            <div class="col-md-3 form-group">
								{!! Form::label('clave', 'Clave(SUNAT - SOL):') !!}
								{!! Form::text('clave', 'moddatos', ['class'=>'form-control','autocomplete'=>'off']) !!}	
							</div>
                            <div class="col-md-6 form-group">
								{!! Form::label('apitoken', 'Token API(RENIEC/SUNAT):') !!}
								{!! Form::text('apitoken', null, ['class'=>'form-control','autocomplete'=>'off']) !!}	
							</div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 form-group">
								{!! Form::label('servidor', 'Servidor(SUNAT - Envío comprobantes):') !!}
								{!! Form::text('servidor', null, ['class'=>'form-control','autocomplete'=>'off']) !!}	
							</div>
                            <div class="col-md-4 form-group">
								{!! Form::label('cuenta', 'Cuenta(Detraccíon):') !!}
								{!! Form::text('cuenta', null, ['class'=>'form-control','autocomplete'=>'off']) !!}	
							</div>
                            <div class="col-md-4 form-group">
								{!! Form::label('dominio', 'Dominio(www):') !!}
								{!! Form::text('dominio', null, ['class'=>'form-control','autocomplete'=>'off']) !!}	
							</div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 form-group">
								{!! Form::label('por_igv', 'Porcentaje IGV:') !!}
								{!! Form::text('por_igv', 18, ['class'=>'form-control','autocomplete'=>'off']) !!}	
							</div>
                            <div class="col-md-2 form-group">
								{!! Form::label('por_renta', 'Porcentaje Renta:') !!}
								{!! Form::text('por_renta', 8, ['class'=>'form-control','autocomplete'=>'off']) !!}	
							</div>
                            <div class="col-md-2 form-group">
								{!! Form::label('monto_renta', 'Monto Renta:') !!}
								{!! Form::text('monto_renta', 1500, ['class'=>'form-control','autocomplete'=>'off']) !!}	
							</div>
                            <div class="col-md-2 form-group">
								{!! Form::label('maximoboleta', 'Boleta S/D:') !!}
								{!! Form::text('maximoboleta', 700, ['class'=>'form-control','autocomplete'=>'off']) !!}	
							</div>
                            <div class="col-md-2 form-group">
								{!! Form::label('icbper', 'ICBPER:') !!}
								{!! Form::text('icbper', null, ['class'=>'form-control','autocomplete'=>'off']) !!}	
							</div>
                        </div>
                        <label class="h2 mb-3">DATOS DE LA SEDE:</label>
                        <div class="row">
                            <div class="col-md-10 form-group">
								{!! Form::label('nombre', 'Nombre:') !!}
								{!! Form::text('nombre', 'SEDE PRINCIPAL', ['class'=>'form-control','autocomplete'=>'off']) !!}	
							</div>
                            <div class="col-md-2 form-group">
								{!! Form::label('periodo', 'Periodo(Mes Año):') !!}
								{!! Form::text('periodo', null, ['class'=>'form-control','autocomplete'=>'off']) !!}	
							</div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 form-group">
								{!! Form::label('ubigeo', 'Ubigeo(Código):') !!}
								{!! Form::text('ubigeo', '200101', ['class'=>'form-control','autocomplete'=>'off']) !!}	
							</div>
                            <div class="col-md-5 form-group">
								{!! Form::label('direccion', 'Dirección:') !!}
								{!! Form::text('direccion', null, ['class'=>'form-control','autocomplete'=>'off']) !!}	
							</div>
                            <div class="col-md-5 form-group">
								{!! Form::label('urbanizacion', 'Urbanización:') !!}
								{!! Form::text('urbanizacion', null, ['class'=>'form-control','autocomplete'=>'off']) !!}	
							</div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 form-group">
								{!! Form::label('provincia', 'Provincia:') !!}
								{!! Form::text('provincia', null, ['class'=>'form-control','autocomplete'=>'off']) !!}	
							</div>
                            <div class="col-md-3 form-group">
								{!! Form::label('departamento', 'Departamento:') !!}
								{!! Form::text('departamento', null, ['class'=>'form-control','autocomplete'=>'off']) !!}	
							</div>
                            <div class="col-md-3 form-group">
								{!! Form::label('distrito', 'Distrito:') !!}
								{!! Form::text('distrito', null, ['class'=>'form-control','autocomplete'=>'off']) !!}	
							</div>
                            <div class="col-md-3 form-group">
								{!! Form::label('pais', 'País(Código):') !!}
								{!! Form::text('pais', 'PE', ['class'=>'form-control','autocomplete'=>'off']) !!}	
							</div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <strong>SERIES</strong>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2 form-group">
                                        {!! Form::label('factura_serie', 'Facturas:') !!}
                                        {!! Form::text('factura_serie', 'F001', ['class'=>'form-control','autocomplete'=>'off']) !!}	
                                    </div>
                                    <div class="col-md-2 form-group">
                                        {!! Form::label('boleta_serie', 'Boletas:') !!}
                                        {!! Form::text('boleta_serie', 'B001', ['class'=>'form-control','autocomplete'=>'off']) !!}	
                                    </div>
                                    <div class="col-md-2 form-group">
                                        {!! Form::label('ncfac_serie', 'NC Facturas:') !!}
                                        {!! Form::text('ncfac_serie', 'FC01', ['class'=>'form-control','autocomplete'=>'off']) !!}	
                                    </div>
                                    <div class="col-md-2 form-group">
                                        {!! Form::label('ncbol_serie', 'NC Boletas:') !!}
                                        {!! Form::text('ncbol_serie', 'BC01', ['class'=>'form-control','autocomplete'=>'off']) !!}	
                                    </div>
                                    <div class="col-md-2 form-group">
                                        {!! Form::label('ndfac_serie', 'ND Facturas:') !!}
                                        {!! Form::text('ndfac_serie', 'FD01', ['class'=>'form-control','autocomplete'=>'off']) !!}	
                                    </div>
                                    <div class="col-md-2 form-group">
                                        {!! Form::label('ndbol_serie', 'ND Boletas:') !!}
                                        {!! Form::text('ndbol_serie', 'BD01', ['class'=>'form-control','autocomplete'=>'off']) !!}	
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2 form-group">
                                        {!! Form::label('consumo_serie', 'Consumos:') !!}
                                        {!! Form::text('consumo_serie', 'C001', ['class'=>'form-control','autocomplete'=>'off']) !!}	
                                    </div>
                                    <div class="col-md-2 form-group">
                                        {!! Form::label('nota_serie', 'Notas:') !!}
                                        {!! Form::text('nota_serie', 'N001', ['class'=>'form-control','autocomplete'=>'off']) !!}	
                                    </div>
                                    <div class="col-md-2 form-group">
                                        {!! Form::label('factura_conting_serie', 'F.Contingencia:') !!}
                                        {!! Form::text('factura_conting_serie', '0001', ['class'=>'form-control','autocomplete'=>'off']) !!}	
                                    </div>
                                    <div class="col-md-2 form-group">
                                        {!! Form::label('boleta_conting_serie', 'B.Contingencia:') !!}
                                        {!! Form::text('boleta_conting_serie', '0001', ['class'=>'form-control','autocomplete'=>'off']) !!}	
                                    </div>
                                </div>
                            </div>
                        </div>
                        {!! Form::submit('Guardar', ['class'=>'btn btn-convertir mtop16']) !!}
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
        $(document).ready(function(){
            document.getElementById('razsoc').addEventListener("blur",function(){
                this.value = this.value.toUpperCase();
            });
            document.getElementById('direccion').addEventListener("blur",function(){
                this.value = this.value.toUpperCase();
            });
            document.getElementById('urbanizacion').addEventListener("blur",function(){
                this.value = this.value.toUpperCase();
            });
            document.getElementById('provincia').addEventListener("blur",function(){
                this.value = this.value.toUpperCase();
            });
            document.getElementById('departamento').addEventListener("blur",function(){
                this.value = this.value.toUpperCase();
            });
            document.getElementById('distrito').addEventListener("blur",function(){
                this.value = this.value.toUpperCase();
            });
            document.getElementById('pais').addEventListener("blur",function(){
                this.value = this.value.toUpperCase();
            });
        });
    </script>
@stop
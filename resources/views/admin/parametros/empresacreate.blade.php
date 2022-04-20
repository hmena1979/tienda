{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Categorias')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.parametros.index') }}"><i class="fas fa-cog"></i> Parametros</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
            <div class="col-md-12">
                {!! Form::open(['route'=>'admin.parametros.empresaStore']) !!}
                <div class="panelprin shadow">
                    <div class="headercontent">
                        <h2 class="title"><i class="fas fa-cog"></i> Empresas</h2>
                        <ul>
							{!! Form::submit('Guardar', ['class'=>'btn btn-convertir mt-2']) !!}
						</ul>
                    </div>
					<div class="inside">
                        <div class="row">
                            <div class="col-md-2 form-group">
								{!! Form::label('ruc', 'RUC') !!}
								{!! Form::text('ruc', null, ['class'=>'form-control','autocomplete'=>'off']) !!}	
							</div>
                            <div class="col-md-5 form-group">
								{!! Form::label('razsoc', 'Razón Social:') !!}
								{!! Form::text('razsoc', null, ['class'=>'form-control','autocomplete'=>'off']) !!}	
							</div>
                            <div class="col-md-5 form-group">
								{!! Form::label('nomcomercial', 'Nombre Comercial:') !!}
								{!! Form::text('nomcomercial', null, ['class'=>'form-control','autocomplete'=>'off']) !!}	
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
                        {{-- {!! Form::submit('Guardar', ['class'=>'btn btn-convertir mtop16']) !!} --}}
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
@section('script')
<script>
    var url_global='{{url("/")}}';
	$(document).ready(function(){
        $('#razsoc').blur(function(){
            $('#nomcomercial').val(this.value);
        });
    });
</script>
@endsection
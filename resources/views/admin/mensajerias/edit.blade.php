{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Destinatarios e-mail')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/mensajerias/'.$mensajeria->modulo) }}"><i class="fas fa-envelope"></i> Destinatario e-mail</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					{!! Form::model($mensajeria,['route'=>['admin.mensajerias.update',$mensajeria], 'method' => 'put']) !!}
                    <div class="headercontent">
                        @php($nombres = geMensajeriaArray())
                        <h2 class="title"><i class="fas fa-envelope"></i> Destinatario: <strong>{{ $nombres[$mensajeria->modulo] }}</strong></h2>
						<ul>
							<li>
								{!! Form::submit('Guardar', ['class'=>'btn btn-convertir mt-1']) !!}
							</li>
						</ul>
					</div>
					<div class="inside">
						<div class="row">                         
							<div class="col-md-4 form-group">
								{!! Form::label('nombre', 'Nombre:') !!}
								{!! Form::text('nombre', null, ['class'=>'form-control mayuscula','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-4 form-group">
								{!! Form::label('email', 'Correo Electrónico:') !!}
								{!! Form::email('email', null, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
						</div>
					</div>				
					{!! Form::close() !!}
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
</script>
@endsection
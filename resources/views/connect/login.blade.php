@extends('connect.master')
@section('title','Pesquera - Ingreso')

@section('content')
<div class="box box_login shadow">
	<div class="header">
		<a href="{{ url('/') }}">
			<img src="{{ url('/static/images/logo.png') }}" alt="">
		</a>
	</div>
	<div class="inside">
		{!! Form::open(['url' => '/login']) !!}
		<label for="email">Correo Electrónico</label>
		<div class="input-group">
			<div class="input-group-text"><i class="far fa-envelope-open"></i></div>
			{!! Form::email('email', null, ['class'=>'form-control']) !!}
		</div>
		<label class="mtop16" for="password">Contraseña</label>
		<div class="input-group">
			<div class="input-group-text"><i class="fas fa-unlock-alt"></i></div>
			{!! Form::password('password', ['class'=>'form-control']) !!}
		</div>
		{!! Form::submit('Ingresar',['class'=>'btn btn-convertir btn-block mtop16']) !!}
		{!! Form::close() !!}

		<div class="footer">
		</div>
	</div>

</div>
@stop
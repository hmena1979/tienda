@extends('connect.master')
@section('title','Tienda - Registro de usuario')

@section('content')
<div class="box box_register shadow">
	<div class="header">
		<a href="{{ url('/') }}">
			<img src="{{ url('/static/images/logo.png') }}" alt="">
		</a>
	</div>
	<div class="inside">
		{!! Form::open(['url' => '/registerate']) !!}
		<label for="name">Nombres</label>
		<div class="input-group">
			<div class="input-group-text">@</div>
			{!! Form::text('name', null, ['class'=>'form-control','required']) !!}
		</div>
		<label for="email" class="mtop16">Correo Electrónico</label>
		<div class="input-group">
			<div class="input-group-text">@</div>
			{!! Form::email('email', null, ['class'=>'form-control','required']) !!}
		</div>
		<label class="mtop16" for="password">Contraseña</label>
		<div class="input-group">
			<div class="input-group-text">?</div>
			{!! Form::password('password', ['class'=>'form-control','required']) !!}
		</div>
		<label class="mtop16" for="cpassword">Confirmar Contraseña</label>
		<div class="input-group">
			<div class="input-group-text">?</div>
			{!! Form::password('cpassword', ['class'=>'form-control','required']) !!}
		</div>
		{!! Form::submit('Registrar',['class'=>'btn btn-success mtop16']) !!}
		{!! Form::close() !!}

		<div class="mtop16 footer">
			<a href="{{ url('/loginate') }}">Regresar</a>
		</div>
	</div>

</div>
@stop
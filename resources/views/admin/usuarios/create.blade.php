{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Usuarios')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/usuarios/all') }}"><i class="fas fa-user-friends"></i> Usuarios</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					<div class="inside">
						{!! Form::open(['route'=>'admin.usuarios.store']) !!}
						<div class="row">
							<div class="col-md-2 form-group">
								<label for="activo">Activo:</label>
								{!! Form::label('activo', 'Activo') !!}
								{!! Form::select('activo',['1'=>'Si','2'=>'No'],1,['class'=>'custom-select']) !!}	
							</div>
							<div class="col-md-10 form-group">
								{!! Form::label('name', 'Nombre') !!}
								{!! Form::text('name', '', ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
						</div>
						<div class="row">
							<div class="col-md-4 form-group">
								{!! Form::label('email', 'e-mail') !!}
								{!! Form::text('email', null, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-4 form-group">
								{!! Form::label('password', 'Contraseña') !!}
								{!! Form::password('password', ['class'=>'form-control']) !!}
							</div>
							<div class="col-md-4 form-group">
								{!! Form::label('cpassword', 'Confirmar Contraseña') !!}
								{!! Form::password('cpassword', ['class'=>'form-control']) !!}
							</div>
						</div>
						{{-- <div class="row mtop16">
							<div class="col-md-6">
								<label for="doctor_id">Doctor asignado al usuario:</label>
								{!! Form::select('doctor_id',$doctores,1,['class'=>'custom-select']) !!}	
							</div>
						</div> --}}
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
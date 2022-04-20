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
						{{-- {!! Form::open(['url'=>'/admin/usuario/'.$user->id.'/edit']) !!} --}}
						{!! Form::model($user, ['route' => ['admin.usuarios.update',$user], 'method' => 'put']) !!}
						<div class="row">
							<div class="col-md-2 form-group">
								{!! Form::label('activo', 'Activo') !!}
								{!! Form::select('activo',['1'=>'Si','2'=>'No'],null,['class'=>'custom-select']) !!}
							</div>
							<div class="col-md-6 form-group">
								{!! Form::label('name', 'Nombre') !!}
								{!! Form::text('name', null, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-4 form-group">
								{!! Form::label('email', 'e-mail') !!}
								{!! Form::text('email', null, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
						</div>
						{{-- <div class="row mtop16">
							<div class="col-md-6">
								<label for="doctor_id">Doctor asignado al usuario:</label>
								{!! Form::select('doctor_id',$doctores,$user->doctor_id,['class'=>'custom-select']) !!}	
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
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
						{{-- {!! Form::open(['url'=>'/admin/usuario/'.$user->id.'/password']) !!} --}}
						{!! Form::open(['route' => ['admin.usuarios.updatepassword',$user], 'method' => 'put']) !!}
						<div class="row">					
							<div class="col-md-2">
								<label for="activo">Activo:</label>
								{!! Form::select('activo',['1'=>'Si','2'=>'No'],$user->activo,['class'=>'custom-select', 'disabled']) !!}	
							</div>
							<div class="col-md-6">
								<label for="nombre">Nombre:</label>
								{!! Form::text('name', $user->name, ['class'=>'form-control','autocomplete'=>'off', 'disabled']) !!}
							</div>
							<div class="col-md-4">
								<label for="email">e-mail:</label>
								{!! Form::text('email', $user->email, ['class'=>'form-control','autocomplete'=>'off', 'disabled']) !!}
							</div>
                        </div>
                        <div class="row mtop16">
							<div class="col-md-4">
								<label for="password">Nueva contraseña:</label>
								{!! Form::password('password', ['class'=>'form-control']) !!}
							</div>
							<div class="col-md-4">
								<label for="cpassword">Confirmar Contraseña:</label>
								{!! Form::password('cpassword', ['class'=>'form-control']) !!}
							</div>
						</div>
						{!! Form::submit('Cambiar', ['class'=>'btn btn-convertir mtop16']) !!}
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
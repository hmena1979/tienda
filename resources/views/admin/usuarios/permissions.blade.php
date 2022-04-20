{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Usuarios')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/usuarios/all') }}"><i class="fas fa-user-friends"></i> Usuarios</a>
    </li>
    <li class="breadcrumb-item">
    <a href="{{ url('/admin/usuarios/all') }}"><i class="fas fa-cogs"></i> Permisos de  Usuario: <strong>{{ $user->name }}</strong></a>
	</li>
@endsection

@section('contenido')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="panelprin shadow">
                <div class="inside">
                    {{-- {!! Form::open(['url'=>'/admin/usuario/'.$user->id.'/edit']) !!} --}}
                    <h2><h5>Listado de Roles</h5></h2>
                    {!! Form::model($user, ['route' => ['admin.usuarios.updatepermission',$user], 'method' => 'put']) !!}
                    @foreach ($roles as $rol)
                    <div>
                        <label>
                            {!! Form::checkbox('roles[]', $rol->id, null) !!}
                            <label>{{$rol->name}}</label>
                        </label>
                    </div>
                    @endforeach
                    {{-- <div class="row">
                        <div class="col-md-2 form-group">
                            {!! Form::label('activo', 'Activo') !!}
                            {!! Form::select('activo',['1'=>'Si','2'=>'No'],null,['class'=>'custom-select']) !!}
                        </div>
                        <div class="col-md-3 form-group">
                            {!! Form::label('nombre', 'Nombre') !!}
                            {!! Form::text('nombre', null, ['class'=>'form-control','autocomplete'=>'off']) !!}
                        </div>
                        <div class="col-md-3 form-group">
                            {!! Form::label('apellido', 'Apellido') !!}
                            {!! Form::text('apellido', null, ['class'=>'form-control','autocomplete'=>'off']) !!}
                        </div>
                        <div class="col-md-4 form-group">
                            {!! Form::label('email', 'e-mail') !!}
                            {!! Form::text('email', null, ['class'=>'form-control','autocomplete'=>'off']) !!}
                        </div>
                    </div> --}}
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
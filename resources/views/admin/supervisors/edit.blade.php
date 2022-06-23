{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Supervisores')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.supervisors.index') }}"><i class="fas fa-chalkboard-teacher"></i> Supervisores</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					{!! Form::model($supervisor, ['route'=>['admin.supervisors.update', $supervisor], 'method'=>'put']) !!}
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-chalkboard-teacher"></i> Supervisores</h2>
						<ul>
							<li>
								{!! Form::submit('Guardar', ['class'=>'btn btn-convertir mt-1']) !!}
							</li>
						</ul>
					</div>
					<div class="inside">
						<div class="row">
							<div class="col-md-7 form-group">
								{!! Form::label('nombre', 'Nombre:') !!}
								{!! Form::text('nombre', null, ['class'=>'form-control mayuscula','maxlength'=>'100','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-3 form-group">
								{!! Form::label('cargo', 'Cargo:') !!}
								{!! Form::text('cargo', null, ['class'=>'form-control mayuscula','maxlength'=>'50','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-2 form-group">
								{!! Form::label('activo', 'Activo') !!}
								{!! Form::select('activo',['1'=>'Si','2'=>'No'],1,['class'=>'custom-select']) !!}	
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
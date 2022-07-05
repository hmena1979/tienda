{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Paises')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.countries.index') }}"><i class="fas fa-globe-americas"></i> Paises</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					{!! Form::open(['route'=>'admin.countries.store']) !!}
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-globe-americas"></i> Paises (Codificación según estandar ISO 3166-2)</h2>
						<ul>
							<li>
								{!! Form::submit('Guardar', ['class'=>'btn btn-convertir mt-1']) !!}
							</li>
						</ul>
					</div>
					<div class="inside">
						{{-- {!! Form::open(['url'=>'/admin/categoria/add/'.$module]) !!} --}}
						<div class="row">
							<div class="col-md-2 form-group">
								{!! Form::label('codigo', 'Código:') !!}
								{!! Form::text('codigo', null, ['class'=>'form-control mayuscula','maxlength'=>'10','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-7 form-group">
								{!! Form::label('nombre', 'Nombre:') !!}
								{!! Form::text('nombre', null, ['class'=>'form-control mayuscula','maxlength'=>'50','autocomplete'=>'off']) !!}
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
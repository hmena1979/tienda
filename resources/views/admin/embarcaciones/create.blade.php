{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Embarcaciones')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.embarcaciones.index') }}"><i class="fas fa-anchor"></i> Embarcaciones</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					{!! Form::open(['route'=>'admin.embarcaciones.store']) !!}
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-anchor"></i> Embarcaciones</h2>
                            <ul>
								<li>{!! Form::submit('Guardar', ['class'=>'btn btn-convertir mt-2']) !!}</li>
                            </ul>
                        </div>
					<div class="inside">
						{{-- {!! Form::open(['url'=>'/admin/categoria/add/'.$module]) !!} --}}
						<div class="row">
							<div class="col-md-4 form-group">
								{!! Form::hidden('empresa_id', session('empresa')) !!}
								{!! Form::label('nombre', 'Nombre:') !!}
								{!! Form::text('nombre', null, ['class'=>'form-control mayuscula','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-2 form-group">
								{!! Form::label('matricula', 'Matrícula:') !!}
								{!! Form::text('matricula', null, ['class'=>'form-control mayuscula','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-2 form-group">
								{!! Form::label('protoc', 'Protoc.Sanipes:') !!}
								{!! Form::text('protoc', null, ['class'=>'form-control mayuscula','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-2 form-group">
								{!! Form::label('capacidad', 'Cap. Bodega:') !!}
								{!! Form::text('capacidad', null, ['class'=>'form-control decimal','autocomplete'=>'off']) !!}
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
@endsection
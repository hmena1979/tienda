{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Detracciones')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.detraccions.index') }}"><i class="fas fa-receipt"></i> Detracciones</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-receipt"></i> Detracciones</h2>
                            <ul>
                            </ul>
                        </div>
					<div class="inside">
						{{-- {!! Form::open(['url'=>'/admin/categoria/add/'.$module]) !!} --}}
						{!! Form::open(['route'=>'admin.detraccions.store']) !!}
						<div class="row">
							<div class="col-md-2 form-group">
								{!! Form::label('codigo', 'Código:') !!}
								{!! Form::text('codigo', null, ['class'=>'form-control numero','maxlength'=>'3','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-7 form-group">
								{!! Form::label('nombre', 'Nombre:') !!}
								{!! Form::text('nombre', null, ['class'=>'form-control mayuscula','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-2 form-group">
								{!! Form::label('tasa', 'Tasa %:') !!}
								{!! Form::text('tasa', null, ['class'=>'form-control decimal','autocomplete'=>'off']) !!}
							</div>
						</div>
						{!! Form::submit('Guardar', ['class'=>'btn btn-convertir']) !!}
						{!! Form::close() !!}

					</div>				
				</div>
			</div>

		</div>		
	</div>
@endsection

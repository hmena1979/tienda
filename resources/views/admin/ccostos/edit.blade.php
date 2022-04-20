@extends('admin.master')
@section('title','Centros de Costo')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.ccostos.index') }}"><i class="fas fa-grip-horizontal"></i> Centros de Costo</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-grip-horizontal"></i> Centros de Costo</h2>
                            <ul>
                            </ul>
                        </div>
					<div class="inside">
						{{-- {!! Form::open(['url'=>'/admin/categoria/add/'.$module]) !!} --}}
						{!! Form::model($ccosto, ['route'=>['admin.ccostos.update', $ccosto], 'method'=>'put']) !!}
						<div class="row">
							<div class="col-md-7 form-group">
								{!! Form::label('nombre', 'Nombre:') !!}
								{!! Form::text('nombre', null, ['class'=>'form-control mayuscula','autocomplete'=>'off']) !!}
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

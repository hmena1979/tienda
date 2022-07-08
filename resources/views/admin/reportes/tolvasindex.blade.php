@extends('admin.master')
@section('title','Reportes')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.excel.tolvasindex') }}"><i class="fas fa-print"></i> Reportes Mensuales</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-6">
                {!! Form::open(['route'=>'admin.excel.tolvasview']) !!}
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-print"></i> Reporte Mensual de Tolvas</h2>
						<ul>
							<li>
                                {!! Form::submit('Mostrar', ['class'=>'btn btn-convertir mt-1', 'id'=>'mostrar']) !!}
                            </li>
						</ul>
					</div>
					<div class="inside">
                        <div class="row">
                            <div class="col-md-5 form-group">
                                {!! Form::label('mes', 'Meses:') !!}
								{!! Form::select('mes',getMeses(), Str::substr(session('periodo'),0,2),['class'=>'custom-select']) !!}
							</div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('anio', 'Año:') !!}
								{!! Form::text('anio', Str::substr(session('periodo'), 2, 4), ['class'=>'form-control']) !!}
							</div>
                        </div>

                    </div>
                </div>
                {!! Form::close() !!}
            </div>
			<div class="col-md-6">
                {!! Form::open(['route'=>'admin.excel.residuos']) !!}
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-print"></i> Reporte Mensual de Residuos</h2>
						<ul>
							<li>
                                {!! Form::submit('Mostrar', ['class'=>'btn btn-convertir mt-1', 'id'=>'mostrar']) !!}
                            </li>
						</ul>
					</div>
					<div class="inside">
                        <div class="row">
                            <div class="col-md-5 form-group">
                                {!! Form::label('mes', 'Meses:') !!}
								{!! Form::select('mes',getMeses(), Str::substr(session('periodo'),0,2),['class'=>'custom-select']) !!}
							</div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('anio', 'Año:') !!}
								{!! Form::text('anio', Str::substr(session('periodo'), 2, 4), ['class'=>'form-control']) !!}
							</div>
                        </div>

                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
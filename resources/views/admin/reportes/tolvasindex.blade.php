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
								{!! Form::text('anio', Str::substr(session('periodo'), 2, 4), ['class'=>'form-control numero','maxlength'=>'4']) !!}
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
								{!! Form::text('anio', Str::substr(session('periodo'), 2, 4), ['class'=>'form-control numero','maxlength'=>'4']) !!}
							</div>
                        </div>

                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
		<div class="row mt-3">
			<div class="col-md-4">
                {!! Form::open(['route'=>'admin.excel.porpagar']) !!}
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-print"></i> Cuentas por Pagar</h2>
						<ul>
							<li>
                                {!! Form::submit('Mostrar', ['class'=>'btn btn-convertir mt-1', 'id'=>'mostrar']) !!}
                            </li>
						</ul>
					</div>
					<div class="inside">
                        <div class="row">
							<div class="col-md-6 form-group">
                                {!! Form::label('desde', 'Desde:') !!}
                                {!! Form::date('desde', primerDiaPeriodo(pAnterior(session('periodo'))), ['class'=>'form-control activo']) !!}
                            </div>
							<div class="col-md-6 form-group">
                                {!! Form::label('hasta', 'Hasta:') !!}
                                {!! Form::date('hasta', Carbon\Carbon::now(), ['class'=>'form-control activo']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
			<div class="col-md-8">
                {!! Form::open(['route'=>'admin.excel.proveedor']) !!}
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-print"></i> Detallado por Proveedor</h2>
						<ul>
							<li>
                                {!! Form::submit('Mostrar', ['class'=>'btn btn-convertir mt-1', 'id'=>'mostrar']) !!}
                            </li>
						</ul>
					</div>
					<div class="inside">
                        <div class="row">
							<div class="col-md-5 form-group">
                                {!! Form::label('cliente_id', 'Proveedor:') !!}
								{!! Form::select('cliente_id',[],null,['class'=>'custom-select activo','id'=>'cliente_id','placeholder'=>'']) !!}
                            </div>
							<div class="col-md-2">
								{!! Form::label('moneda', 'Moneda:') !!}
								{!! Form::select('moneda',['PEN'=>'SOLES','USD'=>'DÓLARES'],null,['class'=>'custom-select']) !!}
							</div>
							<div class="col-md-5">
								<div class="row">
									<div class="col-md-6 form-group">
										{!! Form::label('desde', 'Desde:') !!}
										{!! Form::date('desde', primerDiaPeriodo(pAnterior(session('periodo'))), ['class'=>'form-control activo']) !!}
									</div>
									<div class="col-md-6 form-group">
										{!! Form::label('hasta', 'Hasta:') !!}
										{!! Form::date('hasta', Carbon\Carbon::now(), ['class'=>'form-control activo']) !!}
									</div>
								</div>
							</div>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
		</div>
    </div>
@endsection
@section('script')
<script>
    var url_global='{{url("/")}}';
    $(document).ready(function(){
        $('#cliente_id').select2({
            placeholder:"Ingrese 4 dígitos del RUC o Razón Social",
            minimumInputLength: 4,
            ajax:{
                url: "{{ route('admin.clientes.seleccionado',1) }}",
                dataType:'json',
                delay:250,
                processResults:function(response){
                    return{
                        results: response
                    };
                },
                cache: true,
            }
        });
	});
</script>
@endsection
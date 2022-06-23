@extends('admin.master')
@section('title','Parte de Producción')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.partes.index') }}"><i class="fas fa-industry"></i> Parte de Producción</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
                    {!! Form::open(['route'=>'admin.partes.store']) !!}
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-industry"></i> Parte de Producción</h2>
                            <ul>
                                {!! Form::submit('Guardar', ['class'=>'btn btn-convertir mt-2']) !!}
                            </ul>
                        </div>
					<div class="inside">
						{!! Form::hidden('empresa_id', session('empresa')) !!}
                        {!! Form::hidden('periodo', session('periodo')) !!}
						<div class="row">
							<div class="col-md-2 form-group">
                                {!! Form::label('lote', 'Lote:') !!}
                                {!! Form::select('lote',$lotes,null,['class'=>'custom-select']) !!}
                            </div>
							<div class="col-md-2 form-group">
                                {!! Form::label('recepcion', 'Fecha Recepción:') !!}
                                {!! Form::date('recepcion', Carbon\Carbon::now(), ['class'=>'form-control']) !!}
                            </div>
							<div class="col-md-2 form-group">
                                {!! Form::label('congelacion', 'Fecha Congelación:') !!}
                                {!! Form::date('congelacion', Carbon\Carbon::now(), ['class'=>'form-control']) !!}
                            </div>
							<div class="col-md-2 form-group">
                                {!! Form::label('empaque', 'Fecha Empaque:') !!}
                                {!! Form::date('empaque', Carbon\Carbon::now(), ['class'=>'form-control']) !!}
                            </div>
							<div class="col-md-4">
								<div class="row">
									<div class="col-md-5 form-group">
										{!! Form::label('vencimiento', 'Fecha Vencimiento:') !!}
                                		{!! Form::date('vencimiento', Carbon\Carbon::now()->addYear(2), ['class'=>'form-control']) !!}
									</div>
									<div class="col-md-7 form-group">
										{!! Form::label('trazabilidad', 'Código Trazabilidad:') !!}
										{!! Form::text('trazabilidad', null, ['class'=>'form-control mayuscula','maxlength'=>'20','autocomplete'=>'off']) !!}
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2 form-group">
								{!! Form::label('produccion', 'Producción:') !!}
								{!! Form::select('produccion',[1 => 'Propia', 2 => 'Por Encargo'],null,['class'=>'custom-select']) !!}
							</div>
							<div class="col-md-3 form-group">
                                {!! Form::label('contrata_id', 'Mano de Obra:') !!}
                                {!! Form::select('contrata_id',$contratas,null,['class'=>'custom-select']) !!}
                            </div>
							<div class="col-md-1 form-group">
								{!! Form::label('hombres', 'Hombres:') !!}
								{!! Form::text('hombres', null, ['class'=>'form-control numero','maxlength'=>'4','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-1 form-group">
								{!! Form::label('mujeres', 'Mujeres:') !!}
								{!! Form::text('mujeres', null, ['class'=>'form-control numero','maxlength'=>'4','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-2 form-group">
								{!! Form::label('turno', 'Turno:') !!}
								{!! Form::select('turno',[1 => 'Dia', 2 => 'Noche'],null,['class'=>'custom-select']) !!}
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
{{-- @section('script')
<script>
	$('#codigo').blur(function(){
		this.value = this.value.toUpperCase();
	});
	$('#nombre').blur(function(){
		this.value = this.value.toUpperCase();
	});
</script>
@endsection --}}
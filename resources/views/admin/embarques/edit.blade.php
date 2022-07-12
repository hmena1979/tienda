{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Residuos Sólidos')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.residuos.index') }}"><i class="far fa-trash-alt"></i> Residuos Sólidos</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					{!! Form::model($residuo, ['route'=>['admin.residuos.update', $residuo], 'method'=>'put']) !!}
					<div class="headercontent">
						<h2 class="title"><i class="far fa-trash-alt"></i> Residuos Sólidos</h2>
						<ul>
							<li>
								{!! Form::submit('Guardar', ['class'=>'btn btn-convertir mt-1']) !!}
							</li>
						</ul>
					</div>
					<div class="inside">
						<div class="row">
							<div class="col-md-2 form-group">
                                {!! Form::label('lote', 'Lote:') !!}
                                {!! Form::select('lote',$lotes,null,['class'=>'custom-select']) !!}
                            </div>
							<div class="col-md-2 form-group">
								{!! Form::label('especie', 'Especie:') !!}
								{!! Form::text('especie', 'POTA', ['class'=>'form-control mayuscula','maxlength'=>'30','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-4 form-group">
                                {!! Form::label('cliente_id', 'Cliente:') !!}
								{!! Form::select('cliente_id',$clientes,null,['class'=>'custom-select activo','id'=>'cliente_id','placeholder'=>'']) !!}
                            </div>
							<div class="col-md-2 form-group">
								{!! Form::label('ticket_balanza', 'Pesaje N°:') !!}
								{!! Form::text('ticket_balanza', null, ['class'=>'form-control mayuscula','maxlength'=>'15','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-2 form-group">
                                {!! Form::label('emision', 'Fecha Emisión:') !!}
                                {!! Form::date('emision', null, ['class'=>'form-control']) !!}
                            </div>
						</div>
						<div class="row">
							<div class="col-md-2 form-group">
								{!! Form::label('guiamps', 'Guía MPS:') !!}
								{!! Form::text('guiamps', null, ['class'=>'form-control mayuscula','maxlength'=>'15','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-2 form-group">
								{!! Form::label('guiahl', 'Guía HL:') !!}
								{!! Form::text('guiahl', null, ['class'=>'form-control mayuscula','maxlength'=>'15','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-2 form-group">
								{!! Form::label('guiatrasporte', 'Guía Transportista:') !!}
								{!! Form::text('guiatrasporte', null, ['class'=>'form-control mayuscula','maxlength'=>'15','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-3">
								<div class="row">
									<div class="col-md-6 form-group">
										{!! Form::label('peso', 'Total Kgs:') !!}
										{!! Form::text('peso', null, ['class'=>'form-control decimal calcula','maxlength'=>'15','autocomplete'=>'off']) !!}
									</div>
									<div class="col-md-6 form-group">
										{!! Form::label('placa', 'N° Placa:') !!}
										{!! Form::text('placa', null, ['class'=>'form-control mayuscula','maxlength'=>'15','autocomplete'=>'off']) !!}
									</div>
								</div>
							</div>
							@can('admin.residuos.precio')
							<div class="col-md-3">
								<div class="row">
									<div class="col-md-6 form-group">
										{!! Form::label('precio', 'Precio Kg:') !!}
										{!! Form::text('precio', null, ['class'=>'form-control decimal calcula','maxlength'=>'15','autocomplete'=>'off']) !!}
									</div>
									<div class="col-md-6 form-group">
										{!! Form::label('total', 'Total:') !!}
										{!! Form::text('total', null, ['class'=>'form-control decimal calcula','maxlength'=>'15','autocomplete'=>'off']) !!}
									</div>
								</div>
							</div>
							@endcan
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

		$('.calcula').blur(function(){
			$('#total').val(Redondea($('#peso').val() * $('#precio').val(),2));
		});
    });
</script>
@endsection
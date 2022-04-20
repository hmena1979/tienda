{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Caja y Bancos')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.tesorerias.index') }}"><i class="fas fa-funnel-dollar"></i> Caja y Bancos</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					<div class="inside">
						{{-- {!! Form::open(['url'=>'/admin/categoria/add/'.$module]) !!} --}}
						{!! Form::open(['route'=>'admin.tesorerias.store']) !!}
                        {!! Form::hidden('empresa_id', session('empresa')) !!}
                        {!! Form::hidden('sede_id', session('sede')) !!}
                        {!! Form::hidden('periodo', session('periodo')) !!}
						<div class="row">
                            <div class="col-md-2 form-group">
                                {!! Form::label('cuenta_id', 'Cuenta:') !!}
                                {!! Form::select('cuenta_id',$cuentas,$cuenta,['class'=>'custom-select']) !!}
                            </div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('tipo', 'Tipo:') !!}
                                {!! Form::select('tipo',[1=>'ABONO',2=>'CARGO'],2,['class'=>'custom-select']) !!}
                            </div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('fecha', 'Fecha:') !!}
                                {!! Form::date('fecha', null, ['class'=>'form-control activo']) !!}
                            </div>
                            <div class="col-md-1 form-group">
                                {!! Form::label('tc', 'TC:') !!}
                                {!! Form::text('tc', null, ['class'=>'form-control decimal activo','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-3 form-group">
                                {!! Form::label('mediopago', 'Medio Pago:') !!}
                                {!! Form::select('mediopago',$mediopago,null,['class'=>'custom-select activo','placeholder'=>'']) !!}
                            </div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('numerooperacion', 'N° Operación:') !!}
                                {!! Form::text('numerooperacion', null, ['class'=>'form-control activo','maxlength'=>'15','autocomplete'=>'off']) !!}
                            </div>
						</div>
                        <div class="row">
                            <div class="col-md-2 form-group">
                                {!! Form::label('notaegreso', 'Nota Egreso:') !!}
                                {!! Form::text('notaegreso', null, ['class'=>'form-control activo','maxlength'=>'10','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-7 form-group">
                                {!! Form::label('glosa', 'Glosa:') !!}
                                {!! Form::text('glosa', null, ['class'=>'form-control mayuscula','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('monto', 'Monto:') !!}
                                {!! Form::text('monto', null, ['class'=>'form-control activo','autocomplete'=>'off','disabled']) !!}
                            </div>
                            <div class="col-md-1">
                                {!! Form::submit('Guardar', ['class'=>'btn btn-convertir mtop20']) !!}
                            </div>
                        </div>
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

@section('script')
<script>
    var url_global='{{url("/")}}';
    $(document).ready(function(){
        $('#fecha').blur(function(){
            $.get(url_global+"/admin/rcompras/"+this.value+"/bustc/",function(response){
                $('#tc').val(response['venta']);
            });
        });
    });
</script>
@endsection
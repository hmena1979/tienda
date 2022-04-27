@extends('admin.master')
@section('title','Pagos Masivos')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.masivos.index') }}"><i class="fas fa-file-invoice-dollar"></i> Pagos Masivos</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
            <div class="col-md-12">
                {!! Form::open(['route'=>'admin.masivos.store']) !!}
				<div class="panelprin shadow">
                    <div class="headercontent">
						<h2 class="title"><i class="fas fa-file-invoice-dollar"></i> Pagos Masivos</h2>
						<ul>
                            <li>
                                {!! Form::submit('Guardar', ['class'=>'btn btn-convertir mt-2', 'id'=>'guardar']) !!}
                            </li>
						</ul>
					</div>
					<div class="inside">
                        {!! Form::hidden('empresa_id', session('empresa')) !!}
                        {!! Form::hidden('sede_id', session('sede')) !!}
                        {!! Form::hidden('periodo', session('periodo')) !!}
						<div class="row">
                            <div class="col-md-2 form-group">
                                {!! Form::label('cuenta_id', 'Cuenta:') !!}
                                {!! Form::select('cuenta_id',$cuentas,null,['class'=>'custom-select', 'placeholder'=>'Seleccione Cuenta']) !!}
                            </div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('fecha', 'Fecha:') !!}
                                {!! Form::date('fecha', null, ['class'=>'form-control activo']) !!}
                            </div>
                            <div class="col-md-1 form-group">
                                {!! Form::label('tc', 'TC:') !!}
                                {!! Form::text('tc', null, ['class'=>'form-control decimal activo','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-7 form-group">
                                {!! Form::label('glosa', 'Glosa:') !!}
                                {!! Form::text('glosa', null, ['class'=>'form-control mayuscula','autocomplete'=>'off']) !!}
                            </div>
						</div>
					</div>				
				</div>
                {!! Form::close() !!}
                
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
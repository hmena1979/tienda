{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Saldo Inicial - Producto Terminado')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.productoterminados.index') }}"><i class="fas fa-dolly-flatbed"></i> Saldo Inicial - Producto Terminado</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					{!! Form::model($productoterminado, ['route'=>['admin.productoterminados.update', $productoterminado], 'method'=>'put']) !!}
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-dolly-flatbed"></i> Saldo Inicial - Producto Terminado</h2>
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
								{!! Form::text('lote', null, ['class'=>'form-control mayuscula','maxlength'=>'15','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-3 form-group">
								{!! Form::label('pproceso_id', 'Producto:') !!}
								{!! Form::select('pproceso_id',$pprocesos,null,['class'=>'custom-select','placeholder'=>'Seleccione Producto']) !!}
							</div>
							<div class="col-md-3 form-group">
								{!! Form::label('trazabilidad_id', 'Trazabilidad:') !!}
								{!! Form::select('trazabilidad_id',$trazabililidad,null,['class'=>'custom-select','placeholder'=>'Seleccione Trazabilidad']) !!}
							</div>
							<div class="col-md-3 form-group">
								{!! Form::label('dettrazabilidad_id', 'Código:') !!}
								{!! Form::select('dettrazabilidad_id',$dettrazabililidad,null,['class'=>'custom-select','placeholder'=>'Seleccione Código']) !!}
							</div>
						</div>
						<div class="row">
							<div class="col-md-2 form-group">
                                {!! Form::label('empaque', 'Fecha Empaque:') !!}
                                {!! Form::date('empaque', null, ['class'=>'form-control']) !!}
                            </div>
							<div class="col-md-2 form-group">
								{!! Form::label('vencimiento', 'Fecha Vencimiento:') !!}
								{!! Form::date('vencimiento', null, ['class'=>'form-control']) !!}
							</div>
							<div class="col-md-2 form-group">
								{!! Form::label('entradas', 'Sacos:') !!}
								{!! Form::text('entradas', null, ['class'=>'form-control numero','maxlength'=>'10','autocomplete'=>'off']) !!}
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
<script>
    var url_global='{{url("/")}}';
	$(document).ready(function(){
		$('#pproceso_id').change(function(){
			const producto = this.value;
            $.get(url_global+"/admin/busquedas/"+producto+"/trazabilidad/",function(response){
                $('#trazabilidad_id').empty();
                for(i=0;i<response.length;i++){
                    $('#trazabilidad_id').append("<option value='"+response[i].id+"'>"
                        + response[i].nombre
                        + "</option>");
                }
                $('#trazabilidad_id').val(null);
                $('#dettrazabilidad_id').empty();
            });
		});

		$('#trazabilidad_id').change(function(){
			const trazabilidad = this.value;
            $.get(url_global+"/admin/busquedas/"+trazabilidad+"/dettrazabilidad/",function(response){
                $('#dettrazabilidad_id').empty();
                for(i=0;i<response.length;i++){
                    $('#dettrazabilidad_id').append("<option value='"+response[i].id+"'>"
                        + response[i].codigo
                        + "</option>");
                }
                $('#dettrazabilidad_id').val(null);
            });
		});

		$('#empaque').blur(function(){
            $('#vencimiento').val(sumarAnio(this.value,2));
        });
	});
</script>
@endsection
@extends('admin.master')
@section('title','Reportes')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.excel.procesoindex') }}"><i class="fas fa-print"></i> Reportes Proceso</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-7 d-flex">
                {!! Form::open(['route'=>'admin.excel.tolvasview']) !!}
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-print"></i> Productos Terminados - Detallado</h2>
						<ul>
							<li>
                                {!! Form::submit('Mostrar', ['class'=>'btn btn-convertir mt-1', 'id'=>'mostrar']) !!}
                            </li>
						</ul>
					</div>
					<div class="inside">
                        <div class="row">
                            <div class="col-md-4 form-group">
								{!! Form::label('pproceso_id', 'Producto:') !!}
								{!! Form::select('pproceso_id',$pprocesos,null,['class'=>'custom-select','placeholder'=>'Seleccione Producto']) !!}
							</div>
							<div class="col-md-4 form-group">
								{!! Form::label('trazabilidad_id', 'Trazabilidad:') !!}
								{!! Form::select('trazabilidad_id',[],null,['class'=>'custom-select','placeholder'=>'Seleccione Trazabilidad']) !!}
							</div>
							<div class="col-md-4 form-group">
								{!! Form::label('dettrazabilidad_id', 'Código:') !!}
								{!! Form::select('dettrazabilidad_id',[],null,['class'=>'custom-select','placeholder'=>'Seleccione Código']) !!}
							</div>
                        </div>

                    </div>
                </div>
                {!! Form::close() !!}
            </div>
			<div class="col-md-5 d-flex">
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-print"></i> Productos Terminados - Resumen</h2>
						<ul>
						</ul>
					</div>
					<div class="inside">
                        <div class="row">
                            <div class="col-md-6">
                                <a class="btn btn-block btn-convertir" href="{{ route('admin.excel.resumentrazabilidad') }}">
                                    Resumen Trazabilidad
                                </a>
							</div>
                            <div class="col-md-6">
                                <a class="btn btn-block btn-convertir" href="{{ route('admin.excel.resumencodigo') }}">
                                    Resumen Códigos
                                </a>
							</div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
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
                        + response[i].mpd_codigo
                        + "</option>");
                }
                $('#dettrazabilidad_id').val(null);
            });
		});
	});
</script>
@endsection
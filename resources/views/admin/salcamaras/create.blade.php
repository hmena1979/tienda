{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Guía de Salida a Cámaras')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.salcamaras.index') }}"><i class="fas fa-clipboard-check"></i> Guía de Salida a Cámaras</a>
	</li>
@endsection

@section('contenido')
    <div id="mensaje_error" class="alert alert-danger" style="display:none;">
        <strong id="contenido_error"></strong>
    </div>
	<div class="container-fluid">
		<div class="row"  id = 'agregarcomprobante'>
            <div class="col-md-12">
                {!! Form::open(['route'=>'admin.salcamaras.store']) !!}
                {!! Form::hidden('empresa_id', session('empresa')) !!}
                {!! Form::hidden('periodo', session('periodo')) !!}
				<div class="panelprin shadow">
                    <div class="headercontent">
						<h2 class="title"><i class="fas fa-clipboard-check"></i> Guía de Salida a Cámaras</h2>
						<ul>
                            <li>
                                {!! Form::submit('Guardar', ['class'=>'btn btn-convertir mt-1', 'id'=>'guardar']) !!}
                            </li>
						</ul>
					</div>
                    {{-- {{ dd($comprobante) }} --}}
					<div class="inside">
                        <div class="row">
                            <div class="col-md-2">
                                {!! Form::label('numero', 'Número:') !!}
                                {!! Form::text('numero', null, ['class'=>'form-control numero','maxlength'=>'6','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('fecha', 'Fecha:') !!}
                                {!! Form::date('fecha', Carbon\Carbon::now(), ['class'=>'form-control']) !!}
                            </div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('motivo', 'Motivo Retiro:') !!}
                                {!! Form::select('motivo',[1=>'EXPORTACIÓN', 2=>'MUESTREO'],null,['class'=>'custom-select']) !!}
                            </div>
                            <div class="col-md-2">
                                {!! Form::label('contenedor', 'Contenedor:') !!}
                                {!! Form::text('contenedor', null, ['class'=>'form-control mayuscula','maxlength'=>'15','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-2">
                                {!! Form::label('precinto', 'Precinto:') !!}
                                {!! Form::text('precinto', null, ['class'=>'form-control mayuscula','maxlength'=>'30','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('supervisor_id', 'Supervisor:') !!}
                                {!! Form::select('supervisor_id',$supervisores,null,['class'=>'custom-select','placeholder'=>'']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                {!! Form::label('transportista_id', 'Transportista:') !!}
                                {!! Form::select('transportista_id',$transportistas,null,['class'=>'custom-select activo','placeholder'=>'']) !!}
                            </div>
                            <div class="col-md-2">
                                {!! Form::label('placas', 'Placas:') !!}
                                {!! Form::text('placas', null, ['class'=>'form-control mayuscula','maxlength'=>'50','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-2">
                                {!! Form::label('grt', 'Guía Transportista:') !!}
                                {!! Form::text('grt', null, ['class'=>'form-control mayuscula','maxlength'=>'15','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-2">
                                {!! Form::label('gr', 'Guía Remitente:') !!}
                                {!! Form::text('gr', null, ['class'=>'form-control mayuscula','maxlength'=>'15','autocomplete'=>'off']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                {!! Form::label('observaciones', 'Observaciones:') !!}
                                {!! Form::textarea('observaciones',null,['class'=>'form-control mayuscula', 'rows'=>'3', 'id'=>'editor']) !!}
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
        $('#numero').blur(function(){
            this.value = this.value.replace(/^(0+)/g,'');
        });
        $('#transportista_id').select2({
			placeholder:"Seleccione Transportista"
		});

    });

</script>
@endsection
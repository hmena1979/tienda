{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Materias Primas')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.materiaprimas.index') }}"><i class="fas fa-fish"></i> Materias Primas</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					{!! Form::open(['route'=>'admin.materiaprimas.store']) !!}
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-fish"></i> Materias Primas</h2>
                            <ul>
								<li>{!! Form::submit('Guardar', ['class'=>'btn btn-convertir mt-2', 'id'=>'guardar']) !!}</li>
                            </ul>
                        </div>
					<div class="inside">
						{{-- {!! Form::open(['url'=>'/admin/categoria/add/'.$module]) !!} --}}
						<div class="row">
							<div class="col-md-2 form-group">
								{!! Form::hidden('empresa_id', session('empresa')) !!}
								{!! Form::hidden('periodo', session('periodo')) !!}
								{!! Form::label('lote', 'Lote:') !!}
								{!! Form::text('lote', null, ['class'=>'form-control mayuscula','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-2 form-group">
								{!! Form::label('remitente_guia', 'Guía Remitente:') !!}
								{!! Form::text('remitente_guia', null, ['class'=>'form-control mayuscula','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-2 form-group">
								{!! Form::label('transportista_guia', 'Guía Transportista:') !!}
								{!! Form::text('transportista_guia', null, ['class'=>'form-control mayuscula','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-2 form-group">
								{!! Form::label('ticket_balanza', 'Ticket Balanza:') !!}
								{!! Form::text('ticket_balanza', null, ['class'=>'form-control mayuscula','autocomplete'=>'off']) !!}
							</div>
							@can('admin.materiaprimas.comprobante')
							<div class="col-md-2 form-group">
								{!! Form::label('certprocedencia', 'Certif. Procedencia:') !!}
								{!! Form::text('certprocedencia', null, ['class'=>'form-control mayuscula','autocomplete'=>'off']) !!}
							</div>
							@endcan
						</div>
						<div class="row">
							<div class="col-md-4 form-group">
                                {!! Form::label('cliente_id', 'Proveedor:') !!}
								{!! Form::select('cliente_id',[],null,['class'=>'custom-select activo','id'=>'cliente_id','placeholder'=>'']) !!}
                            </div>
							@can('admin.materiaprimas.comprobante')
							<div class="col-md-2 form-group">
                                {!! Form::label('rcompra_id', 'Comprobante de Pago:') !!}
								{!! Form::select('rcompra_id',[],null,['class'=>'custom-select activo','placeholder'=>'']) !!}
                            </div>
							@endcan
							<div class="col-md-3 form-group">
                                {!! Form::label('embarcacion_id', 'Embarcación:') !!}
								{!! Form::select('embarcacion_id',$embarcacion,null,['class'=>'custom-select activo','placeholder'=>'']) !!}
                            </div>
							<div class="col-md-3 form-group">
                                {!! Form::label('muelle_id', 'Muelle:') !!}
								{!! Form::select('muelle_id',$muelles,null,['class'=>'custom-select activo','placeholder'=>'']) !!}
                            </div>
						</div>
						<div class="row">
							<div class="col-md-4 form-group">
                                {!! Form::label('empacopiadora_id', 'Empresa Acopiadora:') !!}
								{!! Form::select('empacopiadora_id',$empAcopiadora,null,['class'=>'custom-select','placeholder'=>'Seleccione Empresa Acopiadora']) !!}
							</div>
							<div class="col-md-4 form-group">
                                {!! Form::label('acopiador_id', 'Acopiador:') !!}
								{!! Form::select('acopiador_id',[],null,['class'=>'custom-select','placeholder'=>'Seleccione Acopiador']) !!}
							</div>
						</div>
						<div class="row">
							<div class="col-md-4 form-group">
                                {!! Form::label('transportista_id', 'Trasportista:') !!}
								{!! Form::select('transportista_id',$transportistas,null,['class'=>'custom-select','placeholder'=>'Seleccione Transportista']) !!}
							</div>
							<div class="col-md-4 form-group">
                                {!! Form::label('chofer_id', 'Chofer:') !!}
								{!! Form::select('chofer_id',[],null,['class'=>'custom-select','placeholder'=>'Seleccione Chofer']) !!}
							</div>
							<div class="col-md-4 form-group">
                                {!! Form::label('camara_id', 'Cámara:') !!}
								{!! Form::select('camara_id',[],null,['class'=>'custom-select','placeholder'=>'Seleccione Cámara']) !!}
							</div>
						</div>
						<div class="row">
							<div class="col-md-2 form-group">
                                {!! Form::label('fpartida', 'Fecha Partida:') !!}
                                {!! Form::date('fpartida', null, ['class'=>'form-control']) !!}
                            </div>
							<div class="col-md-2 form-group">
                                {!! Form::label('fllegada', 'Fecha Llegada:') !!}
                                {!! Form::date('fllegada', null, ['class'=>'form-control']) !!}
                            </div>
							<div class="col-md-2 form-group">
                                {!! Form::label('ingplanta', 'Ingreso a Planta:') !!}
                                {!! Form::date('ingplanta', null, ['class'=>'form-control']) !!}
                            </div>
							<div class="col-md-2 form-group">
                                {!! Form::label('hinicio', 'Hora Inicio:') !!}
                                {!! Form::time('hinicio', null, ['class'=>'form-control']) !!}
                            </div>
							<div class="col-md-2 form-group">
                                {!! Form::label('hfin', 'Hora Fin:') !!}
                                {!! Form::time('hfin', null, ['class'=>'form-control']) !!}
                            </div>
						</div>
						<div class="row">
							<div class="col-md-2 form-group">
								{!! Form::label('cajas', 'Cajas Declaradas:') !!}
								{!! Form::text('cajas', null, ['class'=>'form-control numero','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-2 form-group">
								{!! Form::label('pplanta', 'Peso Planta:') !!}
								{!! Form::text('pplanta', null, ['class'=>'form-control decimal','autocomplete'=>'off', 'disabled']) !!}
							</div>
							<div class="col-md-2 form-group">
								{!! Form::label('batch', 'Batch:') !!}
								{!! Form::text('batch', null, ['class'=>'form-control decimal','autocomplete'=>'off', 'disabled']) !!}
							</div>
							@can('admin.materiaprimas.precio')
							<div class="col-md-2 form-group">
								{!! Form::label('precio', 'Precio:') !!}
								{!! Form::text('precio', null, ['class'=>'form-control decimal','autocomplete'=>'off']) !!}
							</div>
							@endcan
						</div>
						<div class="row">
							<div class="col-md-2 form-group">
								{!! Form::label('lugar', 'Lugar:') !!}
								{!! Form::text('lugar', 'PAITA', ['class'=>'form-control mayuscula','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-4 form-group">
                                {!! Form::label('producto_id', 'Tipo Producto:') !!}
								{!! Form::select('producto_id',$producto,null,['class'=>'custom-select','placeholder'=>'Seleccione Producto']) !!}
							</div>
							<div class="col-md-2 form-group">
								{!! Form::label('destare', 'Destare KG:') !!}
								{!! Form::text('destare', null, ['class'=>'form-control decimal','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-4 form-group">
								{!! Form::label('observaciones', 'Observaciones:') !!}
								{!! Form::text('observaciones', null, ['class'=>'form-control mayuscula','autocomplete'=>'off']) !!}
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
	$('#guardar').click(function(){
		$('.activo').prop('disabled',false);
	});

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

		$('#cliente_id').on('select2:close',function(){
			var lote = $('#lote').val();
            var proveedor = this.value;
            $.get(url_global+"/admin/rcompras/"+proveedor+"/"+lote+"/materiaprima/",function(response){
                $('#rcompra_id').empty();
                for(i=0;i<response.length;i++){
                    $('#rcompra_id').append("<option value='"+response[i].id+"'>"
                        + response[i].serie + '-' + response[i].numero
                        + "</option>");
                }
                $('#rcompra_id').val(null);
                $('#rcompra_id').select2({
                    placeholder:"Seleccione Comprobante"
                });
            });
        });


		$('#embarcacion_id').select2({
			placeholder:"Seleccione Embarcación"
		});

		$('#muelle_id').select2({
			placeholder:"Seleccione Muelle"
		});

		$('#transportista_id').select2({
			placeholder:"Seleccione Transportista"
		});

		$('#rcompra_id').select2({
			placeholder:"Seleccione Comprobante"
		});

		$('#transportista_id').on('select2:close',function(){
            var transportista = this.value;
            $.get(url_global+"/admin/transportistas/"+transportista+"/listdetalle/",function(response){
                $('#chofer_id').empty();
                for(i=0;i<response.length;i++){
                    $('#chofer_id').append("<option value='"+response[i].id+"'>"
                        + response[i].nombre + ' | ' + response[i].licencia
                        + "</option>");
                }
                $('#chofer_id').val(null);
                $('#chofer_id').select2({
                    placeholder:"Seleccione Chofer"
                });
            });

            $.get(url_global+"/admin/transportistas/"+transportista+"/listdetallecamara/",function(response){
                $('#camara_id').empty();
                for(i=0;i<response.length;i++){
                    $('#camara_id').append("<option value='"+response[i].id+"'>"
                        + response[i].marca + ' ' + response[i].placa
                        + "</option>");
                }
                $('#camara_id').val(null);
                $('#camara_id').select2({
                    placeholder:"Seleccione Cámara"
                });
            });
        });

		$('#empacopiadora_id').select2({
			placeholder:"Seleccione Empresa Acopiadora"
		});

		$('#empacopiadora_id').on('select2:close',function(){
            var empacopiadora = this.value;
            $.get(url_global+"/admin/empacopiadoras/"+empacopiadora+"/listdetalle/",function(response){
                $('#acopiador_id').empty();
                for(i=0;i<response.length;i++){
                    $('#acopiador_id').append("<option value='"+response[i].id+"'>"
                        + response[i].nombre
                        + "</option>");
                }
                $('#acopiador_id').val(null);
                $('#acopiador_id').select2({
                    placeholder:"Seleccione Acopiador"
                });
            });
        });

		$('#producto_id').select2({
			placeholder:"Seleccione Producto"
		});

	});
</script>
@endsection
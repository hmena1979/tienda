{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Embarques')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.embarques.index') }}"><i class="fab fa-docker"></i> Embarques</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					{!! Form::model($embarque, ['route'=>['admin.embarques.update', $embarque], 'method'=>'put']) !!}
					<div class="headercontent">
						<h2 class="title"><i class="fab fa-docker"></i> Embarques</h2>
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
								<div class="row no-gutters">
									<div class="col-md-9">
										{!! Form::text('lote', null, ['class'=>'form-control mayuscula','maxlength'=>'15','autocomplete'=>'off']) !!}
									</div>
									<div class="col-md-3">
										<button class="btn btn-block btn-convertir" type="button" id="actualiza" title="Buscar"><i class="fas fa-search"></i></button>
									</div>
								</div>
                            </div>
							<div class="col-md-2 form-group">
                                {!! Form::label('moneda', 'Moneda:') !!}
								{!! Form::select('moneda',$moneda,'USD',['class'=>'custom-select activo']) !!}
                            </div>
							<div class="col-md-4 form-group">
                                {!! Form::label('cliente_id', 'Cliente:') !!}
								{!! Form::select('cliente_id',$clientes,null,['class'=>'custom-select activo','id'=>'cliente_id','placeholder'=>'']) !!}
                            </div>
							<div class="col-md-2 form-group">
                                {!! Form::label('country_id', 'Destino:') !!}
								{!! Form::select('country_id',$countries,null,['class'=>'custom-select activo','placeholder'=>'Seleccione Destino']) !!}
                            </div>
							<div class="col-md-2 form-group">
								{!! Form::label('booking', 'Reserva / Booking:') !!}
								{!! Form::text('booking', null, ['class'=>'form-control mayuscula','maxlength'=>'15','autocomplete'=>'off']) !!}
							</div>
						</div>
						<div class="row">
							<div class="col-md-3 form-group">
                                {!! Form::label('transportista_id', 'Transportista:') !!}
								{!! Form::select('transportista_id',$transportistas,null,['class'=>'custom-select activo','placeholder'=>'Seleccione Transportista']) !!}
                            </div>
							<div class="col-md-2 form-group">
								{!! Form::label('grt', 'Guía Transportista:') !!}
								{!! Form::text('grt', null, ['class'=>'form-control mayuscula','maxlength'=>'15','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-2 form-group">
								{!! Form::label('grr', 'Guía Remitente:') !!}
								{!! Form::text('grr', null, ['class'=>'form-control mayuscula','maxlength'=>'15','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-5">
								<div class="row">
									<div class="col-md-4 form-group">
										{!! Form::label('precinto_hl', 'Precinto HL:') !!}
										{!! Form::text('precinto_hl', null, ['class'=>'form-control mayuscula','maxlength'=>'30','autocomplete'=>'off']) !!}
									</div>
									<div class="col-md-4 form-group">
										{!! Form::label('factura_numero', 'N° Factura:') !!}
										{!! Form::text('factura_numero', null, ['class'=>'form-control mayuscula','maxlength'=>'15','autocomplete'=>'off']) !!}
									</div>
									<div class="col-md-4 form-group">
										{!! Form::label('factura_fecha', 'Fecha Factura:') !!}
										{!! Form::date('factura_fecha', null, ['class'=>'form-control']) !!}
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2 form-group">
								{!! Form::label('valor_venta', 'Valor Venta:') !!}
								{!! Form::text('valor_venta', null, ['class'=>'form-control decimal fob','maxlength'=>'12','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-2 form-group">
								{!! Form::label('otros_gastos', 'Otros Gastos:') !!}
								{!! Form::text('otros_gastos', null, ['class'=>'form-control decimal fob','maxlength'=>'12','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-2 form-group">
								{!! Form::label('valor_fob', 'Valor FOB:') !!}
								{!! Form::text('valor_fob', null, ['class'=>'form-control decimal','maxlength'=>'12','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-2 form-group">
								{!! Form::label('atd_paking', 'ATD Packing:') !!}
								{!! Form::date('atd_paking', null, ['class'=>'form-control']) !!}
							</div>
							<div class="col-md-2 form-group">
								{!! Form::label('stuffing_container', 'Stuffing Container:') !!}
								{!! Form::date('stuffing_container', null, ['class'=>'form-control']) !!}
							</div>
							<div class="col-md-2 form-group">
								{!! Form::label('nave', 'Nave:') !!}
								{!! Form::text('nave', null, ['class'=>'form-control mayuscula','maxlength'=>'30','autocomplete'=>'off']) !!}
							</div>
						</div>
						<div class="row">
							<div class="col-md-2 form-group">
								{!! Form::label('viaje', 'Viaje:') !!}
								{!! Form::text('viaje', null, ['class'=>'form-control mayuscula','maxlength'=>'30','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-2 form-group">
								{!! Form::label('etd_pol', 'ETD POL:') !!}
								{!! Form::date('etd_pol', null, ['class'=>'form-control']) !!}
							</div>
							<div class="col-md-2 form-group">
								{!! Form::label('atd_pol', 'ATD POL:') !!}
								{!! Form::date('atd_pol', null, ['class'=>'form-control']) !!}
							</div>
							<div class="col-md-2 form-group">
								{!! Form::label('pol', 'POL:') !!}
								{!! Form::text('pol', null, ['class'=>'form-control mayuscula','maxlength'=>'20','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-2 form-group">
								{!! Form::label('eta_pod', 'ETA POD:') !!}
								{!! Form::date('eta_pod', null, ['class'=>'form-control']) !!}
							</div>
							<div class="col-md-2 form-group">
								{!! Form::label('ata_pod', 'ATA POD:') !!}
								{!! Form::date('ata_pod', null, ['class'=>'form-control']) !!}
							</div>
						</div>
						<div class="row">
							<div class="col-md-2 form-group">
								{!! Form::label('pod', 'POD:') !!}
								{!! Form::text('pod', null, ['class'=>'form-control mayuscula','maxlength'=>'30','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-2 form-group">
								{!! Form::label('naviera', 'Naviera:') !!}
								{!! Form::text('naviera', null, ['class'=>'form-control mayuscula','maxlength'=>'30','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-2 form-group">
								{!! Form::label('contenedor', 'Contenedor:') !!}
								{!! Form::text('contenedor', null, ['class'=>'form-control mayuscula','maxlength'=>'15','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-3 form-group">
										{!! Form::label('peso_neto', 'Peso Neto(KG):') !!}
										{!! Form::text('peso_neto', null, ['class'=>'form-control decimal','maxlength'=>'12','autocomplete'=>'off']) !!}
									</div>
									<div class="col-md-3 form-group">
										{!! Form::label('peso_bruto', 'Peso Bruto(KG):') !!}
										{!! Form::text('peso_bruto', null, ['class'=>'form-control decimal peso','maxlength'=>'12','autocomplete'=>'off']) !!}
									</div>
									<div class="col-md-3 form-group">
										{!! Form::label('tara', 'Tara(KG):') !!}
										{!! Form::text('tara', null, ['class'=>'form-control decimal peso','maxlength'=>'12','autocomplete'=>'off']) !!}
									</div>
									<div class="col-md-3 form-group">
										{!! Form::label('vgm', 'VGM(KG):') !!}
										{!! Form::text('vgm', null, ['class'=>'form-control decimal','maxlength'=>'12','autocomplete'=>'off']) !!}
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2 form-group">
								{!! Form::label('sacos', 'Sacos/Cajas:') !!}
								{!! Form::text('sacos', null, ['class'=>'form-control decimal','maxlength'=>'10','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-2 form-group">
								{!! Form::label('bl', 'BL:') !!}
								{!! Form::text('bl', null, ['class'=>'form-control mayuscula','maxlength'=>'20','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-3 form-group">
								{!! Form::label('precinto_linea', 'Precinto Linea:') !!}
								{!! Form::text('precinto_linea', null, ['class'=>'form-control mayuscula','maxlength'=>'50','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-2 form-group">
								{!! Form::label('precinto_ag', 'Precinto AG:') !!}
								{!! Form::text('precinto_ag', null, ['class'=>'form-control mayuscula','maxlength'=>'30','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-3 form-group">
								{!! Form::label('producto', 'Producto:') !!}
								{!! Form::text('producto', null, ['class'=>'form-control mayuscula','maxlength'=>'250','autocomplete'=>'off']) !!}
							</div>
						</div>
						<div class="row">
							<div class="col-md-2 form-group">
                                {!! Form::label('stuffing_id', 'Stuffing Place:') !!}
								{!! Form::select('stuffing_id',$stuffing,null,['class'=>'custom-select activo','placeholder'=>'Seleccione Stuffing Place']) !!}
                            </div>
							<div class="col-md-2 form-group">
                                {!! Form::label('ffw_id', 'FFW:') !!}
								{!! Form::select('ffw_id',$ffw,null,['class'=>'custom-select activo','placeholder'=>'Seleccione FFW']) !!}
                            </div>
							<div class="col-md-2 form-group">
                                {!! Form::label('agenciaaduana_id', 'Agencia Aduana:') !!}
								{!! Form::select('agenciaaduana_id',$agaduana,null,['class'=>'custom-select activo','placeholder'=>'Seleccione Agencia Aduana']) !!}
                            </div>
							<div class="col-md-2 form-group">
                                {!! Form::label('release_id', 'Release:') !!}
								{!! Form::select('release_id',$release,null,['class'=>'custom-select activo','placeholder'=>'Seleccione Release']) !!}
                            </div>
							<div class="col-md-4">
								<div class="row">
									<div class="col-md-4 form-group">
										{!! Form::label('pago_flete', 'Pago Flete:') !!}
										{!! Form::select('pago_flete',[1=>'SI',2=>'NO'],2,['class'=>'custom-select activo']) !!}
									</div>
									<div class="col-md-4 form-group">
										{!! Form::label('pago_vb', 'Pago VB:') !!}
										{!! Form::select('pago_vb',[1=>'SI',2=>'NO'],2,['class'=>'custom-select activo']) !!}
									</div>
									<div class="col-md-4 form-group">
										{!! Form::label('vbto', 'VB TO:') !!}
										{!! Form::select('vbto',[1=>'SI',2=>'NO'],2,['class'=>'custom-select activo']) !!}
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3 form-group">
								{!! Form::label('dam', 'DAM:') !!}
								{!! Form::text('dam', null, ['class'=>'form-control mayuscula','maxlength'=>'20','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-2 form-group">
								{!! Form::label('contabilidad', 'Contabilidad:') !!}
								{!! Form::select('contabilidad',[1=>'ENTREGADO',2=>'PENDIENTE'],2,['class'=>'custom-select activo']) !!}
							</div>
							<div class="col-md-2 form-group">
								{!! Form::label('awb_dhl', 'AWB DHL:') !!}
								{!! Form::text('awb_dhl', null, ['class'=>'form-control mayuscula','maxlength'=>'20','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-5">
								<div class="row">
									<div class="col-md-4 form-group">
										{!! Form::label('pi2_id', 'PI2:') !!}
										{!! Form::select('pi2_id',$pi2,1,['class'=>'custom-select activo']) !!}
									</div>
									<div class="col-md-4 form-group">
										{!! Form::label('py_id', 'PY:') !!}
										{!! Form::select('py_id',$py,1,['class'=>'custom-select activo']) !!}
									</div>
									<div class="col-md-4 form-group">
										{!! Form::label('payt_id', 'PAY T:') !!}
										{!! Form::select('payt_id',$payt,1,['class'=>'custom-select activo']) !!}
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2 form-group">
								{!! Form::label('adv', 'ADV:') !!}
								{!! Form::text('adv', null, ['class'=>'form-control decimal','maxlength'=>'12','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-2 form-group">
								{!! Form::label('balance', 'BALANCE:') !!}
								{!! Form::text('balance', null, ['class'=>'form-control decimal','maxlength'=>'12','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-2 form-group">
								{!! Form::label('thirdpy', 'THIRD PY:') !!}
								{!! Form::text('thirdpy', null, ['class'=>'form-control decimal','maxlength'=>'12','autocomplete'=>'off']) !!}
							</div>
						</div>
						<div class="row">
                            <div class="col-md-12 form-group">
                                {!! Form::label('observaciones', 'Observaciones:') !!}
                                {!! Form::textarea('observaciones',null,['class'=>'form-control mayuscula', 'rows'=>'3']) !!}
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

		$('#actualiza').click(function(){
			if ($('#lote').val()) {
				$.get(url_global+"/admin/embarques/"+$('#lote').val()+"/valores/",function(response){
					$('#transportista_id').val(response.transportista_id);
					$('#grt').val(response.grt);
					$('#grr').val(response.grr);
					$('#precinto_hl').val(response.precinto_hl);
					$('#atd_paking').val(response.atd_paking);
					$('#contenedor').val(response.contenedor);
					$('#peso_neto').val(response.peso_neto);
					$('#sacos').val(response.sacos);
					$('#precinto_linea').val(response.precinto_linea);
					$('#precinto_ag').val(response.precinto_ag);
					$('#producto').val(response.producto);
				});
			}
		});

		$('.peso').blur(function(){
			const pesoBruto = Number(NaNToCero($('#peso_bruto').val()));
			const tara = Number(NaNToCero($('#tara').val()));
			$('#vgm').val(pesoBruto + tara);
		});

		$('.fob').blur(function(){
			const valorVenta = Number(NaNToCero($('#valor_venta').val()));
			const otrosGastos = Number(NaNToCero($('#otros_gastos').val()));
			$('#valor_fob').val(valorVenta - otrosGastos);
		});
    });
</script>
@endsection
{{-- @extends('adminlte::page') --}}
@extends('admin.master')

@section('title','Productos | Servicios')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.productos.index') }}"><i class="fas fa-window-restore"></i> Productos | Servicios</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		{!! Form::model($producto,['route'=>['admin.productos.update',$producto],'method'=>'put', 'files' => 'true']) !!}
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-window-restore"></i> Productos | Servicios</h2>
						<ul>
							{!! Form::submit('Guardar', ['class'=>'btn btn-convertir mt-2','id'=>'guardar']) !!}
						</ul>
					</div>
					<div class="inside">
						{{-- {!! Form::open(['url'=>'/admin/categoria/add/'.$module]) !!} --}}
						<div class="row">
							<div class="col-md-2 form-group">
                                {!! Form::label('grupo', 'Grupo:') !!}
								{!! Form::select('grupo',[1=>'PRODUCTOS',2=>'SERVICIOS'],null,['class'=>'custom-select','disabled']) !!}
							</div>
							<div class="col-md-3 form-group">
                                {!! Form::label('tipoproducto_id', 'Tipo:') !!}
								{!! Form::select('tipoproducto_id',$tipoproductos,null,['class'=>'custom-select','placeholder'=>'Seleccione Tipo']) !!}
							</div>
							<div class="col-md-5 form-group">
								{!! Form::label('nombre', 'Nombre:') !!}
								{!! Form::text('nombre', null, ['class'=>'form-control mayuscula','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-2 form-group">
								{!! Form::label('umedida_id', 'Unidad Medida:') !!}
								{!! Form::select('umedida_id',$umedidas,null,['class'=>'custom-select','placeholder'=>'Seleccione Unidad de Medida']) !!}
							</div>
						</div>
						<div class="row">
							<div class="col-md-3 form-group">
								{!! Form::label('afectacion_id', 'Afectación:') !!}
								{!! Form::select('afectacion_id',$afectaciones,null,['class'=>'custom-select']) !!}
							</div>
							<div class="col-md-1 form-group producto">
								{!! Form::label('icbper', 'ICBPER:') !!}
								{!! Form::select('icbper',[1=>'SI',2=>'NO'],null,['class'=>'custom-select','title'=>'Controla Vencimiento y Lote']) !!}
							</div>
							<div class="col-md-5 producto">
								<div class="row">
									<div class="col-md-3 form-group producto">
										{!! Form::label('lotevencimiento', 'Vence:',['title'=>'Controla Vencimiento y Lote']) !!}
										{!! Form::select('lotevencimiento',[1=>'SI',2=>'NO'],null,['class'=>'custom-select','title'=>'Controla Vencimiento y Lote']) !!}
									</div>
									<div class="col-md-3 form-group producto">
										{!! Form::label('ctrlstock', 'Crtl.Stock:',['title'=>'Controla Stock']) !!}
										{!! Form::select('ctrlstock',[1=>'SI',2=>'NO'],null,['class'=>'custom-select','title'=>'Controla Stock']) !!}
									</div>
									<div class="col-md-3 form-group producto">
										{!! Form::label('stockmin', 'Stock Mínimo:') !!}
										{!! Form::text('stockmin', null, ['class'=>'form-control decimal','autocomplete'=>'off']) !!}
									</div>
									<div class="col-md-3 form-group producto">
										{!! Form::label('stock', 'Stock:') !!}
										{!! Form::text('stock', null, ['class'=>'form-control decimal','autocomplete'=>'off','disabled']) !!}
									</div>
								</div>
							</div>
							<div class="col-md-2">
								{!! Form::label('codigobarra', 'Código Barra|Sunat:') !!}
								{!! Form::text('codigobarra', null, ['class'=>'form-control mayuscula','autocomplete'=>'off']) !!}
							</div>
						</div>
						
					</div>				
				</div>
			</div>
		</div>
		<div class="row mtop16">
			<div class="col-md-10 d-flex">
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-window-restore"></i> Detalle de Producto</h2>
					</div>
					<div class="inside">
						<div class="row">
							<div class="col-md-12 form-group">
								{!! Form::label('detallada', 'Descripción Detallada:') !!}
								{!! Form::textarea('detallada',null,['class'=>'form-control mayuscula', 'id'=>'detallada']) !!}
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-2 d-flex">
				<div class="panelprin shadow">
					<div class="inside">
                        <div class="row justify-content-center">
                            @if ($producto->imagen)
							<a href="{{ url('products/'.$producto->imagen) }}" data-fancybox="gallery">
								<img id='imgimagen' class="img img-fluid" src="{{ url('products/'.$producto->imagen) }}" alt="">
							</a>
                            @else
							{{-- <i class="fas fa-window-restore"></i> --}}
                            <img id='imgimagen' class="img img-fluid" src="{{ url('/static/images/sinproducto.jpg') }}" alt="">
                            @endif
                        </div>
						<div class="row">
							<div class="col-md-4 oculto">
                                {!! Form::file('imagen', ['id' => 'imagen', 'accept'=>'image/*']) !!}
                            </div>
						</div>
                        <div class="row mt-3 text-center">
                            <div class="col-md-12">
                                <a class="btn btn-convertir" href="#" id="btnimagen">Cambiar Imagen</a>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
		</div>
		@can('admin.productos.price')
		<div class="row mtop16">
			<div class="col-md-12">
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-window-restore"></i> Precio de Mercado</h2>
					</div>
					<div class="inside">
						<div class="row">
							<div class="col-md-6 d-flex">
								<div class="card flex-fill mt-4">
									<div class="card-header colorprin negrita">
										Últimas Compras
									</div>
									<div class="card-body cardbobyreducido">
										<table class="table table-responsive-md table-hover table-bordered table-estrecha table-sb">
											<thead>
												<tr>
													<th>Fecha</th>
													<th>Proveedor</th>
													<th class="text-center">Cantidad</th>
													<th class="text-center">Precio S/</th>
												</tr>
											</thead>
											<tbody>
												@if ($historial == 1)
												@foreach ($compras as $compra)
												<tr>
													<td>{{$compra->fecha}}</td>
													<td>{{$compra->cliente->razsoc}}</td>
													<td class="text-center">{{ number_format($compra->cantidad,2)}}</td>
													<td class="text-center">
														@if ($compra->moneda == 'PEN')
														{{ number_format(round($compra->precio,2),2)}}
														@else
														{{ number_format(round($compra->precio*$compra->tc,2),2)}}															
														@endif
													</td>
												</tr>													
												@endforeach
												@else
												<tr>
													<td>{!! htmlspecialchars_decode("&nbsp;") !!}</td>
													<td>{!! htmlspecialchars_decode("&nbsp;") !!}</td>
													<td>{!! htmlspecialchars_decode("&nbsp;") !!}</td>
													<td>{!! htmlspecialchars_decode("&nbsp;") !!}</td>
												</tr>
												@endif
											</tbody>

										</table>
										{{-- {{ dd($compras)}} --}}
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-12 text-center colorprin negrita">
										SOLES
									</div>
								</div>
								<div class="row">
									<div class="col-md-4 d-flex">
										<div class="card">
											<div class="card-header colorprin negrita">
												Precio Promedio
											</div>
											<div class="card-body cardbobyreducido">
												<div class="row">
													<div class="col-md-12 form-group">
														{!! Form::label('precompra', 'Sin IGV:') !!}
														{!! Form::text('precompra', null, ['class'=>'form-control decimal','autocomplete'=>'off','disabled']) !!}
													</div>
												</div>
												<div class="row">
													<div class="col-md-12 form-group">
														{!! Form::label('precompraigv', 'Con IGV:') !!}
														{!! Form::text('precompraigv', null, ['class'=>'form-control decimal','autocomplete'=>'off','disabled']) !!}
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-4 d-flex">
										<div class="card">
											<div class="card-header colorprin negrita">
												Utilidad
											</div>
											<div class="card-body cardbobyreducido">
												<div class="row">
													<div class="col-md-12 form-group">
														{!! Form::label('utilidad_pen', 'Monto:') !!}
														{!! Form::text('utilidad_pen', null, ['class'=>'form-control decimal','autocomplete'=>'off']) !!}
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-4 d-flex">
										<div class="card">
											<div class="card-header colorprin negrita">
												Precio Venta
											</div>
											<div class="card-body cardbobyreducido">
												<div class="row">
													<div class="col-md-12 form-group">
														{!! Form::label('preventa_pen', 'Regular:') !!}
														{!! Form::text('preventa_pen', null, ['class'=>'form-control decimal','autocomplete'=>'off']) !!}
													</div>
												</div>
												<div class="row">
													<div class="col-md-12 form-group">
														{!! Form::label('preventamin_pen', 'Mínimo:') !!}
														{!! Form::text('preventamin_pen', null, ['class'=>'form-control decimal','autocomplete'=>'off']) !!}
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-12 text-center colorprin negrita">
									DÓLARES <span class="@if($tc==0) oculto @endif"> - Tipo Cambio</span> <span  class="@if($tc==0) oculto @endif" id="tc">{{ $tc }}</span>
								</div>
								<div class="row">
									<div class="col-md-4 d-flex">
										<div class="card">
											<div class="card-header colorprin negrita">
												Precio Promedio
											</div>
											<div class="card-body cardbobyreducido">
												<div class="row">
													<div class="col-md-12 form-group">
														{!! Form::label('precomprausd', 'Sin IGV:') !!}
														{!! Form::text('precomprausd', null, ['class'=>'form-control decimal','autocomplete'=>'off','disabled']) !!}
													</div>
												</div>
												<div class="row">
													<div class="col-md-12 form-group">
														{!! Form::label('precompraigvusd', 'Con IGV:') !!}
														{!! Form::text('precompraigvusd', null, ['class'=>'form-control decimal','autocomplete'=>'off','disabled']) !!}
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-4 d-flex">
										<div class="card">
											<div class="card-header colorprin negrita">
												Utilidad
											</div>
											<div class="card-body cardbobyreducido">
												<div class="row">
													<div class="col-md-12 form-group">
														{!! Form::label('utilidad_usd', 'Monto:') !!}
														{!! Form::text('utilidad_usd', null, ['class'=>'form-control decimal','autocomplete'=>'off']) !!}
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-4 d-flex">
										<div class="card">
											<div class="card-header colorprin negrita">
												Precio Venta
											</div>
											<div class="card-body cardbobyreducido">
												<div class="row">
													<div class="col-md-12 form-group">
														{!! Form::label('preventa_usd', 'Regular:') !!}
														{!! Form::text('preventa_usd', null, ['class'=>'form-control decimal','autocomplete'=>'off']) !!}
													</div>
												</div>
												<div class="row">
													<div class="col-md-12 form-group">
														{!! Form::label('preventamin_usd', 'Mínimo:') !!}
														{!! Form::text('preventamin_usd', null, ['class'=>'form-control decimal','autocomplete'=>'off']) !!}
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
		@endcan
		{!! Form::close() !!}
	</div>
@endsection
@section('style')
    <link href="{{ asset('css/jquery.fancybox.min.css') }}" rel="stylesheet">
@stop
@section('script')
<script src="{{ asset('/static/js/ckeditor5.js') }}"></script>
<script src="{{ asset('/js/jquery.fancybox.min.js') }}"></script>
<script>
	ClassicEditor
        .create( document.querySelector( '#detallada' ) )
        .catch( error => {
            console.error( error );
        } );
</script>
<script>
    $(document).ready(function(){
        $('#btnimagen').click(function(){
            $('#imagen').click();
        });
    });
    document.getElementById('imagen').addEventListener('change',cambiarImagen);

    function cambiarImagen(event){
        var file = event.target.files[0];
        var reader = new FileReader();
        reader.onload = (event) => {
            document.getElementById('imgimagen').setAttribute('src',event.target.result);
        }
        reader.readAsDataURL(file);
    }
</script>
<script>
    // $('.alertmensaje').slideDown();
    $(document).ready(function(){
		if($('#tc').text() == 0){
			$('#precomprausd').val(0.00);
		}else{
			$('#precomprausd').val(Redondea(Number($('#precompra').val())/Number($('#tc').text()),2));
		}
		if($('#grupo').val() == 1){
			$('.producto').show();
		}else{
			$('.producto').hide();
		}

		$('#guardar').click(function(){
			$('#grupo').prop('disabled',false)
		});
		
		if($('#afectacion_id').val() == 10){
			const igv = {{ session('igv') }};
			let precigvsol = Redondea($('#precompra').val() * (1 + (igv/100)),2);
			let precigvdol = Redondea($('#precomprausd').val() * (1 + (igv/100)),2);
			$('#precompraigv').val(precigvsol);
			$('#precompraigvusd').val(precigvdol);
		}else{
			let precigvsol = $('#precompra').val();
			$('#precompraigv').val(precigvsol);
			let precigvdol = $('#precomprausd').val();
			$('#precompraigvusd').val(precigvdol);
		}

		$('#afectacion_id').change(function(){
			if(this.value == 10){
			const igv = {{ session('igv') }};
			let precigvsol = Redondea($('#precompra').val() * (1 + (igv/100)),2);
			let precigvdol = Redondea($('#precomprausd').val() * (1 + (igv/100)),2);
			$('#precompraigv').val(precigvsol);
			$('#precompraigvusd').val(precigvdol);
		}else{
			let precigvsol = $('#precompra').val();
			$('#precompraigv').val(precigvsol);
			let precigvdol = $('#precomprausd').val();
			$('#precompraigvusd').val(precigvdol);
		}
		});

		$('#utilidad_pen').blur(function(){
			const preventapen = Redondea(Number(this.value) + Number($('#precompraigv').val()),2);
			$('#preventa_pen').val(preventapen);
			$('#preventamin_pen').val(preventapen);
		});

		$('#preventa_pen').blur(function(){
			const utilidad_pen = Redondea(Number(this.value) - Number($('#precompraigv').val()),2);
			$('#utilidad_pen').val(utilidad_pen);
			$('#preventamin_pen').val(this.value);
		});

		$('#utilidad_usd').blur(function(){
			const preventausd = Redondea(Number(this.value) + Number($('#precompraigvusd').val()),2);
			$('#preventa_usd').val(preventausd);
			$('#preventamin_usd').val(preventausd);
		});

		$('#preventa_usd').blur(function(){
			if($('#grupo').val() == 1){
				const utilidad_usd = Redondea(Number(this.value) - Number($('#precompraigvusd').val()),2);
				$('#utilidad_usd').val(utilidad_usd);
				$('#preventamin_usd').val(this.value);
			}else{
				$('#utilidad_usd').val(null);
				$('#preventamin_usd').val(this.value);
			}
		});


    });
	
</script>
@endsection
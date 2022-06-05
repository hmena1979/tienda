@extends('admin.master')
@section('title','Saldos Iniciales')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.saldos.index') }}"><i class="fas fa-window-restore"></i> Saldos Iniciales</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					{!! Form::model($saldo,['route'=>['admin.saldos.update',$saldo],'method'=>'put']) !!}
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-money-check-alt"></i> Cuentas</h2>
                            <ul>
								<li>
									{!! Form::submit('Guardar', ['class'=>'btn btn-convertir mt-2']) !!}
								</li>
                            </ul>
                        </div>
					<div class="inside">
						<div class="row">
							<div class="col-md-4 form-group">
                                {!! Form::label('producto_id', 'Producto:') !!}
                                {!! Form::select('producto_id',$productos,null,['class'=>'custom-select','placeholder'=>'']) !!}
                            </div>
							<div class="col-md-2 form-group">
								{!! Form::label('saldo', 'Cantidad:') !!}
								{!! Form::text('saldo', null, ['class'=>'form-control decimal','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-2 form-group">
								{!! Form::label('precio', 'Precio:') !!}
								{!! Form::text('precio', null, ['class'=>'form-control decimal','autocomplete'=>'off']) !!}
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
		$('#producto_id').select2({
            placeholder:"Ingrese 4 dígitos del Nombre del Producto",
            minimumInputLength: 4,
            ajax:{
                url: "{{ route('admin.productos.seleccionadot') }}",
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
	});
</script>
@endsection
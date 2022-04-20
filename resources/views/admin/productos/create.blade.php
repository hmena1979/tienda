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
		<div class="row">
			<div class="col-md-12">
				{!! Form::open(['route'=>'admin.productos.store']) !!}
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-window-restore"></i> Productos | Servicios</h2>
						<ul>
							{!! Form::submit('Guardar', ['class'=>'btn btn-convertir mt-2']) !!}
						</ul>
					</div>
					<div class="inside">
						{{-- {!! Form::open(['url'=>'/admin/categoria/add/'.$module]) !!} --}}
						<div class="row">
							<div class="col-md-2 form-group">
								{!! Form::hidden('empresa_id', session('empresa')) !!}
                        		{!! Form::hidden('sede_id', session('sede')) !!}
                                {!! Form::label('grupo', 'Grupo:') !!}
								{!! Form::select('grupo',[1=>'PRODUCTOS',2=>'SERVICIOS',3=>'MATERIA PRIMA'],'1',['class'=>'custom-select']) !!}
							</div>
							<div class="col-md-3 form-group">
                                {!! Form::label('tipoproducto_id', 'Tipo:') !!}
								{!! Form::select('tipoproducto_id',$tipoproductos,1,['class'=>'custom-select','placeholder'=>'Seleccione Tipo']) !!}
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
								{!! Form::select('afectacion_id',$afectaciones,null,['class'=>'custom-select', 'id'=>'afectacion']) !!}
							</div>
							<div class="col-md-1 form-group producto">
								{!! Form::label('icbper', 'ICBPER:') !!}
								{!! Form::select('icbper',[1=>'SI',2=>'NO'],2,['class'=>'custom-select','title'=>'Controla Vencimiento y Lote']) !!}
							</div>
							<div class="col-md-4">
								<div class="row">
									<div class="col-md-4 form-group producto">
										{!! Form::label('lotevencimiento', 'Vence:',['title'=>'Controla Vencimiento y Lote']) !!}
										{!! Form::select('lotevencimiento',[1=>'SI',2=>'NO'],2,['class'=>'custom-select','title'=>'Controla Vencimiento y Lote']) !!}
									</div>
									<div class="col-md-4 form-group producto">
										{!! Form::label('ctrlstock', 'Crtl.Stock:',['title'=>'Controla Stock']) !!}
										{!! Form::select('ctrlstock',[1=>'SI',2=>'NO'],1,['class'=>'custom-select','title'=>'Controla Stock']) !!}
									</div>
									<div class="col-md-4 form-group producto">
										{!! Form::label('stockmin', 'Stock Mínimo:') !!}
										{!! Form::text('stockmin', 0.00, ['class'=>'form-control decimal','autocomplete'=>'off']) !!}
									</div>
								</div>
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
    // $('.alertmensaje').slideDown();
    $(document).ready(function(){
        // $('#nombre').blur(function(){
        //     this.value = this.value.toUpperCase();
        // });
        $('#grupo').change(function(){
            if(this.value == 1){
                $('#umedida_id').val(null);
                $('#tipoproducto_id').val(null);
				$('#nombre').val(null);
				$('.producto').show();
            }else{
                $('#umedida_id').val('ZZ');
                $('#tipoproducto_id').val(null);
                $('#nombre').val(null);
				$('.producto').hide();
            }
        });

    });
	
</script>
@endsection
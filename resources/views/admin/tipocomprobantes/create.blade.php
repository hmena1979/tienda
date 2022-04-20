{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Tipo Comprobantes')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.tipocomprobantes.index') }}"><i class="fas fa-list-alt"></i> Tipo Comprobantes</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-list-alt"></i> Tipo Comprobantes</h2>
                            <ul>
                            </ul>
                        </div>
					<div class="inside">
						{{-- {!! Form::open(['url'=>'/admin/categoria/add/'.$module]) !!} --}}
						{!! Form::open(['route'=>'admin.tipocomprobantes.store']) !!}
						<div class="row">
							<div class="col-md-1 form-group">
								{!! Form::label('codigo', 'Código:') !!}
								{!! Form::text('codigo', null, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-11 form-group">
								{!! Form::label('nombre', 'Nombre:') !!}
								{!! Form::text('nombre', null, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
						</div>
                        <div class="row">
                            <div class="col-md-2 form-group">
                                {!! Form::label('tipo', 'Tipo:') !!}
                                {!! Form::select('tipo',[1=>'IMPUESTOS',2=>'RETENCIONES',3=>'NINGUNO'],null,['class'=>'custom-select']) !!}
                            </div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('dreferencia', 'Documento Refrencia:') !!}
                                {!! Form::select('dreferencia',[1=>'SI',2=>'NO'],null,['class'=>'custom-select']) !!}
                            </div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('rc', 'Reporta Reg.Compras:') !!}
                                {!! Form::select('rc',[1=>'SI',2=>'NO'],null,['class'=>'custom-select']) !!}
                            </div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('operacion', 'En Reg.Compras:') !!}
								{!! Form::select('operacion',[1=>'SUMA',2=>'RESTA','3'=>'NINGUNO'],null,['class'=>'custom-select']) !!}
							</div>
                        </div>
						{!! Form::submit('Guardar', ['class'=>'btn btn-convertir']) !!}
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
	$('#codigo').blur(function(){
		this.value = this.value.toUpperCase();
	});
	$('#nombre').blur(function(){
		this.value = this.value.toUpperCase();
	});
</script>
@endsection
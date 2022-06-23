{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Lotes')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.lotes.index') }}"><i class="fas fa-barcode"></i> Lotes</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					{!! Form::model($lote, ['route'=>['admin.lotes.update', $lote], 'method'=>'put']) !!}
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-barcode"></i> Lotes</h2>
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
								{!! Form::text('lote', null, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-2 form-group">
                                {!! Form::label('finicial', 'Fecha Inicio:') !!}
                                {!! Form::date('finicial', null, ['class'=>'form-control activo']) !!}
                            </div>
							<div class="col-md-2 form-group">
                                {!! Form::label('ffinal', 'Fecha Término:') !!}
                                {!! Form::date('ffinal', null, ['class'=>'form-control activo']) !!}
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
	$('#codigo').blur(function(){
		this.value = this.value.toUpperCase();
	});
	$('#nombre').blur(function(){
		this.value = this.value.toUpperCase();
	});
</script>
@endsection
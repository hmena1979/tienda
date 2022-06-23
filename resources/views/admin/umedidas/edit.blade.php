{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Unidad de Medida')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.umedidas.index') }}"><i class="fas fa-ruler-combined"></i> Unidad de Medida</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					{!! Form::model($umedida, ['route'=>['admin.umedidas.update', $umedida], 'method'=>'put']) !!}
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-ruler-combined"></i> Unidad de Medida</h2>
						<ul>
							<li>
								{!! Form::submit('Guardar', ['class'=>'btn btn-convertir mt-1']) !!}
							</li>
						</ul>
					</div>
					<div class="inside">
						{{-- {!! Form::open(['url'=>'/admin/categoria/add/'.$module]) !!} --}}
						<div class="row">
							<div class="col-md-2 form-group">
								{!! Form::label('codigo', 'Código:') !!}
								{!! Form::text('codigo', null, ['class'=>'form-control','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-7 form-group">
								{!! Form::label('nombre', 'Nombre:') !!}
								{!! Form::text('nombre', null, ['class'=>'form-control','autocomplete'=>'off']) !!}
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
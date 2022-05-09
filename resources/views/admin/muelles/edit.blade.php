{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Muelles')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.muelles.index') }}"><i class="fab fa-docker"></i> Muelles</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				{!! Form::model($muelle, ['route'=>['admin.muelles.update', $muelle], 'method'=>'put']) !!}
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fab fa-docker"></i> Muelles</h2>
                            <ul>
								<li>
									{!! Form::submit('Guardar', ['class'=>'btn btn-convertir mt-2']) !!}
								</li>
                            </ul>
                        </div>
					<div class="inside">
						{{-- {!! Form::open(['url'=>'/admin/categoria/add/'.$module]) !!} --}}
						<div class="row">
							<div class="col-md-4 form-group">
								{!! Form::label('nombre', 'Nombre:') !!}
								{!! Form::text('nombre', null, ['class'=>'form-control mayuscula','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-3 form-group">
								{!! Form::label('protocolo', 'Protocolo Sanipes:') !!}
								{!! Form::text('protocolo', null, ['class'=>'form-control mayuscula','autocomplete'=>'off']) !!}
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
	$('#codigo').blur(function(){
		this.value = this.value.toUpperCase();
	});
	$('#nombre').blur(function(){
		this.value = this.value.toUpperCase();
	});
</script>
@endsection
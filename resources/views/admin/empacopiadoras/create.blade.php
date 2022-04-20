@extends('admin.master')
@section('title','Empresas Acopiadoras')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.empacopiadoras.index') }}"><i class="fas fa-newspaper"></i> Empresas Acopiadoras</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
                    {!! Form::open(['route'=>'admin.empacopiadoras.store']) !!}
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-newspaper"></i> Empresas Acopiadoras</h2>
                            <ul>
                                {!! Form::submit('Guardar', ['class'=>'btn btn-convertir mt-2']) !!}
                            </ul>
                        </div>
					<div class="inside">
                        {!! Form::hidden('empresa_id', session('empresa')) !!}
						<div class="row">
							<div class="col-md-6 form-group">
								{!! Form::label('nombre', 'Nombre:') !!}
								{!! Form::text('nombre', null, ['class'=>'form-control mayuscula','maxlength'=>'100','autocomplete'=>'off']) !!}
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
{{-- @section('script')
<script>
	$('#codigo').blur(function(){
		this.value = this.value.toUpperCase();
	});
	$('#nombre').blur(function(){
		this.value = this.value.toUpperCase();
	});
</script>
@endsection --}}
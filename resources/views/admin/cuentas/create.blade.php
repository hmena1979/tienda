@extends('admin.master')
@section('title','Cuentas')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.cuentas.index') }}"><i class="fas fa-money-check-alt"></i> Cuentas</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-money-check-alt"></i> Cuentas</h2>
                            <ul>
                            </ul>
                        </div>
					<div class="inside">
						{{-- {!! Form::open(['url'=>'/admin/categoria/add/'.$module]) !!} --}}
						{!! Form::open(['route'=>'admin.cuentas.store']) !!}
                        {!! Form::hidden('empresa_id', session('empresa')) !!}
                        {!! Form::hidden('sede_id',session('sede')) !!}
						<div class="row">
							<div class="col-md-6 form-group">
								{!! Form::label('nombre', 'Nombre:') !!}
								{!! Form::text('nombre', null, ['class'=>'form-control mayuscula','autocomplete'=>'off']) !!}
							</div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('moneda', 'Moneda:') !!}
                                {!! Form::select('moneda',$moneda,1,['class'=>'custom-select activo']) !!}
                            </div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('tipo', 'Tipo:') !!}
                                {!! Form::select('tipo',[1=>'BANCO',2=>'CAJA'],1,['class'=>'custom-select activo']) !!}
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
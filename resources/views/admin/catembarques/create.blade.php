{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Categoria Embarques')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/catembarques') }}"><i class="fas fa-folder-open"></i> Categoría Embarques</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
                    <div class="headercontent">
                        @php($nombres = getEmbarquesArray())

                        <h2 class="title"><i class="fas fa-folder-open"></i> Categoría Embarques: <strong>{{ $nombres[$module] }}</strong></h2>
                            <ul>
                            </ul>
                        </div>
					<div class="inside">
						{{-- {!! Form::open(['url'=>'/admin/categoria/add/'.$module]) !!} --}}
						{!! Form::open(['route'=>'admin.catembarques.store']) !!}
						{!! Form::hidden('modulo', $module) !!}
						<div class="row">                         
							<div class="col-md-7 form-group">
								{!! Form::label('nombre', 'Nombre:') !!}
								{!! Form::text('nombre', null, ['class'=>'form-control mayuscula','autocomplete'=>'off']) !!}
							</div>
						</div>
						{!! Form::submit('Guardar', ['class'=>'btn btn-convertir mtop16']) !!}
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
    
</script>
@endsection
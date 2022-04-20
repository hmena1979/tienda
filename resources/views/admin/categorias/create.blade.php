{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Categorias')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/categorias/'.$module) }}"><i class="fas fa-folder-open"></i> Categorias</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
                    <div class="headercontent">
                        @php($nombres = getModulosArray())

                        <h2 class="title"><i class="fas fa-folder-open"></i> Categorias: <strong>{{ $nombres[$module] }}</strong></h2>
                            <ul>
                            </ul>
                        </div>
					<div class="inside">
						{{-- {!! Form::open(['url'=>'/admin/categoria/add/'.$module]) !!} --}}
						{!! Form::open(['route'=>'admin.categorias.store']) !!}
						{!! Form::hidden('modulo', $module) !!}
						<div class="row">
                            <div class="col-md-2 form-group">
								{!! Form::label('codigo', $titulo.':') !!}
								{!! Form::text('codigo', null, ['class'=>'form-control','autocomplete'=>'off']) !!}
                            </div>                            
							<div class="col-md-7 form-group">
								{!! Form::label('nombre', 'Nombre:') !!}
								{!! Form::text('nombre', null, ['class'=>'form-control','autocomplete'=>'off']) !!}
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
    var url_global='{{url("/")}}';
	$(document).ready(function(){
        document.getElementById('codigo').addEventListener("blur",function(){
            this.value = this.value.toUpperCase();
        });
    });
    $(document).ready(function(){
        document.getElementById('nombre').addEventListener("blur",function(){
            this.value = this.value.toUpperCase();
        });
    });
</script>
@endsection
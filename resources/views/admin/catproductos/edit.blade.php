{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Categoria Productos')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/catproductos/'.$catproducto->modulo) }}"><i class="fas fa-folder-open"></i> Categoria Productos</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
                    <div class="headercontent">
                        @php($nombres = getProductosArray())
                        <h2 class="title"><i class="fas fa-folder-open"></i> Categoria Productos: <strong>{{ $nombres[$catproducto->modulo] }}</strong></h2>
                            <ul>
                            </ul>
                        </div>
					<div class="inside">
						{!! Form::model($catproducto,['route'=>['admin.catproductos.update',$catproducto], 'method' => 'put']) !!}
						{!! Form::hidden('modulo', null) !!}
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
{{-- @extends('adminlte::page') --}}
@extends('admin.master')

@section('title','Roles')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/roles') }}"><i class="fas fa-cog"></i> Roles</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					<div class="inside">
                        {!! Form::model($role, ['route' => ['admin.roles.update',$role], 'method' => 'put']) !!}
                            <div class="row">
                                <div class="col-md-5 form-group">
                                    {!! Form::label('name', 'Nombre') !!}
                                    {!! Form::text('name', null, ['class'=>'form-control','autocomplete'=>'off']) !!}
                                </div>
                            </div>
                            {{-- {{dd($role)}} --}}
                            <div class="row">
                                <div class="col">
                                    <h2 class="h4 colorprin">Lista de Permisos:</h2>
                                    @php
                                        $cabecera = 1;
                                        $pie = 1;
                                        $rolcambio = $permissions[0]->module_id;
                                    @endphp
                                    <div class="row">
                                        {{-- <div class="card-group"> --}}
                                        @foreach ($permissions as $permission)
                                        @if ($rolcambio <> $permission->module_id)
                                                </div>
                                            </div>
                                        </div>
                                            @php
                                                $cabecera = 1;
                                                $pie = 1;
                                                $rolcambio = $permission->module_id;
                                            @endphp
                                        @endif
                                        @if ($cabecera == 1)
                                        <div class="col-md-4 d-flex">
                                            <div class="card flex-fill">
                                                <div class="card-header colorprin">
                                                    <strong>{{$permission->module_name}}</strong>
                                                </div>
                                                <div class="card-body">
                                        @php $cabecera = 2;$pie = 1;@endphp
                                        @endif
                                        <label>
                                            {!! Form::checkbox('permissions[]', $permission->id, null,['class' => 'mr-1']) !!}
                                            {{ $permission->description}}
                                        </label><br>
                                        @if ($pie == 2)
                                                </div>
                                            </div>
                                        </div>
                                        @php $cabecera = 1;$pie = 1;@endphp
                                        @endif
                                        
                                        @endforeach
                                        {{-- </div> --}}
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    {!! Form::submit('Guardar', ['class'=>'btn btn-convertir mtop16']) !!}
                                </div>
                                
                            </div>
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
        document.getElementById('name').addEventListener("blur",function(){
            this.value = this.value.toUpperCase();
        });
    });
</script>
@endsection
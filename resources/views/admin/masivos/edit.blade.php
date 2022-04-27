@extends('admin.master')
@section('title','Pagos Masivos')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.masivos.index') }}"><i class="fas fa-file-invoice-dollar"></i> Pagos Masivos</a>
	</li>
@endsection

@section('contenido')
    <div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
                    <div class="headercontent">
						<h2 class="title"><i class="fas fa-file-invoice-dollar"></i> Pagos Masivos</h2>
						<ul>
                            <li>
                                {!! Form::submit('Guardar', ['class'=>'btn btn-convertir mt-2', 'id'=>'guardar']) !!}
                            </li>
						</ul>
					</div>
					<div class="inside">
						{!! Form::model($masivo, ['route'=>['admin.masivos.store', $masivo], 'method' => 'put']) !!}
						<div class="row">
                            <div class="col-md-2 form-group">
                                {!! Form::hidden('id', null,['id'=>'id']) !!}
                                {!! Form::label('cuenta_id', 'Cuenta:') !!}
                                {!! Form::select('cuenta_id',$cuentas,null,['class'=>'custom-select']) !!}
                            </div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('fecha', 'Fecha:') !!}
                                {!! Form::date('fecha', null, ['class'=>'form-control activo']) !!}
                            </div>
                            <div class="col-md-1 form-group">
                                {!! Form::label('tc', 'TC:') !!}
                                {!! Form::text('tc', null, ['class'=>'form-control decimal activo','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-5 form-group">
                                {!! Form::label('glosa', 'Glosa:') !!}
                                {!! Form::text('glosa', null, ['class'=>'form-control mayuscula','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('monto', 'Monto:') !!}
                                {!! Form::text('monto', null, ['class'=>'form-control decimal','autocomplete'=>'off', 'disabled']) !!}
                            </div>
						</div>
						{!! Form::close() !!}
					</div>				
				</div>
                
			</div>
		</div>
        <div class="row mtop16">
			<div class="col-md-12">
				<div class="panelprin shadow">
					<div class="inside">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="" id="tdetitem">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="buscarLote" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        {{-- <div class="modal-header">
                            <input type="text" class='form-control' id= 'buscarl' placeholder = 'Buscar documentos pendientes' autocomplete='off' autofocus>
                        </div> --}}
                        <div class="modal-body">
                            <div id="pendientes">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-convertir" data-dismiss='modal'>Salir</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fin Modal -->
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
        $('#fecha').blur(function(){
            $.get(url_global+"/admin/rcompras/"+this.value+"/bustc/",function(response){
                $('#tc').val(response['venta']);
            });
        });

        veritems();
    });
    function veritems(){
        var id = $('#id').val();
        $.get(url_global+"/admin/masivos/"+id+"/tablaitem/",function(response){
            $('#tdetitem').empty();
            $('#tdetitem').html(response);
        });
    }

    function pendientes(){
        $.get(url_global+"/admin/masivos/pendientes/",function(response){
            // alert('Pendientes');
            $('#pendientes').empty();
            $('#pendientes').html(response);
        });
    }
</script>
@endsection
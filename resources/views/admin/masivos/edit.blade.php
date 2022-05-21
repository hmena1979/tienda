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
                    {!! Form::model($masivo, ['route'=>['admin.masivos.update', $masivo], 'method' => 'put']) !!}
                    <div class="headercontent">
						<h2 class="title"><i class="fas fa-file-invoice-dollar"></i> Pagos Masivos</h2>
						<ul>
                            @if ($masivo->estado == 1)
                            @can('admin.masivos.edit')
                            <li>
                                {!! Form::submit('Guardar', ['class'=>'btn btn-convertir mt-2', 'id'=>'guardar']) !!}
                            </li>                                
                            @endcan
                            @can('admin.masivos.autorizar')
                            <li>
                                <button type="button" id='autorizar' class="btn btn-convertir mt-2">Autorizar</button>
                            </li>
                            @endcan
                            @endif
                            @can('admin.masivos.generar')
                            @if ($masivo->estado == 2)
                            <li>
                                <button type="button" id='generar' class="btn btn-convertir mt-2">Generar</button>
                            </li>
                            @endif
                            @if ($masivo->estado == 3)
                            <li>
                                <a class="btn btn-convertir mt-2" href="{{ route('admin.masivos.download_macro',$masivo) }}">Descargar</a>
                            </li>
                            @endif
                            @if ($masivo->estado <> 1)
                            {{-- <li>
                                <a class="btn btn-convertir mt-2" href="{{ route('admin.masivos.revertir',$masivo) }}">Revertir</a>
                            </li> --}}
                            <li>
                                <button type="button" id='revertir' class="btn btn-convertir mt-2">Revertir</button>
                            </li>
                            @endif
                            @endcan
                            <li><a class="btn btn-convertir mt-2" href="{{ route('admin.pdf.masivos',$masivo) }}" target="_blank" datatoggle="tooltip" data-placement="top" title="Imprimir"><i class="fas fa-print"></i></a></li>
						</ul>
					</div>
					<div class="inside">
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
                            <div class="col-md-7 form-group">
                                {!! Form::label('glosa', 'Glosa:') !!}
                                {!! Form::text('glosa', null, ['class'=>'form-control mayuscula','autocomplete'=>'off']) !!}
                            </div>
                            {{-- <div class="col-md-2 form-group">
                                {!! Form::label('monto', 'Monto:') !!}
                                {!! Form::text('monto', null, ['class'=>'form-control decimal','autocomplete'=>'off', 'disabled']) !!}
                            </div> --}}
						</div>
					</div>				
                    {!! Form::close() !!}
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

        $('#autorizar').click(function(){
            var id = $('#id').val();
            $.get(url_global+"/admin/masivos/"+id+"/autorizar/",function(response){
                if (response == 1) {
                    location.reload();
                } else {
                    Swal.fire({
                        icon:'warning',
                        title:'Error',
                        text:'No se encontró cuenta de alguno de los Proveedores'
                    });
                }
            });
        });

        $('#generar').click(function(){
            var id = $('#id').val();
            $.get(url_global+"/admin/masivos/"+id+"/generar/",function(response){
                // alert(response);
                location.reload();
            });
        });

        $('#revertir').click(function(){
            var id = $('#id').val();
            Swal.fire({
            title: 'Está Seguro que desea Revertir el Pago Masivo?',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '¡Si, revertir!',
            cancelButtonText: 'Cancelar'
            }).then((result) => {
            if (result.value) {
                $.get(url_global+"/admin/masivos/"+id+"/revertir/",function(response){
                    location.reload();
                });
            }
            })
            
        });

    });
    function veritems(){
        var id = $('#id').val();
        $.get(url_global+"/admin/masivos/"+id+"/tablaitem/",function(response){
            $('#tdetitem').empty();
            $('#tdetitem').html(response);
        });
    }

    function pendientes(){
        var id = $('#id').val();
        $.get(url_global+"/admin/masivos/"+id+"/pendientes/",function(response){
            $('#pendientes').empty();
            $('#pendientes').html(response);
        });
    }

    function destroyitem(id){
		Swal.fire({
            title: 'Está Seguro de Eliminar el Registro?',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '¡Si, eliminar!',
            cancelButtonText: 'Cancelar'
            }).then((result) => {
            if (result.value) {
				$.get(url_global+"/admin/masivos/"+id+"/destroyitem/",function(response){
                    // vertotales();
                    veritems();
                    Swal.fire({
                        icon:'success',
                        title:'Eliminado',
                        text:'Registro Eliminado'
                    });
				});
                
            }
            })
	}
</script>
@endsection
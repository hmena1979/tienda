{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Consumos')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.consumos.index') }}"><i class="fas fa-cart-arrow-down"></i> Consumos</a>
	</li>
@endsection

@section('contenido')
    <div id="mensaje_error" class="alert alert-danger" style="display:none;">
        <strong id="contenido_error"></strong>
    </div>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
                {!! Form::model($consumo,['route'=>['admin.consumos.update',$consumo], 'method' => 'put']) !!}
				<div class="panelprin shadow">
                    <div class="headercontent">
						<h2 class="title"><i class="fas fa-cart-arrow-down"></i> Consumos</h2>
						{{-- <ul>
                            <li>
                                {!! Form::submit('Generar', ['class'=>'btn btn-convertir mt-2', 'id'=>'guardar']) !!}
                            </li>
						</ul> --}}
					</div>
					<div class="inside">
                        <div class="row">
                            <div class="col-md-3 form-group">
                                {!! Form::label('destino_id', 'Destino:') !!}
                                {!! Form::select('destino_id',$destinos,$consumo->detdestino->destino_id,['class'=>'custom-select','placeholder'=>'']) !!}
                                {!! Form::hidden('id',null,['id' => 'id']) !!}
                            </div>
                            <div class="col-md-3 form-group">
                                {!! Form::label('detdestino_id', 'Detalle:') !!}
                                {!! Form::select('detdestino_id',$detdestinos,null,['class'=>'custom-select','placeholder'=>'']) !!}
                            </div>
                            <div class="col-md-2">
                                {!! Form::label('lote', 'Lote:') !!}
                                {!! Form::select('lote',$lotes,null,['class'=>'custom-select activo','placeholder' => '']) !!}
                                {{-- {!! Form::text('lote', null, ['class'=>'form-control mayuscula activo','autocomplete'=>'off']) !!} --}}
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        {!! Form::label('fecha', 'Fecha:') !!}
                                        {!! Form::text('fecha', date('Y-m-d',strtotime($consumo->fecha)), ['class'=>'form-control activo']) !!}
                                    </div>
                                    <div class="col-md-8">
                                        {!! Form::label('detalle', 'Recibido por:') !!}
                                        {!! Form::text('detalle', null, ['class'=>'form-control mayuscula activo','autocomplete'=>'off']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
					</div>				
				</div>
                {!! Form::close() !!}
			</div>
		</div>
        <div class="row mtop16 add">
            <div class="col-md-12">
                <div id="mensaje_errorp" class="alert alert-danger" style="display:none;">
                    <strong id="contenido_errorp"></strong>
                </div>
                <div class="panelprin shadow">
                    <div class="headercontent">
                        <h2 class="title">
                            Devolución de Producto
                        </h2>
                        <ul>
                            <li>
                                <button type="button" id='aceptar' class="btn btn-convertir mt-2" datatoggle="tooltip" data-placement="top" title="Guardar"><i class="fas fa-check"></i> Guardar</button>
                            </li>
                            <li>
                                <button type="button" id='descartar' class="btn btn-convertir mt-2" datatoggle="tooltip" data-placement="top" title="Descartar"><i class="far fa-times-circle"></i> Descartar</button>
                            </li>
                        </ul>
                    </div>
                    <div class="inside">
                        {!! Form::open(['route'=>'admin.rventas.additem','id'=>'formadditem']) !!}
                        <div class="row">
                            <div class="col-md-5 form-group">
                                {!! Form::hidden('iddet',null,['id'=>'iddet']) !!}
                                {!! Form::label('producto', 'Producto:') !!}
                                {!! Form::text('producto',null,['class'=>'form-control mayuscula','disabled']) !!}
                            </div>
                            <div class="col-md-3 form-group">
                                {!! Form::label('adicional', 'Información Adicional:') !!}
                                {!! Form::textarea('adicional',null,['class'=>'form-control mayuscula', 'rows'=>'1','disabled']) !!}
                            </div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('cantidad', 'Pedido:') !!}
                                {!! Form::text('cantidad', null, ['class'=>'form-control decimal','disabled']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 form-group">
                                {!! Form::label('dfecha', 'Fecha:') !!}
                                {!! Form::date('dfecha', Carbon\Carbon::now(), ['class'=>'form-control activo']) !!}
                            </div>
                            <div class="col-md-6 form-group">
                                {!! Form::label('motivo', 'Motivo:') !!}
                                {!! Form::text('motivo', null, ['class'=>'form-control mayuscula', 'maxlength' => '100']) !!}
                            </div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('devolucion', 'Devolución:') !!}
                                {!! Form::text('devolucion', null, ['class'=>'form-control decimal']) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="row mtop16 detalle">
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
        </div>
	</div>
@endsection
@section('script')
<script>
    var url_global='{{url("/")}}';
    $(document).ready(function(){
        $('.add').hide();
        $('.finalizar').hide();

        $('#descartar').click(function(){
            $('.add').hide();
            $('.detalle').show();
        });

        veritems();

        $('#aceptar').click(function(){
            var det = {
                'id' : $('#iddet').val(),
                'dfecha' : $('#dfecha').val(),
                'motivo' : $('#motivo').val(),
                'devolucion' : $('#devolucion').val(),
            };
            var envio = JSON.stringify(det);
            $.get(url_global+"/admin/consumos/"+envio+"/devolucion/",function(response){
                $('.add').hide();
                veritems();
                $('.detalle').show();
            });
        });

        $('#devolucion').blur(function(){
            if (Number($('#devolucion').val()) > Number($('#cantidad').val())) {
                Swal.fire(
                    'Error',
                    'La cantidad a devolver supera a lo entregado',
                    'error'
                    );
                $('#devolucion').val($('#cantidad').val());
            }
        });
    });

    function veritems(){
        var id = $('#id').val();
        $.get(url_global+"/admin/consumos/"+id+"/tabladevol/",function(response){
            $('#tdetitem').empty();
            $('#tdetitem').html(response);
        });
    }

    function editdp(id) {
        $('.add').show();
        $('.detalle').hide();
        $.get(url_global+"/admin/consumos/"+id+"/detconsumo/",function(response){
            $('#iddet').val(response['id']);
            $('#producto').val(response['producto']);
            $('#adicional').val(response['adicional']);
            $('#cantidad').val(response['cantidad']);
            $('#dfecha').val(response['dfecha']);
            $('#motivo').val(response['motivo']);
            $('#devolucion').val(response['devolucion']);
        });
    }

</script>
@endsection
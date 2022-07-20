@extends('admin.master')
@section('title','Orden de Compra')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.ordcompras.busproducto') }}"><i class="fas fa-window-restore"></i> Busqueda de Producto</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
                {!! Form::open(['route'=>'admin.excel.tolvasview']) !!}
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-window-restore"></i> Busqueda de Producto</h2>
						<ul>
							{{-- <li>
                                {!! Form::submit('Mostrar', ['class'=>'btn btn-convertir mt-2', 'id'=>'mostrar']) !!}
                            </li> --}}
						</ul>
					</div>
					<div class="inside">
                        <div class="row">
                            <div class="col-md-4 form-group">
                                {!! Form::label('producto_id', 'Producto:') !!}
                                {!! Form::select('producto_id',$productos,$producto?$producto->id:null,['class'=>'custom-select','placeholder'=>'']) !!}
                            </div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('stock', 'Stock:') !!}
                                {!! Form::text('stock', $producto?$producto->stock:null, ['class'=>'form-control decimal','autocomplete'=>'off','disabled']) !!}
                            </div>
                            <div class="col-md-2 form-group producto">
                                {!! Form::label('stockmin', 'Stock Mínimo:') !!}
                                {!! Form::text('stockmin', $producto?$producto->stockmin:null, ['class'=>'form-control decimal','autocomplete'=>'off','disabled']) !!}
                            </div>
                            <div class="col-md-2 form-group producto">
                                {!! Form::label('precompra', 'Precio:') !!}
                                {!! Form::text('precompra', $producto?$producto->precompra:null, ['class'=>'form-control decimal','autocomplete'=>'off','disabled']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 d-flex">
                                <div class="card flex-fill">
                                    <div class="card-header colorprin negrita text-center">CONSUMO ÚLTIMO AÑO</div>
                                    <div class="card-body" id="tconsumos">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9 d-flex">
                                <div class="card flex-fill">
                                    <div class="card-header colorprin negrita text-center">ÚLTIMAS COMPRAS</div>
                                    <div class="card-body" id="tcompras"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 d-flex">
                                <div class="card flex-fill">
                                    <div class="card-header colorprin negrita text-center">COTIZACIONES</div>
                                    <div class="card-body" id="tcotizaciones"></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
@section('script')
<script>
	var url_global='{{url("/")}}';
    $(document).ready(function(){
        $('#producto_id').select2({
            placeholder:"Ingrese 4 dígitos del Nombre del Producto",
            minimumInputLength: 4,
            ajax:{
                url: "{{ route('admin.productos.seleccionadot') }}",
                dataType:'json',
                delay:250,
                processResults:function(response){
                    return{
                        results: response
                    };
                },
                cache: true,
            }
        });
        $('#producto_id').on('select2:close',function(){
            var producto = this.value;
            verconsumos();
            vercompras();
            vercotizaciones();
            $.get(url_global+"/admin/productos/"+producto+"/showdetp/",function(response){
                $("#stock").val(response["stock"]);
                $("#stockmin").val(response["stockmin"]);
                $("#precompra").val(response["precompra"]);
            });
        });
        verconsumos();
        vercompras();
        vercotizaciones();
    });
    function verconsumos(){
        if ($('#producto_id').val()) {
            $.get(url_global+"/admin/ordcompras/"+$('#producto_id').val()+"/consumos/",function(response){
                $('#tconsumos').empty();
                $('#tconsumos').html(response);
            });
        }
    }
    function vercompras(){
        if ($('#producto_id').val()) {
            $.get(url_global+"/admin/ordcompras/"+$('#producto_id').val()+"/compras/",function(response){
                $('#tcompras').empty();
                $('#tcompras').html(response);
            });
        }
    }
    function vercotizaciones(){
        if ($('#producto_id').val()) {
            $.get(url_global+"/admin/ordcompras/"+$('#producto_id').val()+"/cotizaciones/",function(response){
                $('#tcotizaciones').empty();
                $('#tcotizaciones').html(response);
            });
        }
    }
</script>
@endsection
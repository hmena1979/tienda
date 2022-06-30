{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Ingresos Almacen')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.ingresos.index') }}"><i class="fas fa-cart-plus"></i> Ingresos Almacen</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                {!! Form::model($ingreso,['route'=>['admin.ingresos.update',$ingreso],'method'=>'put']) !!}
				<div class="panelprin shadow">
                    <div class="headercontent">
                        <h2 class="title"><i class="fas fa-cart-plus"></i> Ingresos Almacen</h2>
                        <ul>
                            <li>
                                {!! Form::submit('Guardar', ['class'=>'btn btn-convertir mt-2 activo', 'id'=>'guardar']) !!}
                            </li>
                            <li>
                                <a class="btn btn-convertir mt-2" href="{{ route('admin.pdf.ingresos',$ingreso) }}" target="_blank" datatoggle="tooltip" data-placement="top" title="Imprimir"><i class="fas fa-print"></i></a>
                            </li>
                        </ul>
                    </div>
					<div class="inside">
                        <div class="row">
                            <div class="col-md-1 form-group">
                                {{-- {{ $ingreso->detingreso->count() }} --}}
                                {!! Form::hidden('detalles', $ingreso->detingresos->count(),['id'=>'detalles']) !!}
                                {!! Form::hidden('id', null,['id'=>'id']) !!}
                                {!! Form::label('peringreso', 'Periodo:') !!}
								{!! Form::text('peringreso', null, ['class'=>'form-control activo']) !!}
							</div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('fecha', 'Fecha Compra:') !!}
                                {!! Form::date('fecha', null, ['class'=>'form-control guarda','disabled']) !!}
                            </div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('fechaingreso', 'Fecha Ingreso:') !!}
                                {!! Form::date('fechaingreso', null, ['class'=>'form-control activo']) !!}
                            </div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('fechaguia', 'Fecha Guía:') !!}
                                {!! Form::date('fechaguia', null, ['class'=>'form-control activo']) !!}
                            </div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('numeroguia', 'N° Guía:') !!}
								{!! Form::text('numeroguia', null, ['class'=>'form-control activo']) !!}
							</div>
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        {!! Form::label('moneda', 'Moneda:') !!}
                                        {!! Form::select('moneda',$moneda,null,['class'=>'custom-select guarda','disabled']) !!}
                                    </div>
                                    <div class="col-md-6 form-group">
                                        {!! Form::label('tc', 'TC:') !!}
                                        {!! Form::text('tc', null, ['class'=>'form-control decimal guarda','disabled','autocomplete'=>'off']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 form-group">
                                {!! Form::label('tipocomprobante_codigo', 'Tipo Comprobante:') !!}
                                {!! Form::select('tipocomprobante_codigo',$tipocomprobante,null,['class'=>'custom-select guarda','disabled','placeholder'=>'']) !!}
                            </div>                      
                            <div class="col-md-2">
                                {!! Form::label('numero', 'Número Documento:') !!}
                                <div class="row no-gutters">
                                    <div class="col-md-4">
                                        {!! Form::text('serie', null, ['class'=>'form-control mayuscula guarda','disabled','maxlength'=>'4','autocomplete'=>'off']) !!}
                                    </div>
                                    <div class="col-md-8">								
                                        {!! Form::text('numero', null, ['class'=>'form-control mayuscula guarda','disabled','maxlength'=>'15','autocomplete'=>'off']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                {!! Form::label('cliente_id', 'Proveedor:') !!}
                                {!! Form::select('cliente_id',$clientes,null,['class'=>'custom-select guarda','disabled','id'=>'cliente_id','placeholder'=>'']) !!}
                            </div>
                            <div class="col-md-3 form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        {!! Form::label('monto', 'Valor Compra:') !!}
                                        {!! Form::text('monto', $ingreso->afecto+$ingreso->exonerado+$ingreso->otros, ['class'=>'form-control decimal','disabled','autocomplete'=>'off']) !!}
                                    </div>
                                    <div class="col-md-6">
                                        {!! Form::label('total', 'Total Ingresado:') !!}
                                        {!! Form::text('total', $ingreso->detingresos->sum('subtotal'), ['class'=>'form-control decimal','disabled','autocomplete'=>'off']) !!}
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                {!! Form::label('entregadopor', 'Entregado Por:') !!}
                                {!! Form::text('entregadopor', null, ['class'=>'form-control mayuscula','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-3 form-group">
                                {!! Form::label('ordencompra', 'Orden de Compra:', ['class' => 'adddetalle']) !!}
                                <div class="row no-gutters">
                                    <div class="col-md-10">
                                        {!! Form::select('ordencompra',$ordcompras,null,['class'=>'custom-select adddetalle','placeholder'=>'']) !!}
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-block btn-convertir adddetalle" type="button" id="addordencompra" title="Agregar Productos"><i class="fas fa-plus"></i></button>
                                    </div>
                                </div>                                
                            </div> 
                        </div>
						{{-- {!! Form::submit('Guardar', ['class'=>'btn btn-convertir', 'id'=>'guardar']) !!} --}}
					</div>				
				</div>
                {!! Form::close() !!}
			</div>
		</div>
        {{-- {{ dd($ingreso) }} --}}
        <div class="row mtop16 adddetalle">
            <div class="col-md-12">
                <div class="panelprin shadow">
                    <div class="inside">
                        {!! Form::open(['route'=>['admin.ingresos.adddet',$ingreso]]) !!}
                        <div class="row">
                            <div class="col-md-11">
                                <div class="row">
                                    <div class="col-md-5 form-group">
                                        {!! Form::label('producto_id', 'Producto:') !!}
                                        {!! Form::select('producto_id',[],null,['class'=>'custom-select','placeholder'=>'']) !!}
                                        {!! Form::hidden('afectacion_id',null,['id'=>'afectacion_id']) !!}
                                        {!! Form::hidden('lotevencimiento',null,['id'=>'lotevencimiento']) !!}
                                        {!! Form::hidden('ctrlstock',null,['id'=>'ctrlstock']) !!}
                                    </div>
                                    <div class="col-md-7">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="row">
                                                    <div class="col-md-6 form-group">
                                                        {!! Form::label('cantidad', 'Cantidad:') !!}
                                                        {!! Form::text('cantidad', null, ['class'=>'form-control decimal']) !!}
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        {!! Form::label('pre_ini', 'Precio Inicial:') !!}
                                                        {!! Form::text('pre_ini', null, ['class'=>'form-control decimal']) !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="row">
                                                    <div class="col-md-4 form-group">
                                                        {!! Form::label('igv', 'IGV:') !!}
                                                        {!! Form::select('igv',['1'=>'Incluído','2'=>'No Incluído'],null,['class'=>'custom-select']) !!}
                                                    </div>
                                                    <div class="col-md-4 form-group">
                                                        {!! Form::label('precio', 'Precio:') !!}
                                                        {!! Form::text('precio', null, ['class'=>'form-control decimal']) !!}
                                                    </div>
                                                    <div class="col-md-4 form-group">
                                                        {!! Form::label('subtotal', 'SubTotal:') !!}
                                                        {!! Form::text('subtotal', null, ['class'=>'form-control decimal']) !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2 form-group">
                                        {!! Form::label('lote', 'Lote:') !!}
                                        <div class="input-group">
                                            {!! Form::text('lote', null, ['class'=>'form-control mayuscula','maxlength'=>'15','disabled']) !!}
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="button" id="buslote" data-toggle="modal" data-target="#buscarLote" onclick="limpia()"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 form-group">
                                        {!! Form::label('vence', 'Vencimiento:') !!}
                                        {{-- {!! Form::text('vence', null, ['class'=>'form-control mayuscula','maxlength'=>'10']) !!} --}}
                                        <div class="row no-gutters">
                                            <div class="col-md-7">								
                                                {!! Form::text('venceanio', null, ['class'=>'form-control','id'=>'venceanio','autocomplete'=>'off','maxlength'=>'4','title'=>'Año','disabled']) !!}
                                            </div>
                                            <div class="col-md-5">
                                                {!! Form::text('vencemes', null, ['class'=>'form-control','id'=>'vencemes','autocomplete'=>'off','maxlength'=>'2','title'=>'Mes','disabled']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8 form-group">
                                        {!! Form::label('glosa', 'Glosa:') !!}
                                        {!! Form::text('glosa', null, ['class'=>'form-control mayuscula']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1">
                                {!! Form::submit('+', ['class'=>'btn btn-block btn-addingreso', 'id'=>'agregar']) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                        <!-- Modal -->
                        <div class="modal fade" id="buscarLote" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <input type="text" class='form-control' id= 'buscarl' placeholder = 'Buscar lote' autocomplete='off' autofocus>
                                    </div>
                                    <div class="modal-body">
                                        <div class="cuerpol">
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
            </div>
        </div>
        <div class="row mtop16 adddetalle">
            <div class="col-md-12">
                <div class="panelprin shadow">
                    <div class="inside">
                        <table class="table table-responsive-md table-hover table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th width='45%'>Producto</th>
                                    <th class="text-right" width='10%'>Cantidad</th>
                                    <th class="text-right" width='10%'>Precio</th>
                                    <th class="text-right" width='10%'>SubTotal</th>
                                    <th width='10%'>Lote</th>
                                    <th width='10%'>Vencimiento</th>
                                    <th width='5%'></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ingreso->detingresos as $det)
                                <tr>
                                    <td>
                                        {{ $det->producto->nombre . ' X ' . $det->producto->umedida->nombre }}
                                        {{-- @if ($det->detproducto->marca_id <> 1)
                                            {{ ' '.$det->detproducto->marca->nombre.' ' }}
                                        @endif
                                        @if ($det->detproducto->talla_id <> 1)
                                            {{ ' TALLA '.$det->detproducto->talla->nombre.' ' }}
                                        @endif
                                        @if ($det->detproducto->color_id <> 1)
                                            {{ ' COLOR '.$det->detproducto->color->nombre.' ' }}
                                        @endif --}}
                                    </td>
                                    {{-- {{ dd($det->detproducto->producto) }} --}}
                                    {{-- <td>{{ $det->detproducto->producto->nombre }}</td> --}}
                                    <td class="text-right">{{ number_format($det->cantidad ,4) }}</td>
                                    <td class="text-right">{{ number_format($det->precio,4) }}</td>
                                    <td class="text-right">{{ number_format($det->subtotal, 2) }}</td>
                                    <td>{{ $det->lote }}</td>
                                    <td>{{ $det->vence }}</td>
                                    <td class="text-center">
                                        <div class='opts'>
                                            {{-- <button type="button" class="btn" id='editdetp' title="Editar" onclick = "editdp('{{ $det->id }}');">
                                                <i class='fas fa-edit'></i>
                                            </button> --}}
                                            {{-- <button type="button" class="btn" id='destroydetp' title="Eliminar" onclick="destroydp('{{ $det->id }}');">
                                                <i class="fas fa-trash-alt"></i>
                                            </button> --}}
                                            <form action="{{ route('admin.ingresos.destroydet',$det) }}" method="POST" class="formulario_eliminars">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" datatoggle="tooltip" data-placement="top" title="Eliminar">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
	</div>
@endsection
{{-- @section('css')
    <link rel="stylesheet" href="{{ url('/static/css/admin.css?v='.time()) }}">
@stop --}}
{{-- @section('js')
    <script src="{{ url('/static/js/admin.js?v='.time()) }}"></script>
@stop --}}
@section('script')
<script>
    var url_global='{{url("/")}}';
    $('#buslote').prop('disabled',true);
    $(document).ready(function(){
        $('#guardar').click(function(){
            $('.guarda').prop('disabled',false);
        });

        if($('#detalles').val() != 0){
            $('.activo').prop('disabled',true);
        }

        if($('#fechaingreso').val() && $('#entregadopor').val()){
            $('.adddetalle').show();
        }else{
            $('.adddetalle').hide();
        }

        $('#addordencompra').click(function(){
            if ($('#ordencompra').val()) {
                $.get(url_global+"/admin/ingresos/"+$('#id').val()+'/'+$('#ordencompra').val()+"/cargaoc/",function(respuesta){
                    location.reload();
                    // alert(respuesta)
                })
            }
        });

        $('#producto_id').select2({
            placeholder:"Ingrese 4 dígitos del Nombre del Producto",
            minimumInputLength: 4,
            ajax:{
                url: "{{ route('admin.productos.seleccionado') }}",
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
            $.get(url_global+"/admin/productos/"+producto+"/showdetp/",function(response){
                $('#id').val(response['id']);
                $('#afectacion_id').val(response['afectacion_id']);
                $('#ctrlstock').val(response['ctrlstock']);
                $("#lotevencimiento").val(response["lotevencimiento"]);
                if(response["lotevencimiento"] == 2){
                    $('#lote').prop('disabled',true);
                    $('#venceanio').prop('disabled',true);
                    $('#vencemes').prop('disabled',true);
                    $('#buslote').prop('disabled',true);
                }else{
                    $('#lote').prop('disabled',false);
                    $('#venceanio').prop('disabled',false);
                    $('#vencemes').prop('disabled',false);
                    $('#buslote').prop('disabled',false);
                }
                if(response["afectacion_id"] == '10'){
                    $('#igv').prop('disabled',false);
                    $('#igv').val(1);
                }else{
                    $('#igv').prop('disabled',true);
                    $('#igv').val(2);
                }
            });
        });

        $('#cantidad').blur(function(){
            const cantidad = NaNToCero(parseFloat($('#cantidad').val()));
            const pre_ini = NaNToCero(parseFloat($('#pre_ini').val()));
            const precio = NaNToCero(parseFloat($('#precio').val()));
            if(pre_ini>0){
                $('#subtotal').val(Redondea(cantidad * precio,2));
            }
        });

        $('#pre_ini').blur(function(){
            const cantidad = NaNToCero(parseFloat($('#cantidad').val()));
            const pre_ini = NaNToCero(parseFloat($('#pre_ini').val()));
            const igv = $('#igv').val();
            const porigv = {{ session('igv') }} / 100;
            if(pre_ini>0){
                if(igv == 1){
                    $('#precio').val(Redondea(pre_ini / (1+porigv),4));
                }else{
                    $('#precio').val(pre_ini);
                }
                $('#subtotal').val(Redondea(cantidad * $('#precio').val(),2));
            }
        });

        $('#igv').change(function(){
            const cantidad = NaNToCero(parseFloat($('#cantidad').val()));
            const pre_ini = NaNToCero(parseFloat($('#pre_ini').val()));
            const igv = $('#igv').val();
            const porigv = {{ session('igv') }} / 100;
            if(pre_ini>0){
                if(igv == 1){
                    $('#precio').val(Redondea(pre_ini / (1+porigv),4));
                }else{
                    $('#precio').val(pre_ini);
                }
                $('#subtotal').val(Redondea(cantidad * $('#precio').val(),2));
            }
        });

        $('#precio').blur(function(){
            const cantidad = NaNToCero(parseFloat($('#cantidad').val()));
            const precio = NaNToCero(parseFloat($('#precio').val()));
            const igv = $('#igv').val();
            const porigv = {{ session('igv') }} / 100;
            if(precio>0){
                if(igv == 1){
                    $('#pre_ini').val(Redondea(precio * (1+porigv),4));
                }else{
                    $('#pre_ini').val(precio);
                }
                $('#subtotal').val(Redondea(cantidad * $('#precio').val(),2));
            }
        });

        $('#subtotal').blur(function(){
            const cantidad = NaNToCero(parseFloat($('#cantidad').val()));
            const subtotal = NaNToCero(parseFloat($('#subtotal').val()));
            const igv = $('#igv').val();
            const porigv = {{ session('igv') }} / 100;
            if(cantidad>0){
                if(igv == 1){
                    $('#precio').val(Redondea(subtotal / cantidad,4));
                    $('#pre_ini').val(Redondea($('#precio').val() * (1+porigv),4));
                }else{
                    $('#precio').val(Redondea(subtotal / cantidad,4));
                    $('#pre_ini').val($('#precio').val());
                }
            }
        });

        $('#buscarl').keyup(function(){
            tabresultl(this.value);
        });

        $('#lote').blur(function(){
            if(this.value.length >= 1){
                // alert('Sale');
                var producto = $('#producto_id').val();
                $.get(url_global+"/admin/productos/"+producto+"/"+this.value+"/buslote/",function(response){
                    if (response!=""){
                        document.getElementById("lote").value = response[0].lote;
                        document.getElementById("venceanio").value = response[0].vencimiento.substring(0,4);
                        document.getElementById("vencemes").value = response[0].vencimiento.substring(5,7);
                    }else{
                        // document.getElementById("lote").value = null;
                        document.getElementById("vence").value = null;
                    }
                });
            }
        });

    });

    function tabresultl(parbus){
        var html = '';
        var producto = $('#producto_id').val();
        if(parbus.length >= 1){					
            $.get(url_global+"/admin/productos/"+producto+"/"+parbus+"/findlote/",function(response){
                if (response==""){
                    html = 'No se encontraton datos';
                }else{
                    html += "<table class='table table-resposive table-hover table-sm'>";
                    html += "<thead><tr><th>LOTE</th><th>VENCIMIENTO</th><th>STOCK</th><th></th></tr></thead>";
                    html += "<tbody>";
                    var regMostrar = 0;
                    if(response.length <= 10){
                        regMostrar = response.length;
                    }else{
                        regMostrar = 10;
                    }
                    for (var i = 0; i < regMostrar; i++) {
                        valor = response[i].id;
                        html += "<tr><td>"+response[i].lote + "</td><td>" +response[i].vencimiento+"</td><td>"+response[i].saldo+"</td>";
                        html += "<td><div class='opts'><button class='btn btn-primary btn-sm' type='button' datatoggle='tooltip' data-placement='top' title='Seleccionar' data-dismiss='modal' onclick=devLot("+valor+");><i class='fas fa-check'></i></button></div></td></tr>"
                    }
                    html += "</tbody></table>";							
                }
                document.getElementsByClassName('cuerpol')[0].innerHTML = html;
            });								
        }
    }

    function devLot(codigo){
        $.get(url_global+"/admin/productos/"+codigo+"/selectlote/",function(response){
            if (response!=""){
                document.getElementById("lote").value = response[0].lote;
                document.getElementById("venceanio").value = response[0].vencimiento.substring(0,4);
                document.getElementById("vencemes").value = response[0].vencimiento.substring(5,7);
            }else{
                alert('Errpr');
            }
        });
    }

    function limpia(){
        document.getElementsByClassName('cuerpol')[0].innerHTML = '';
        document.getElementById('buscarl').value = '';
    }

</script>
@endsection
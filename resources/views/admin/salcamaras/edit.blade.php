{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Guía de Salida a Cámaras')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.salcamaras.index') }}"><i class="fas fa-clipboard-check"></i> Guía de Salida a Cámaras</a>
	</li>
@endsection

@section('contenido')
    <div id="mensaje_error" class="alert alert-danger" style="display:none;">
        <strong id="contenido_error"></strong>
    </div>
	<div class="container-fluid">
		<div class="row" id = 'agregarcomprobante'>
            <div class="col-md-12">
                {!! Form::model($salcamara,['route'=>['admin.salcamaras.update',$salcamara], 'method'=>'put']) !!}
				<div class="panelprin shadow">
                    <div class="headercontent">
						<h2 class="title"><i class="fas fa-clipboard-check"></i> Guía de Salida a Cámaras</h2>
						<ul>
                            @if ($salcamara->estado == 1)
                            <li>
                                {!! Form::submit('Guardar', ['class'=>'btn btn-convertir mt-1', 'id'=>'guardar']) !!}
                            </li>
                            @can('admin.salcamaras.aprobar')
                            <li>
                                <a class="btn btn-convertir mt-1" href="{{ route('admin.salcamaras.aprobar',$salcamara) }}">Aprobar</a>
                            </li>
                            @endcan
                            @endif
                            @if ($salcamara->estado == 2)
                            @can('admin.salcamaras.aprobar')
                            <li>
                                <a class="btn btn-convertir mt-1" href="{{ route('admin.salcamaras.abrir',$salcamara) }}">Permitir Editar</a>
                            </li>
                            @endcan
                            @endif
                            <li>
                                <a class="btn btn-convertir mt-1" href="{{ route('admin.pdf.salcamara',$salcamara) }}" target="_blank" datatoggle="tooltip" data-placement="top" title="Imprimir"><i class="fas fa-print"></i></a>
                            </li>

						</ul>
					</div>
					<div class="inside">
                        <div class="row">
                            <div class="col-md-2">
                                {!! Form::hidden('id', null,['id' => 'id']) !!}
                                {!! Form::label('numero', 'Número:') !!}
                                {!! Form::text('numero', null, ['class'=>'form-control numero','maxlength'=>'6','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('fecha', 'Fecha:') !!}
                                {!! Form::date('fecha', null, ['class'=>'form-control']) !!}
                            </div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('motivo', 'Motivo Retiro:') !!}
                                {!! Form::select('motivo',[1=>'EXPORTACIÓN', 2=>'MUESTREO'],null,['class'=>'custom-select']) !!}
                            </div>
                            <div class="col-md-2">
                                {!! Form::label('contenedor', 'Contenedor:') !!}
                                {!! Form::text('contenedor', null, ['class'=>'form-control mayuscula','maxlength'=>'15','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-2">
                                {!! Form::label('precinto', 'Precinto:') !!}
                                {!! Form::text('precinto', null, ['class'=>'form-control mayuscula','maxlength'=>'30','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('supervisor_id', 'Supervisor:') !!}
                                {!! Form::select('supervisor_id',$supervisores,null,['class'=>'custom-select','placeholder'=>'']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                {!! Form::label('transportista_id', 'Transportista:') !!}
                                {!! Form::select('transportista_id',$transportistas,null,['class'=>'custom-select activo','placeholder'=>'']) !!}
                            </div>
                            <div class="col-md-2">
                                {!! Form::label('placas', 'Placas:') !!}
                                {!! Form::text('placas', null, ['class'=>'form-control mayuscula','maxlength'=>'50','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-2">
                                {!! Form::label('grt', 'Guía Transportista:') !!}
                                {!! Form::text('grt', null, ['class'=>'form-control mayuscula','maxlength'=>'15','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-2">
                                {!! Form::label('gr', 'Guía Remitente:') !!}
                                {!! Form::text('gr', null, ['class'=>'form-control mayuscula','maxlength'=>'15','autocomplete'=>'off']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                {!! Form::label('observaciones', 'Observaciones:') !!}
                                {!! Form::textarea('observaciones',null,['class'=>'form-control mayuscula', 'rows'=>'3', 'id'=>'editor']) !!}
                            </div>
                        </div>
					</div>				
				</div>
                {!! Form::close() !!}
			</div>
		</div>
        {{-- <div class="row mtop16 oculto" id="aeitem">
			<div class="col-md-12">
				<div class="panelprin shadow">
                    <div class="headercontent">
						<h2 class="title"><i class="fas fa-file-alt"></i> Ingrese Productos</h2>
						<ul>
                            <li>
                                <button type="button" id='add' class="btn btn-block btn-convertir mt-2" datatoggle="tooltip" data-placement="top" title="Aceptar">
                                    <i class="fas fa-check"></i> Aceptar
                                </button>
                            </li>
                            <li>
                                <button type="button" id='cancel' class="btn btn-block btn-convertir mt-2" datatoggle="tooltip" data-placement="top" title="Descartar">
                                    <i class="fas fa-times"></i> Descartar
                                </button>
                            </li>
						</ul>
					</div>
					<div class="inside">
                        {!! Form::open(['route'=>'admin.ingcamaras.additem', 'id'=>'formdetalle']) !!}
                        <div class="row">
                            <div class="col-md-2 form-group">
                                {!! Form::hidden('salcamara_id', $salcamara->id, ['id'=>'salcamara_id']) !!}
                                {!! Form::hidden('tipodet', 1, ['id'=>'tipodet']) !!}
                                {!! Form::hidden('iddet', null, ['id'=>'iddet']) !!}
                                {!! Form::label('trazabilidad_id', 'Producto:') !!}
                                {!! Form::select('trazabilidad_id',$trazabilidad,null,['class'=>'custom-select','id'=>'trazabilidad_id','placeholder'=>'']) !!}
                            </div>
                            <div class="col-md-3 form-group">
                                {!! Form::label('dettrazabilidad_id', 'Clasificación:') !!}
                                {!! Form::select('dettrazabilidad_id',[],null,['class'=>'custom-select','id'=>'dettrazabilidad_id','placeholder'=>'']) !!}
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        {!! Form::label('cantidad', 'Cantidad:') !!}
                                        {!! Form::text('cantidad', null, ['class'=>'form-control decimal','id'=>'cantidad']) !!}
                                    </div>
                                    <div class="col-md-4 form-group">
                                        {!! Form::label('peso', 'Peso Unit.:') !!}
                                        {!! Form::text('peso', null, ['class'=>'form-control decimal','id'=>'peso']) !!}
                                    </div>
                                    <div class="col-md-4 form-group">
                                        {!! Form::label('total', 'Total Kg:') !!}
                                        {!! Form::text('total', null, ['class'=>'form-control decimal','id'=>'total','disabled']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('observaciones', 'Observaciones:') !!}
                                {!! Form::text('observaciones', null, ['class'=>'form-control mayuscula','id'=>'observaciones']) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="row mtop16" id="detalles1">
			<div class="col-md-3">
                <button id="btnadddetsalcamara" class="btn btn-convertir btn-block"><i class="fas fa-plus"></i> Producto</button>
                {{-- @if ($trazabilidad) --}}
                @foreach ($salcamara->detsalcamaras as $det)
                @if ($det->id == $detsalcamara->id)
                <a class='btn btn-primary btn-block' href="{{ route('admin.salcamaras.edit',[$salcamara->id, $det->id]) }}">
                    {{ $det->dettrazabilidad->trazabilidad->nombre .' | '.$det->dettrazabilidad->codigo }}
                </a>
                @else
                <a class='btn btn-outline-primary btn-block' href="{{ route('admin.salcamaras.edit',[$salcamara->id, $det->id]) }}">
                    {{ $det->dettrazabilidad->trazabilidad->nombre .' | '.$det->dettrazabilidad->codigo }}
                </a>
                @endif
                @endforeach
            </div>
            <div class="col-md-9">
                <div class="panelprin shadow">
                    <div class="headercontent">
                        @if ($detsalcamara)
                        <h2 id="titulodetalle" class="title">
                            Producto: <strong>{{ $detsalcamara->dettrazabilidad->trazabilidad->nombre .' | '.$detsalcamara->dettrazabilidad->codigo }}</strong>
                            @if ($detsalcamara->detdetsalcamaras->count() == 0)
                            {{-- <button type="button" class="btn ml-4" title="Editar" onclick="editTrazabilidad('{{ $detsalcamara->id }}');">
                                <i class="fas fa-edit"></i>
                            </button> --}}
                            <button type="button" class="btn" title="Eliminar" onclick="destroyDetSalCamara('{{ $detsalcamara->id }}');">
                                <i class="fas fa-trash-alt"></i>
                            </button>                                
                            @endif
                        </h2>
                        <ul>
                            <li>
                                <button type="button" id='agregar' class="btn btn-convertir mt-1">Agregar Detalle</button>
                            </li>
                            <li>
                                <button type="button" id='guardaDet' class="btn btn-convertir mt-1 oculto" datatoggle="tooltip" data-placement="top" title="Aceptar">
                                    <i class="fas fa-check"></i> Aceptar
                                </button>
                            </li>
                            <li>
                                <button type="button" id='descartaDet' class="btn btn-convertir mt-1 oculto" datatoggle="tooltip" data-placement="top" title="Descartar">
                                    <i class="fas fa-times"></i> Descartar
                                </button>
                            </li>
                        </ul>
                        @endif
                    </div>
                    <div class="inside">
                        <div class="oculto mb-3" id="formdetsalcamara">
                            {!! Form::open(['route'=>'admin.salcamaras.aedetsalcamara', 'id'=>'formdetsal']) !!}
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    {{-- {!! Form::hidden('idTrazabilidad', null, ['id'=> 'idTrazabilidad']) !!} --}}
                                    {!! Form::hidden('salcamara_id', $salcamara->id, ['id' => 'salcamara_id']) !!}
                                    {!! Form::hidden('tipoSalcamara', 1, ['id' => 'tipoSalcamara']) !!}
                                    @if ($detsalcamara)
                                    {!! Form::hidden('iddetsalcamara', $detsalcamara->id, ['id'=>'iddetsalcamara']) !!}
                                    @endif
                                    {!! Form::label('trazabilidad_id', 'Producto:') !!}
                                    {!! Form::select('trazabilidad_id',$trazabilidad,null,['class'=>'custom-select','placeholder'=>'']) !!}
                                </div>
                                <div class="col-md-4 form-group">
                                    {!! Form::label('dettrazabilidad_id', 'Clasificación:') !!}
                                    {!! Form::select('dettrazabilidad_id',[],null,['class'=>'custom-select','placeholder'=>'']) !!}
                                </div>
                                <div class="col-md-1">
                                    <button type="button" id='guardaDetSalcamara' class="btn btn-block btn-convertir mtop20" datatoggle="tooltip" data-placement="top" title="Aceptar">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" id='descartaDetSalcamara' class="btn btn-block btn-convertir mtop20" datatoggle="tooltip" data-placement="top" title="Descartar">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                        <div class="oculto mb-3" id="aedet">
                            {!! Form::open(['route'=>'admin.salcamaras.addeditdet', 'id'=>'formdet']) !!}
                            <div class="row">
                                <div class="col-md-5 form-group">
                                    @if ($detsalcamara)
                                    {!! Form::hidden('detsalcamara_id', $detsalcamara->id, ['id'=>'detsalcamara_id']) !!}
                                    @endif
                                    {!! Form::hidden('iddet', null, ['id'=> 'iddet']) !!}
                                    {!! Form::hidden('tipodet', 1, ['id' => 'tipodet']) !!}
                                    {!! Form::hidden('stock', null, ['id' => 'stock']) !!}
                                    {!! Form::hidden('lote', null, ['id' => 'lote']) !!}
                                    {!! Form::label('productoterminado_id', 'Lote Disponible:') !!}
                                    {!! Form::select('productoterminado_id',[],null,['class'=>'custom-select','id'=>'productoterminado_id','placeholder' => '']) !!}
                                </div>
                                <div class="col-md-2 form-group">
                                    {!! Form::label('cantidad', 'Cantidad:') !!}
                                    {!! Form::text('cantidad', null, ['class'=>'form-control numero','id'=>'cantidad','maxlength'=>'5','autocomplete'=>'off']) !!}
                                </div>
                                <div class="col-md-2 form-group">
                                    {!! Form::label('peso', 'Peso:') !!}
                                    {!! Form::text('peso', null, ['class'=>'form-control numero','maxlength'=>'5','autocomplete'=>'off']) !!}
                                </div>
                                <div class="col-md-2 form-group">
                                    {!! Form::label('total', 'Total:') !!}
                                    {!! Form::text('total', null, ['class'=>'form-control numero','maxlength'=>'5','autocomplete'=>'off']) !!}
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                        <div class="row" id="detalles">
                            <div class="col-md-12">
                                <div id="tdetitem">
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
        $('#btnadddetsalcamara').click(function(){
            $('#titulodetalle').hide();
            $('#aedet').hide();
            $('#agregar').hide();
            $('#detalles').hide();
            $('#formdetsalcamara').show();
            $('#tipoSalcamara').val(1);
        });

        veritems();

        $('#agregar').click(function(){
            $('#aedet').show();
            $('#guardaDet').show();
            $('#descartaDet').show();
            $('#formdetsalcamara').hide();
            $('#detalles').hide();
            $('#agregar').hide();
            $('#tipodet').val(1);
            $('#productoterminado_id').val(null);
            $('#stock').val(null);
            $('#cantidad').val(null);
            $('#peso').val(20);
            $('#total').val(null);
            $.get(url_global+"/admin/salcamaras/"+ $('#detsalcamara_id').val() +"/listdetalle/",function(response){
                $('#productoterminado_id').empty();
                for(i=0;i<response.length;i++){
                    $('#productoterminado_id').append("<option value='"+response[i].id+"'>"
                        + response[i].lote_saldo
                        + "</option>");
                }
                $('#productoterminado_id').val(null);
            });
        });

        $('#productoterminado_id').change(function(){
            $.get(url_global+"/admin/salcamaras/"+ this.value +"/productoterminado/",function(response){
                $('#stock').val(response.saldo);
                $('#lote').val(response.lote);
                $('#cantidad').val(response.saldo);
                $('#total').val(response.saldo * 20);
            });
        });

        $('#guardaDet').click(function(){
            $.ajax({
                url: "{{ route('admin.salcamaras.addeditdet') }}",
                type: "POST",
                async: true,
                data: $('#formdet').serialize(),
                success: function(respuesta){
                    $('#aedet').hide();
                    $('#guardaDet').hide();
                    $('#descartaDet').hide();
                    $('#agregar').show();
                    $('#formdetsalcamara').hide();
                    veritems();
                    $('#detalles').show();
                },
                error: function(error){
                    // console.log(error);
                    let html = 'Se encontraron los siguientes errores:';
                    html += "<ul>";
                    for (var i in error.responseJSON.errors) {
                        html += "<li>"+ error.responseJSON.errors[i] +"</li>";
                        console.log(error.responseJSON.errors[i])
                    }
                    html += "</ul>";
                    $('#contenido_error').html(html);
                    $('#mensaje_error').slideDown();
                    setTimeout(function(){ $('#mensaje_error').slideUp(); }, 3000);
                }
            });
        });

        $('#descartaDet').click(function(){
            $('#aedet').hide();
            $('#guardaDet').hide();
            $('#descartaDet').hide();
            $('#formdetsalcamara').hide();
            $('#agregar').show();
            $('#detalles').show();
        });

        $('#guardaDetSalcamara').click(function(){
            $.ajax({
                url: "{{ route('admin.salcamaras.aedetsalcamara') }}",
                type: "POST",
                async: true,
                data: $('#formdetsal').serialize(),
                success: function(respuesta){
                    veritems();
                    $('#aedet').hide();
                    $('#formdetsalcamara').hide();
                    $('#detalles').show();
                    $('#agregar').show();
                    $('#nombredet').val(null);
                    $('#titulodetalle').show();
                    location.reload();
                },
                error: function(error){
                    // console.log(error);
                    let html = 'Se encontraron los siguientes errores:';
                    html += "<ul>";
                    for (var i in error.responseJSON.errors) {
                        html += "<li>"+ error.responseJSON.errors[i] +"</li>";
                        console.log(error.responseJSON.errors[i])
                    }
                    html += "</ul>";
                    $('#contenido_error').html(html);
                    $('#mensaje_error').slideDown();
                    setTimeout(function(){ $('#mensaje_error').slideUp(); }, 3000);
                }
            });
            // var id = null;
            // if ($('#tipoSalcamara').val() == 1) {
            //     id = $('#id').val();
            // } else {
            //     id = $('#salcamara_id').val();
            // }
            // var det = {
            //     'tipo' : $('#tipoSalcamara').val(),
            //     'id' : id,
            //     'nombre' : $('#nombreTrazabilidad').val(),
            // };
			// var envio = JSON.stringify(det);
            // $.get(url_global+"/admin/pprocesos/"+envio+"/aetrazabilidad/",function(response){
            //     switch (response) {
            //         case '1':
            //             veritems();
            //             $('#aedet').hide();
            //             $('#formtrazabilidad').hide();
            //             $('#detalles').show();
            //             $('#agregar').show();
            //             $('#nombredet').val(null);
            //             $('#titulodetalle').show();
            //             location.reload();
            //             break;
            //     }
            // });            
            
        });

        $('#descartaDetSalcamara').click(function(){
            $('#aedet').hide();
            $('#formdetsalcamara').hide();
            $('#detalles').show();
            $('#agregar').show();
            $('#nombredet').val(null);
            $('#titulodetalle').show();
        });
        
        // $('#guardar').click(function(){
        //     $('.activo').prop('disabled',false);
        // });

        $('#numero').blur(function(){
            this.value = this.value.replace(/^(0+)/g,'');
        });

        $('#trazabilidad_id').change(function(){
            $.get(url_global+"/admin/pprocesos/"+this.value+"/listdetalle/",function(response){
                $('#dettrazabilidad_id').empty();
                for(i=0;i<response.length;i++){
                    $('#dettrazabilidad_id').append("<option value='"+response[i].id+"'>"
                        + response[i].mpd_codigo
                        + "</option>");
                }
                $('#dettrazabilidad_id').val(null);
            });
        });
   
        $('#cantidad').blur(function(){
            var cantidad = NaNToCero($('#cantidad').val());
            var peso = NaNToCero($('#peso').val());
            $('#total').val(Redondea(cantidad*peso,2))
        });

        $('#peso').blur(function(){
            var cantidad = NaNToCero($('#cantidad').val());
            var peso = NaNToCero($('#peso').val());
            $('#total').val(Redondea(cantidad*peso,2))
        });

    });

    function veritems(){
        if ($('#detsalcamara_id').val()) {
            $.get(url_global+"/admin/salcamaras/"+$('#detsalcamara_id').val()+"/tablaitem/",function(response){
                $('#tdetitem').empty();
                $('#tdetitem').html(response);
            });
        }
    }

    function editDetSalCamara(id) {
        $('#titulodetalle').hide();
        $('#aedet').hide();
        $('#agregar').hide();
        $('#detalles').hide();
        $('#formdetsalcamara').show();
        $('#tipoSalcamara').val(2);
        $.get(url_global+"/admin/salcamaras/"+id+"/detsalcamara/",function(response){
            $('#trazabilidad_id').val(response.trazabilidad_id);
            $('#dettrazabilidad_id').val(response.dettrazabilidad_id);
        });
    }

    // function edititem (id) {
    //     $('#aedet').show();
    //     $('#guardaDet').show();
    //     $('#descartaDet').show();
    //     $('#agregar').hide();
    //     $('#detalles').hide();
    //     $('#iddet').val(id);
    //     $('#tipodet').val(2);
        
    //     $.get(url_global+"/admin/pprocesos/"+id+"/dettrazabilidad/",function(response){
    //         $('#mpd_id').val(response.mpd_id);
    //         $('#calidad').val(response.calidad);
    //         $('#sobrepeso').val(response.sobrepeso);
    //         $('#envase').val(response.envase);
    //         $('#codigo').val(response.codigo);
    //         $('#peso').val(response.peso);
    //         $('#precio').val(response.precio);
    //     });
    // }

    function destroyDetSalCamara(id){
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
				$.get(url_global+"/admin/salcamaras/"+id+"/destroydetsalcamara/",function(response){
                    window.open(url_global+"/admin/salcamaras/edit/"+$('#id').val(), '_self');
				});
            }
        })
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
				$.get(url_global+"/admin/salcamaras/"+id+"/destroyitem/",function(response){
                    veritems();
                    Swal.fire({
                        icon:'success',
                        title:'Eliminado',
                        text:'Registro Eliminado'
                    });
                    // location.href = url_global+"/admin/pprocesos/edit/"+$('#id').val();
				}); 
            }
            })
	}

</script>
@endsection
@extends('admin.master')
@section('title','Parte de Producción')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.partes.index') }}"><i class="fas fa-industry"></i> Parte de Producción</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
                    {!! Form::model($parte,['route'=>['admin.partes.update',$parte],'method'=>'put']) !!}
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-industry"></i> Parte de Producción</h2>
                        <ul>
                            @if ($parte->estado == 1)
                            <li>
                                {!! Form::submit('Guardar', ['class'=>'btn btn-convertir mt-1']) !!}
                            </li>
                            @endif
                            @can('admin.partes.generar')
                            @if ($parte->estado == 1)
                            <li>
                                <a class="btn btn-convertir mt-1" href="{{ route('admin.partes.generar',$parte) }}">Generar</a>
                            </li>
                            <li>
                                <a class="btn btn-convertir mt-1" href="{{ route('admin.partes.finalizar',$parte) }}">Finalizar</a>
                            </li>
                            @else
                            <li>
                                <a class="btn btn-convertir mt-1" href="{{ route('admin.partes.abrir',$parte) }}">Abrir</a>
                            </li>
                            @endif
                            @endcan
                        </ul>
                    </div>
					<div class="inside">
						<div class="row">
							<div class="col-md-2 form-group">
                                {!! Form::hidden('id', null, ['id' => 'id']) !!}
                                {!! Form::label('lote', 'Lote:') !!}
                                {!! Form::select('lote',$lotes,null,['class'=>'custom-select']) !!}
                            </div>
							<div class="col-md-2 form-group">
                                {!! Form::label('recepcion', 'Fecha Recepción:') !!}
                                {!! Form::date('recepcion', null, ['class'=>'form-control']) !!}
                            </div>
							<div class="col-md-2 form-group">
                                {!! Form::label('congelacion', 'Fecha Congelación:') !!}
                                {!! Form::date('congelacion', null, ['class'=>'form-control']) !!}
                            </div>
							<div class="col-md-2 form-group">
                                {!! Form::label('empaque', 'Fecha Empaque:') !!}
                                {!! Form::date('empaque', null, ['class'=>'form-control']) !!}
                            </div>
							<div class="col-md-4">
								<div class="row">
									<div class="col-md-5 form-group">
										{!! Form::label('vencimiento', 'Fecha Vencimiento:') !!}
                                		{!! Form::date('vencimiento', null, ['class'=>'form-control']) !!}
									</div>
									<div class="col-md-7 form-group">
										{!! Form::label('trazabilidad', 'Código Trazabilidad:') !!}
										{!! Form::text('trazabilidad', null, ['class'=>'form-control mayuscula','maxlength'=>'20','autocomplete'=>'off']) !!}
									</div>
								</div>
							</div>
						</div>
						<div class="row">
                            <div class="col-md-2 form-group">
								{!! Form::label('produccion', 'Producción:') !!}
								{!! Form::select('produccion',[1 => 'Propia', 2 => 'Por Encargo'],null,['class'=>'custom-select']) !!}
							</div>
							<div class="col-md-3 form-group">
                                {!! Form::label('contrata_id', 'Mano de Obra:') !!}
                                {!! Form::select('contrata_id',$contratas,null,['class'=>'custom-select']) !!}
                            </div>
							<div class="col-md-1 form-group">
								{!! Form::label('hombres', 'Hombres:') !!}
								{!! Form::text('hombres', null, ['class'=>'form-control numero','maxlength'=>'4','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-1 form-group">
								{!! Form::label('mujeres', 'Mujeres:') !!}
								{!! Form::text('mujeres', null, ['class'=>'form-control numero','maxlength'=>'4','autocomplete'=>'off']) !!}
							</div>
							<div class="col-md-1 form-group">
								{!! Form::label('turno', 'Turno:') !!}
								{!! Form::select('turno',[1 => 'Dia', 2 => 'Noche'],null,['class'=>'custom-select']) !!}
							</div>
							<div class="col-md-2 form-group">
								{!! Form::label('descarte', 'Descarte Kg:') !!}
								{!! Form::text('descarte', null, ['class'=>'form-control decimal', 'autocomplete'=>'off']) !!}
							</div>
						</div>
						<div class="row">
                            <div class="col-md-12 form-group">
                                {!! Form::label('observaciones', 'Observaciones:') !!}
                                {!! Form::textarea('observaciones',null,['class'=>'form-control mayuscula', 'rows'=>'2']) !!}
                            </div>
                        </div>
                    </div>			
                    {!! Form::close() !!}
				</div>
			</div>
		</div>
        @if ($parte->detpartes->count() > 0)
        <div class="row mtop16">
            <div class="col-md-12">
                <div class="panelprin shadow">
                    <div class="inside">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th class="text-center" width="10%">MATERIA PRIMA</th>
                                            <th class="text-center" width="10%">ENVASADO</th>
                                            <th class="text-center" width="10%">SOBRE PESO</th>
                                            <th class="text-center" width="10%">RESIDUOS</th>
                                            <th class="text-center" width="10%">DESCARTE</th>
                                            <th class="text-center" width="10%">MERMA</th>
                                            {{-- @can('admin.partes.valorado')
                                            <th class="text-center" width="10%">MANO DE OBRA</th>                                                
                                            @endcan --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">{{ number_format($parte->materiaprima,2) }}</td>
                                            <td class="text-center">{{ number_format($parte->envasado,2) }}</td>
                                            <td class="text-center">{{ number_format($parte->sobrepeso,2) }}</td>
                                            <td class="text-center">{{ number_format($parte->residuos,2) }}</td>
                                            <td class="text-center">{{ number_format($parte->descarte,2) }}</td>
                                            <td class="text-center">{{ number_format($parte->merma,2) }}</td>
                                            {{-- @can('admin.partes.valorado')
                                            <td class="text-center">{{ number_format($parte->manoobra,2) }}</td>                                                
                                            @endcan --}}
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mtop16">
            <div class="col-md-12">
                <div class="panelprin shadow">
                    <div class="headercontent">
                        <h2 class="title"><i class="fas fa-industry"></i> Productos Envasados</h2>
                    </div>
                    <div class="inside">
                        <div class="oculto mb-3" id="aedet">
                            <div class="row" id="aedet">
                                <div class="col-md-6 form-group">
                                    {!! Form::hidden('idd', null, ['id'=> 'idd']) !!}
                                    {!! Form::hidden('tipo', 1, ['id' => 'tipo']) !!}
                                    {!! Form::label('nombredet', 'Nombre:') !!}
                                    {!! Form::text('nombredet', null, ['class'=>'form-control mayuscula','maxlength'=>'100','autocomplete'=>'off']) !!}
                                </div>
                                <div class="col-md-1 form-group">
                                    {!! Form::label('porcentaje', 'Porcentaje:') !!}
                                    {!! Form::text('porcentaje', null, ['class'=>'form-control decimal','maxlength'=>'5','autocomplete'=>'off']) !!}
                                </div>
                                <div class="col-md-1">
                                    <button type="button" id='add' class="btn btn-block btn-convertir mtop20" datatoggle="tooltip" data-placement="top" title="Aceptar">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" id='cancel' class="btn btn-block btn-convertir mtop20" datatoggle="tooltip" data-placement="top" title="Descartar">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
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
        <div class="row mtop16">
            <div class="col-md-12">
                <div class="panelprin shadow">
                    <div class="headercontent">
                        <h2 class="title"><i class="fas fa-industry"></i> Productos Terminados</h2>
                    </div>
                    <div class="inside">
                        <div class="row" id="detallescamara">
                            <div class="col-md-12">
                                <div id="tdetitemcamara">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mtop16">
            <div class="col-md-12">
                <div class="panelprin shadow">
                    <div class="headercontent">
                        <h2 class="title"><i class="fas fa-industry"></i> Consumos Almacén</h2>
                    </div>
                    <div class="inside">
                        <div class="row" id="detallesconsumo">
                            <div class="col-md-12">
                                <div id="tdetitemconsumo">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mtop16">
            <div class="col-md-12">
                <div class="panelprin shadow">
                    <div class="headercontent">
                        <h2 class="title"><i class="fas fa-industry"></i> Guías</h2>
                    </div>
                    <div class="inside">
                        <div class="row" id="detallesconsumo">
                            <div class="col-md-12">
                                <table class="table table-bordered table-sm">
                                    <tbody>
                                        <tr>
                                            <th width = '20%'>Planillas de Envasado</th>
                                            <td width = '70%'>{{ $parte->guias_envasado }}</td>
                                        </tr>
                                        <tr>
                                            <th width = '20%'>Planillas de Envasado Crudo</th>
                                            <td width = '70%'>{{ $parte->guias_envasado_crudo }}</td>
                                        </tr>
                                        <tr>
                                            <th width = '20%'>Guías de Ingreso a Cámaras</th>
                                            <td width = '70%'>{{ $parte->guias_camara }}</td>
                                        </tr>
                                        <tr>
                                            <th width = '20%'>Consumos de Almacén</th>
                                            <td width = '70%'>{{ $parte->guias_almacen }}</td>
                                        </tr>
                                        <tr>
                                            <th width = '20%'>Guías de Residuos Sólidos</th>
                                            <td width = '70%'>{{ $parte->guias_residuos }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @can('admin.partes.valorado')
        <div class="row mtop16">
            <div class="col-md-12">
                <div class="panelprin shadow">
                    <div class="inside">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th class="text-center" width="10%">COSTO MATERIA PRIMA</th>
                                            <th class="text-center" width="10%">COSTO CONTRATA</th>
                                            <th class="text-center" width="10%">COSTO PRODUCTOS</th>
                                            <th class="text-center" width="10%">VENTA RESIDUOS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">{{ number_format($parte->costomateriaprima,2) }}</td>
                                            <td class="text-center">{{ number_format($parte->manoobra,2) }}</td>
                                            <td class="text-center">{{ number_format($parte->costoproductos,2) }}</td>
                                            <td class="text-center">{{ number_format($parte->costoresiduos,2) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endcan
        
        @endif
	</div>
@endsection
{{-- @section('css')
    <link rel="stylesheet" href="{{ url('/static/css/admin.css?v='.time()) }}">
@stop --}}
@section('script')
<script>
    var url_global='{{url("/")}}';
    $(document).ready(function(){
        veritems();
        veritemscamara();
        veritemsconsumo();
        // $('#agregar').click(function(){
        //     $('#aedet').show();
        //     $('#detalles').hide();
        //     $('#idd').val($('#id').val());
        //     $('#tipo').val(1);
        // });

        // $('#add').click(function(){
        //     var det = {
		// 		'tipo' : $('#tipo').val(),
		// 		'id' : $('#idd').val(),
		// 		'nombre' : $('#nombredet').val(),
		// 		'porcentaje' : $('#porcentaje').val(),
		// 	};
		// 	var envio = JSON.stringify(det);
        //     $.get(url_global+"/admin/despieces/"+envio+"/aedet/",function(response){
        //         if (response == 1) {
        //             veritems();
        //             $('#aedet').hide();
        //             $('#detalles').show();
        //             $('#nombredet').val(null);
        //             $('#porcentaje').val(null);
        //         } else {
        //             Swal.fire(
        //                 'Falló',
        //                 'Ya se encuentra registrado',
        //                 'error'
        //                 );
        //         }
        //     });            
        // });

        // $('#cancel').click(function(){
        //     $('#aedet').hide();
        //     $('#detalles').show();
        //     $('#nombredet').val(null);
        //     $('#porcentaje').val(null);
        // });
    });

    function veritems(){
        $.get(url_global+"/admin/partes/"+$('#id').val()+"/tablaitem/",function(response){
            $('#tdetitem').empty();
            $('#tdetitem').html(response);
        });
    }

    function veritemscamara(){
        $.get(url_global+"/admin/partes/"+$('#id').val()+"/tablaitemcamara/",function(response){
            $('#tdetitemcamara').empty();
            $('#tdetitemcamara').html(response);
        });
    }

    function veritemsconsumo(){
        $.get(url_global+"/admin/partes/"+$('#id').val()+"/tablaitemconsumo/",function(response){
            $('#tdetitemconsumo').empty();
            $('#tdetitemconsumo').html(response);
        });
    }

    // function edititem (id) {
    //     $('#aedet').show();
    //     $('#detalles').hide();
    //     $('#idd').val(id);
    //     $('#tipo').val(2);
        
    //     $.get(url_global+"/admin/despieces/"+id+"/detdespiece/",function(response){
    //         $('#nombredet').val(response.nombre);
    //         $('#porcentaje').val(response.porcentaje);
    //     });
    // }

    // function destroyitem(id){
	// 	Swal.fire({
    //         title: 'Está Seguro de Eliminar el Registro?',
    //         text: "",
    //         icon: 'warning',
    //         showCancelButton: true,
    //         confirmButtonColor: '#3085d6',
    //         cancelButtonColor: '#d33',
    //         confirmButtonText: '¡Si, eliminar!',
    //         cancelButtonText: 'Cancelar'
    //         }).then((result) => {
    //         if (result.value) {
	// 			$.get(url_global+"/admin/despieces/"+id+"/destroyitem/",function(response){
    //                 veritems();
    //                 Swal.fire({
    //                     icon:'success',
    //                     title:'Eliminado',
    //                     text:'Registro Eliminado'
    //                 });
	// 			});                
    //         }
    //     })
	// }
</script>
@endsection
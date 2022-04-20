{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Caja y Bancos')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.tesorerias.index') }}"><i class="fas fa-funnel-dollar"></i> Caja y Bancos</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					<div class="inside">
						{{-- {!! Form::open(['url'=>'/admin/categoria/add/'.$module]) !!} --}}
						{!! Form::model($tesoreria,['route'=>['admin.tesorerias.update',$tesoreria],'method'=>'put']) !!}
						<div class="row">
                            <div class="col-md-2 form-group">
                                {!! Form::label('cuenta_id', 'Cuenta:') !!}
                                {!! Form::select('cuenta_id',$cuentas,null,['class'=>'custom-select']) !!}
                                {!! Form::hidden('moneda', $tesoreria->cuenta->moneda,['id' =>'moneda']) !!}
                            </div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('tipo', 'Tipo:') !!}
                                {!! Form::select('tipo',[1=>'ABONO',2=>'CARGO'],null,['class'=>'custom-select']) !!}
                            </div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('fecha', 'Fecha:') !!}
                                {!! Form::date('fecha', null, ['class'=>'form-control activo']) !!}
                            </div>
                            <div class="col-md-1 form-group">
                                {!! Form::label('tc', 'TC:') !!}
                                {!! Form::text('tc', null, ['class'=>'form-control decimal activo','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-3 form-group">
                                {!! Form::label('mediopago', 'Medio Pago:') !!}
                                {!! Form::select('mediopago',$mediopago,null,['class'=>'custom-select activo','placeholder'=>'']) !!}
                            </div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('numerooperacion', 'N° Operación:') !!}
                                {!! Form::text('numerooperacion', null, ['class'=>'form-control activo','maxlength'=>'15','autocomplete'=>'off']) !!}
                            </div>
						</div>
                        <div class="row">
                            <div class="col-md-2 form-group">
                                {!! Form::label('notaegreso', 'Nota Egreso:') !!}
                                {!! Form::text('notaegreso', null, ['class'=>'form-control activo','maxlength'=>'10','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-7 form-group">
                                {!! Form::label('glosa', 'Glosa:') !!}
                                {!! Form::text('glosa', null, ['class'=>'form-control activo','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('monto', 'Monto:') !!}
                                {!! Form::text('monto', null, ['class'=>'form-control activo','autocomplete'=>'off','disabled']) !!}
                            </div>
                            <div class="col-md-1">
                                {!! Form::submit('Guardar', ['class'=>'btn btn-convertir mtop20']) !!}
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
                        <div class="text-left mb-1">
                            {!! Form::open(['route'=>['admin.tesorerias.detstore',$tesoreria]]) !!}
                            <div class="row">
                                <div class="col-md-1">
                                    {!! Form::label('detraccion', 'Detracción:') !!}
                                    {!! Form::select('detraccion',[1=>'SI',2=>'NO'],2,['class'=>'custom-select activo']) !!}
                                </div>
                                <div class="col-md-8">
                                    <div class="row">                                        
                                        <div class="col-md-6">
                                            {!! Form::label('cliente_id', $tesoreria->tipo==1?'Cliente':'Proveedor:') !!}
                                            {!! Form::select('cliente_id',[],null,['class'=>'custom-select','placeholder'=>'']) !!}
                                        </div>
                                        <div class="col-md-6">
                                            {!! Form::label('documento', 'Documento:') !!}
                                            {!! Form::select('documento',[],null,['class'=>'custom-select','placeholder'=>'']) !!}
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-3 form-group">
                                    <div class="row">
                                        <div class="col-md-5">
                                            {!! Form::hidden('monedaitem', null,['id'=>'monedaitem']) !!}
                                            {!! Form::hidden('montoitem', null,['id'=>'montoitem']) !!}
                                            {!! Form::label('montpen', 'Monto PEN:') !!}
                                            {!! Form::text('montpen', null, ['class'=>'form-control decimal activo','autocomplete'=>'off']) !!}
                                        </div>
                                        <div class="col-md-5">
                                            {!! Form::label('montusd', 'Monto USD:') !!}
                                            {!! Form::text('montusd', null, ['class'=>'form-control decimal activo','autocomplete'=>'off']) !!}
                                        </div>
                                        <div class="col-md-2">
                                            {!! Form::submit('+', ['class'=>'btn btn-convertir mtop20', 'id'=>'agregar']) !!}
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            {!! Form::close() !!}
                        </div>
                        <table class="table table-hover table-sm">
                            <thead>
								<tr>
									<th width="30%">Proveedor</th>
									<th width="5%">TD</th>
									<th width="10%">Número</th>
									<th class="text-right" width="15%">Monto PEN</th>
									<th class="text-right" width="15%">Monto USD</th>
									<th width="10%"></th>
								</tr>
							</thead>
                            <tbody>
								@foreach($tesoreria->dettesors as $det)
                                {{-- {{ dd($det) }} --}}
								<tr class="@if ($det->montousd < 0 || $det->montopen < 0) rojo @endif">
									<td>{{ $det->dettesorable->cliente->razsoc }}</td>
									<td>{{ $det->dettesorable->tipocomprobante_codigo }}</td>
									<td>{{ numDoc($det->dettesorable->serie,$det->dettesorable->numero) }}</td>
									<td class="text-right">{{ number_format(abs($det->montopen),2) }}</td>
									<td class="text-right">{{ number_format(abs($det->montousd),2) }}</td>
									<td class="text-center">
										<div class="opts">
                                            @can('admin.tesorerias.edit')
                                            <form action="{{ route('admin.tesorerias.detdestroy',$det) }}" method="POST" class="formulario_eliminars">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" datatoggle="tooltip" data-placement="top" title="Eliminar">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                            @endcan
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

@section('script')
<script>
    var url_global='{{url("/")}}';
    $(document).ready(function(){
        $('#cliente_id').select2({
            placeholder:"Ingrese 4 dígitos del RUC o Razón Social",
            minimumInputLength: 4,
            ajax:{
                url: "{{ route('admin.clientes.seleccionado') }}",
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

        $('#documento').select2({
            placeholder:"Fecha | Td | Número | Moneda | Saldo"
        });

        $('#agregar').click(function(){
            $('.activo').prop('disabled',false);
        });

        $('#cliente_id').on('select2:close',function(){
            var cliente = this.value;
            if ($('#tipo').val() == 1) {
                var busqueda = url_global+"/admin/rventas/"+cliente+"/pendiente/";
            } else {
                var busqueda = url_global+"/admin/rcompras/"+cliente+"/pendiente/";
            }
            // alert(cliente);
            $.get(busqueda,function(response){
                $('#documento').empty();
                for(i=0;i<response.length;i++){
                    $('#documento').append("<option value='"+response[i].id+"'>"
                        + response[i].fecha.substr(0,10)+' | '
                        + response[i].tipocomprobante_codigo+' | '
                        + numDoc(response[i].serie,response[i].numero)+' | '
                        + response[i].moneda+' | '
                        + response[i].saldo
                        + "</option>");
                }
                $('#documento').val(null);
                $('#montpen').val(null);
                $('#montusd').val(null);
            });
        });

        $('#documento').on('select2:close',function(){
            var data = $('#documento').select2('data');
            data.forEach(function (item) {
                var monedaitem = item.text.substr(busCadena(item.text,'|',3)+2,3);
                var montoitem = item.text.substr(busCadena(item.text,'|',4)+2);
                $('#monedaitem').val(monedaitem);
                $('#montoitem').val(montoitem);
                if(monedaitem = 'PEN'){
                    $('#montpen').val(montoitem);
                    $('#montusd').val(Redondea(montoitem/$('#tc').val(),2));
                }
                if($('#moneda').val() == monedaitem){
                    if(monedaitem == 'PEN'){
                        $('#montusd').prop('disabled',true);
                    }else{
                        $('#montpen').prop('disabled',true);
                    }
                }
            })
        });

        $('#montpen').blur(function(){
            $('#montusd').val(Redondea(this.value/$('#tc').val(),2));
            this.value = Redondea(this.value,2);
            $mmax = monedaitem == 'PEN' ? $('#montoitem').val() : Redondea($('#montoitem').val() * $('#tc').val(),2);
            // if()
        });

        $('#montusd').blur(function(){
            $('#montpen').val(Redondea(this.value*$('#tc').val(),2));
            this.value = Redondea(this.value,2);
        });

    });

</script>
@endsection
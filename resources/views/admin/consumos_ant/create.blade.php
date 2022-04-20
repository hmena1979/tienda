{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Registro de Ventas')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.rventas.index') }}"><i class="fas fa-cash-register"></i> Registro de Ventas</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
                {!! Form::open(['route'=>'admin.rventas.store']) !!}
				<div class="panelprin shadow">
                    <div class="headercontent">
						<h2 class="title"><i class="fas fa-cash-register"></i> Registro de Ventas</h2>
						<ul>
							{!! Form::submit('Guardar', ['class'=>'btn btn-convertir mt-2', 'id'=>'guardar']) !!}
						</ul>
					</div>
					<div class="inside">
                        {!! Form::hidden('empresa_id', session('empresa')) !!}
                        {!! Form::hidden('sede_id', session('sede')) !!}
                        {!! Form::hidden('mediopago', session('mediopago')) !!}
                        {!! Form::hidden('cuenta_id', session('cuenta')) !!}
                        <div class="row">
                            <div class="col-md-1 form-group">
                                {!! Form::label('periodo', 'Periodo:') !!}
								{!! Form::text('periodo', session('periodo'), ['class'=>'form-control activo','disabled']) !!}
							</div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('tipo', 'Operación:') !!}
								{!! Form::select('tipo',[1=>'VENTA',2=>'CONSUMO'],1,['class'=>'custom-select activo']) !!}
							</div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('fecha', 'Fecha:') !!}
                                {!! Form::date('fecha', Carbon\Carbon::now(), ['class'=>'form-control activo']) !!}
                            </div>
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        {!! Form::label('moneda', 'Moneda:') !!}
                                        {!! Form::select('moneda',$moneda,1,['class'=>'custom-select activo']) !!}
                                    </div>
                                    <div class="col-md-6 form-group">
                                        {!! Form::label('tc', 'TC:') !!}
                                        {!! Form::text('tc', null, ['class'=>'form-control decimal activo','autocomplete'=>'off']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                {!! Form::label('cliente_id', 'Cliente:') !!}
                                {!! Form::select('cliente_id',[],null,['class'=>'custom-select activo','id'=>'cliente_id','placeholder'=>'']) !!}
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
        let fecha = $('#fecha').val();
        $.get(url_global+"/admin/rcompras/"+fecha+"/bustc/",function(response){
            $('#tc').val(response['venta']);
        });
        $('#cliente_id').select2({
            placeholder:"Ingrese 4 dígitos del RUC o Razón Social",
            minimumInputLength: 4,
            ajax:{
                url: "{{ route('admin.clientes.seleccionado',2) }}",
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
        $('#tipo').change(function(){
            $('#cliente_id').select2({
                placeholder:"Ingrese 4 dígitos del RUC o Razón Social",
                minimumInputLength: 4,
                ajax:{
                    url: "{{ route('admin.clientes.seleccionado',2) }}",
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
            if(this.value == 1){
                $('#cliente_id').empty();
            }else{
                $('#cliente_id').empty();
                $('#cliente_id').append("<option value='2'>99999999-EMPRESA</option>");
                $('#cliente_id').val(2);
            }
        });

        
        $('#guardar').click(function(){
            $('.activo').prop('disabled',false);
        });

        $('#fecha').blur(function(){
            $.get(url_global+"/admin/rcompras/"+this.value+"/bustc/",function(response){
                $('#tc').val(response['venta']);
            });
        });

    });

</script>
@endsection
{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Tranferencias Entre Cuentas')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.transferencias.index') }}"><i class="fas fa-money-bill-wave"></i> Tranferencias Entre Cuentas</a>
	</li>
@endsection

@section('contenido')
    <div id="mensaje_error" class="alert alert-danger" style="display:none;">
        <strong id="contenido_error"></strong>
    </div>
	<div class="container-fluid">
        <div class="col-md-12">
            {!! Form::model($transferencia,['route'=>['admin.transferencias.update',$transferencia], 'method'=>'put']) !!}
            <div class="panelprin shadow">
                <div class="headercontent">
                    <h2 class="title"><i class="fas fa-money-bill-wave"></i> Tranferencias Entre Cuentas</h2>
                    <ul>
                        <li>
                            {!! Form::submit('Guardar', ['class'=>'btn btn-convertir mt-2', 'id'=>'guardar']) !!}
                        </li>
                    </ul>
                </div>
                <div class="inside">
                    <div class="row">
                        <div class="col-md-1 form-group">
                            {!! Form::label('periodo', 'Periodo:') !!}
                            {!! Form::text('periodo', session('periodo'), ['class'=>'form-control activo','disabled']) !!}
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
                            {!! Form::select('mediopago',$mediopago,null,['class'=>'custom-select activo','placeholder'=>'Seleccione Medio de Pago']) !!}
                        </div>
                        <div class="col-md-5">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    {!! Form::label('cargo_id', 'Cuenta Cargo:') !!}
                                    {!! Form::select('cargo_id',$cuenta,null,['class'=>'custom-select activo','placeholder'=>'Seleccione Cuenta Cargo']) !!}
                                </div>
                                <div class="col-md-6 form-group">
                                    {!! Form::label('abono_id', 'Cuenta Abono:') !!}
                                    {!! Form::select('abono_id',$cuenta,null,['class'=>'custom-select activo','placeholder'=>'Seleccione Cuenta Abono']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">                            
                        <div class="col-md-2 form-group">
                            {!! Form::label('numerooperacion', 'N° Operación:') !!}
                            {!! Form::text('numerooperacion', null, ['class'=>'form-control activo','maxlength'=>'15','autocomplete'=>'off']) !!}
                        </div>
                        <div class="col-md-2 form-group">
                            {!! Form::label('montopen', 'Monto Soles:') !!}
                            {!! Form::text('montopen', null, ['class'=>'form-control decimal','autocomplete'=>'off']) !!}
                        </div>
                        <div class="col-md-2 form-group">
                            {!! Form::label('montousd', 'Monto Dolares:') !!}
                            {!! Form::text('montousd', null, ['class'=>'form-control decimal','autocomplete'=>'off']) !!}
                        </div>
                        <div class="col-md-6 form-group">
                            {!! Form::label('glosa', 'Glosa:') !!}
                            {!! Form::text('glosa', null, ['class'=>'form-control mayuscula','autocomplete'=>'off']) !!}
                        </div>
                    </div>
                </div>				
            </div>
            {!! Form::close() !!}
        </div>
	</div>
@endsection
@section('script')
<script>
    var url_global='{{url("/")}}';
    $(document).ready(function(){        
        $('#guardar').click(function(){
            $('.activo').prop('disabled',false);
        });

        $('#fecha').blur(function(){
            if($('#fpago').val() == 1){
                $('#vencimiento').val(null);
                $('#cancelacion').val(this.value);
            }else{
                var dias = $('#dias').val();
                $('#vencimiento').val(sumarDias(this.value,dias));
                $('#cancelacion').val(null);
            }
            $.get(url_global+"/admin/rcompras/"+this.value+"/bustc/",function(response){
                $('#tc').val(response['venta']);
            });
        });

        $('#montopen').blur(function(){
            if (!Empty($('#tc').val())) {
                $('#montousd').val(Redondea($('#montopen').val() / $('#tc').val(),2));
            }
        });

        $('#montousd').blur(function(){
            if (!Empty($('#tc').val())) {
                $('#montopen').val(Redondea($('#montousd').val() * $('#tc').val(),2));
            }
        });

    });

</script>
@endsection
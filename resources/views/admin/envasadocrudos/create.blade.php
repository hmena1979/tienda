{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Planilla de Envasado @if ($tipo == 2) Crudo @endif')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.envasadocrudos.index') }}"><i class="far fa-clipboard"></i> Planilla de Envasado @if ($tipo == 2) Crudo @endif</a>
	</li>
@endsection

@section('contenido')
    <div id="mensaje_error" class="alert alert-danger" style="display:none;">
        <strong id="contenido_error"></strong>
    </div>
	<div class="container-fluid">
		<div class="row"  id = 'agregarcomprobante'>
            <div class="col-md-12">
                {!! Form::open(['route'=>'admin.envasadocrudos.store']) !!}
				<div class="panelprin shadow">
                    <div class="headercontent">
						<h2 class="title">
                            <i class="far fa-clipboard"></i> 
                            Planilla de Envasado @if ($tipo == 2) Crudo @endif
                        </h2>
						<ul>
                            <li>
                                {!! Form::submit('Guardar', ['class'=>'btn btn-convertir mt-2', 'id'=>'guardar']) !!}
                            </li>
						</ul>
					</div>
                    {{-- {{ dd($comprobante) }} --}}
					<div class="inside">
                        {!! Form::hidden('empresa_id', session('empresa')) !!}
                        {!! Form::hidden('periodo', session('periodo')) !!}
                        {!! Form::hidden('tipo', $tipo) !!}
                        <div class="row">
                            <div class="col-md-2">
                                {!! Form::label('numero', 'Número:') !!}
                                {!! Form::text('numero', null, ['class'=>'form-control numero','maxlength'=>'6','autocomplete'=>'off']) !!}
                            </div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('fecha', 'Fecha:') !!}
                                {!! Form::date('fecha', Carbon\Carbon::now(), ['class'=>'form-control']) !!}
                            </div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('fproduccion', 'Fecha Producción:') !!}
                                {!! Form::date('fproduccion', Carbon\Carbon::now(), ['class'=>'form-control']) !!}
                            </div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('lote', 'Lote:') !!}
                                {!! Form::select('lote',$lotes,null,['class'=>'custom-select']) !!}
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-8 form-group">
                                        {!! Form::label('supervisor_id', 'Supervisor:') !!}
                                        {!! Form::select('supervisor_id',$supervisores,null,['class'=>'custom-select','placeholder'=>'']) !!}
                                    </div>
                                    <div class="col-md-4 form-group">
                                        {!! Form::label('turno', 'Turno:') !!}
                                        {!! Form::select('turno',[1 => 'Dia', 2 => 'Noche'],null,['class'=>'custom-select']) !!}
                                    </div>
                                </div>
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
	</div>
@endsection
@section('script')
<script>
    var url_global='{{url("/")}}';
    $(document).ready(function(){
        $('#numero').blur(function(){
            this.value = this.value.replace(/^(0+)/g,'');
        });

    });

</script>
@endsection
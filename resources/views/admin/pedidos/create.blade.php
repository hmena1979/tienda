{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Pedidos')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.pedidos.index') }}"><i class="fas fa-file-archive"></i> Pedidos</a>
	</li>
@endsection

@section('contenido')
    <div id="mensaje_error" class="alert alert-danger" style="display:none;">
        <strong id="contenido_error"></strong>
    </div>
	<div class="container-fluid">
		<div class="row"  id = 'agregarcomprobante'>
            <div class="col-md-12">
                {!! Form::open(['route'=>'admin.pedidos.store']) !!}
				<div class="panelprin shadow">
                    <div class="headercontent">
						<h2 class="title"><i class="fas fa-file-archive"></i> Pedidos</h2>
						<ul>
                            <li>
                                {!! Form::submit('Guardar', ['class'=>'btn btn-convertir mt-2', 'id'=>'guardar']) !!}
                            </li>
						</ul>
					</div>
                    {{-- {{ dd($comprobante) }} --}}
					<div class="inside">
                        {!! Form::hidden('empresa_id', session('empresa')) !!}
                        {!! Form::hidden('sede_id', session('sede')) !!}
                        {!! Form::hidden('periodo', session('periodo')) !!}
                        <div class="row">
                            <div class="col-md-2 form-group">
                                {!! Form::label('fecha', 'Fecha:') !!}
                                {!! Form::date('fecha', Carbon\Carbon::now(), ['class'=>'form-control activo']) !!}
                            </div>
                            <div class="col-md-3 form-group">
                                {!! Form::label('user_id', 'Solicita:') !!}
                                {!! Form::select('user_id',$users,null,['class'=>'custom-select activo','id'=>'user_id']) !!}
                            </div>
                            <div class="col-md-5">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        {!! Form::label('destino_id', 'Destino:') !!}
                                        {!! Form::select('destino_id',$destinos,null,['class'=>'custom-select','placeholder'=>'']) !!}
                                    </div>
                                    <div class="col-md-6 form-group">
                                        {!! Form::label('detdestino_id', 'Detalle:') !!}
                                        {!! Form::select('detdestino_id',[],null,['class'=>'custom-select','placeholder'=>'']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 form-group">
                                {!! Form::label('lote', 'Lote:') !!}
                                {!! Form::text('lote', null, ['class'=>'form-control mayuscula','autocomplete'=>'off']) !!}
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
{{-- @section('css')
    <link rel="stylesheet" href="{{ url('/static/css/admin.css?v='.time()) }}">
@stop --}}
{{-- @section('js')
    <script src="{{ url('/static/js/admin.js?v='.time()) }}"></script>
@stop --}}
@section('script')
<script>
    var url_global='{{url("/")}}';
    $(document).ready(function(){
        $('#guardar').click(function(){
            $('.activo').prop('disabled',false);
        });

        $('#destino_id').select2({
            placeholder:"DESTINO"
        });

        $('#destino_id').on('select2:close',function(){
            var destino = this.value;
            $.get(url_global+"/admin/destinos/"+destino+"/listdetalle/",function(response){
                $('#detdestino_id').empty();
                for(i=0;i<response.length;i++){
                    $('#detdestino_id').append("<option value='"+response[i].id+"'>"
                        + response[i].nombre
                        + "</option>");
                }
                $('#detdestino_id').val(null);
                $('#detdestino_id').select2({
                    placeholder:"DETALLE"
                });
            });
        });

        $('#detdestino_id').select2({
            placeholder:"DETALLE"
        });


    });

</script>
@endsection
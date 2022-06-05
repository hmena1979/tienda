@extends('admin.master')
@section('title','Regenera Saldo')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.saldos.gregenera') }}"><i class="fas fa-window-restore"></i> Regenera Saldo Productos</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
                {!! Form::open(['route'=>'admin.saldos.pregenera']) !!}
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-window-restore"></i> Regenera Saldo Productos</h2>
						<ul>
							<li>
                                {!! Form::submit('Regenera', ['class'=>'btn btn-convertir mt-1', 'id'=>'regenerar']) !!}
                            </li>
						</ul>
					</div>
					<div class="inside">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="lsinmargen" for="num_doc">Producto:</label>
                                <div class="row no-gutters">
                                    <div class="col-md-2">
                                        {!! Form::select('tipo',[1=>'Todos',2=>'Uno'],1,['class'=>'custom-select','id' => 'tipo']) !!}
                                    </div>
                                    <div class="col-md-10">
                                        {!! Form::select('producto_id',[],null,['class'=>'custom-select','id' => 'producto_id','placeholder'=>'','disabled']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1 form-group">
                                <label for="periodo">Periodo:</label>
                                {!! Form::text('periodo', session('periodo'), ['class'=>'form-control numero','maxlength'=>'6','autocomplete'=>'off']) !!}
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
	});

    $('#tipo').change(function(){
        if ($('#tipo').val() == 1) {
            $('#producto_id').prop('disabled',true);
        } else {
            $('#producto_id').prop('disabled',false);
        }
    });
</script>
@endsection
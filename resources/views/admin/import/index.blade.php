{{-- @extends('adminlte::page') --}}
@extends('admin.master')
@section('title','Importar - Carga inicial')
@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ url('/admin/umedidas') }}"><i class="fas fa-file-download"></i> Importar - Carga inicial</a>
	</li>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panelprin shadow">
					<div class="headercontent">
						<h2 class="title"><i class="fas fa-file-download"></i> Importar - Carga inicial</h2>
                        <ul>
							<li>
								<a class="btn btn-agregar mt-2" href="{{ route('admin.permisosfaltantes') }}">
									Agregar Permisos
								</a>
                            </li>
						</ul>
					</div>
					<div class="inside">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panelprin shadow">
                                    <div class="headercontent">
                                        <h2 class="title">Importar Categorías</h2>
                                    </div>
                                    <div class="inside">
                                        {!! Form::open(['url'=>'/admin/import/categoria', 'files' => true]) !!}
                                        {{-- @csrf --}}
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="archivo" class="">Archivo:</label>
                                                <div class="custom-file">
                                                    {!! Form::file('archivo', ['class'=>'custom-file-input','id'=>'customFile', 'accept'=>'.xlsx']) !!}
                                                    <label class="custom-file-label" for="customFile" data-browse="Buscar">Buscar archivo Categorias.xlsx</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                {!! Form::submit('Importar', ['class'=>'btn btn-convertir mtop25']) !!}

                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>				
                                </div>
                            </div>
                        </div>
                        <div class="row mtop16">
                            <div class="card w-100 ml-2">
                                <div class="card-header">
                                    <h2 class="title">Importar Categoría Producto</h2>
                                </div>
                                <div class="card-body">
                                    {!! Form::open(['url'=>'/admin/import/catproducto', 'files' => true]) !!}
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="archivo" class="">Archivo:</label>
                                                <div class="custom-file">
                                                    {!! Form::file('archivo', ['class'=>'custom-file-input','id'=>'customFile', 'accept'=>'.xlsx']) !!}
                                                    <label class="custom-file-label" for="customFile" data-browse="Buscar">Buscar archivo CatProducto.xlsx</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                {!! Form::submit('Importar', ['class'=>'btn btn-convertir mtop25']) !!}

                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                        <div class="row mtop16">
                            <div class="card w-100 ml-2">
                                <div class="card-header">
                                    <h2 class="title">Importar Unidad Medida</h2>
                                </div>
                                <div class="card-body">
                                    {!! Form::open(['url'=>'/admin/import/umedida', 'files' => true]) !!}
                                        {{-- @csrf --}}
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="archivo" class="">Archivo:</label>
                                                <div class="custom-file">
                                                    {!! Form::file('archivo', ['class'=>'custom-file-input','id'=>'customFile', 'accept'=>'.xlsx']) !!}
                                                    <label class="custom-file-label" for="customFile" data-browse="Buscar">Buscar archivo UMedida.xlsx</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                {!! Form::submit('Importar', ['class'=>'btn btn-convertir mtop25']) !!}

                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mtop16">
                            <div class="card w-100 ml-2">
                                <div class="card-header">
                                    <h2 class="title">Importar Tipos de Comprobantes</h2>
                                </div>
                                <div class="card-body">
                                    {!! Form::open(['url'=>'/admin/import/tipocomprobante', 'files' => true]) !!}
                                        {{-- @csrf --}}
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="archivo" class="">Archivo:</label>
                                                <div class="custom-file">
                                                    {!! Form::file('archivo', ['class'=>'custom-file-input','id'=>'customFile', 'accept'=>'.xlsx']) !!}
                                                    <label class="custom-file-label" for="customFile" data-browse="Buscar">Buscar archivo Comprobantes.xlsx</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                {!! Form::submit('Importar', ['class'=>'btn btn-convertir mtop25']) !!}

                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                        <div class="row mtop16">
                            <div class="card w-100 ml-2">
                                <div class="card-header">
                                    <h2 class="title">Importar Detracciones</h2>
                                </div>
                                <div class="card-body">
                                    {!! Form::open(['url'=>'/admin/import/detraccion', 'files' => true]) !!}
                                        {{-- @csrf --}}
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="archivo" class="">Archivo:</label>
                                                <div class="custom-file">
                                                    {!! Form::file('archivo', ['class'=>'custom-file-input','id'=>'customFile', 'accept'=>'.xlsx']) !!}
                                                    <label class="custom-file-label" for="customFile" data-browse="Buscar">Buscar archivo Detracciones.xlsx</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                {!! Form::submit('Importar', ['class'=>'btn btn-convertir mtop25']) !!}

                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                        <div class="row mtop16">
                            <div class="card w-100 ml-2">
                                <div class="card-header">
                                    <h2 class="title">Importar Afectaciones</h2>
                                </div>
                                <div class="card-body">
                                    {!! Form::open(['url'=>'/admin/import/afectacion', 'files' => true]) !!}
                                        {{-- @csrf --}}
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="archivo" class="">Archivo:</label>
                                                <div class="custom-file">
                                                    {!! Form::file('archivo', ['class'=>'custom-file-input','id'=>'customFile', 'accept'=>'.xlsx']) !!}
                                                    <label class="custom-file-label" for="customFile" data-browse="Buscar">Buscar archivo Afcetaciones.xlsx</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                {!! Form::submit('Importar', ['class'=>'btn btn-convertir mtop25']) !!}

                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                        <div class="row mtop16">
                            <div class="card w-100 ml-2">
                                <div class="card-header">
                                    <h2 class="title">Importar Departamento</h2>
                                </div>
                                <div class="card-body">
                                    {!! Form::open(['url'=>'/admin/import/departamento', 'files' => true]) !!}
                                        {{-- @csrf --}}
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="archivo" class="">Archivo:</label>
                                                <div class="custom-file">
                                                    {!! Form::file('archivo', ['class'=>'custom-file-input','id'=>'customFile', 'accept'=>'.xlsx']) !!}
                                                    <label class="custom-file-label" for="customFile" data-browse="Buscar">Buscar archivo Departamento.xlsx</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                {!! Form::submit('Importar', ['class'=>'btn btn-convertir mtop25']) !!}

                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                        <div class="row mtop16">
                            <div class="card w-100 ml-2">
                                <div class="card-header">
                                    <h2 class="title">Importar Provincia</h2>
                                </div>
                                <div class="card-body">
                                    {!! Form::open(['url'=>'/admin/import/provincia', 'files' => true]) !!}
                                        {{-- @csrf --}}
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="archivo" class="">Archivo:</label>
                                                <div class="custom-file">
                                                    {!! Form::file('archivo', ['class'=>'custom-file-input','id'=>'customFile', 'accept'=>'.xlsx']) !!}
                                                    <label class="custom-file-label" for="customFile" data-browse="Buscar">Buscar archivo Provincia.xlsx</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                {!! Form::submit('Importar', ['class'=>'btn btn-convertir mtop25']) !!}

                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                        <div class="row mtop16">
                            <div class="card w-100 ml-2">
                                <div class="card-header">
                                    <h2 class="title">Importar Ubigeo</h2>
                                </div>
                                <div class="card-body">
                                    {!! Form::open(['url'=>'/admin/import/ubigeo', 'files' => true]) !!}
                                        {{-- @csrf --}}
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="archivo" class="">Archivo:</label>
                                                <div class="custom-file">
                                                    {!! Form::file('archivo', ['class'=>'custom-file-input','id'=>'customFile', 'accept'=>'.xlsx']) !!}
                                                    <label class="custom-file-label" for="customFile" data-browse="Buscar">Buscar archivo Ubigeo.xlsx</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                {!! Form::submit('Importar', ['class'=>'btn btn-convertir mtop25']) !!}

                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                        <div class="row mtop16">
                            <div class="card w-100 ml-2">
                                <div class="card-header">
                                    <h2 class="title">Importar Transportistas</h2>
                                </div>
                                <div class="card-body">
                                    {!! Form::open(['url'=>'/admin/import/transportista', 'files' => true]) !!}
                                        {{-- @csrf --}}
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="archivo" class="">Archivo:</label>
                                                <div class="custom-file">
                                                    {!! Form::file('archivo', ['class'=>'custom-file-input','id'=>'customFile', 'accept'=>'.xlsx']) !!}
                                                    <label class="custom-file-label" for="customFile" data-browse="Buscar">Buscar archivo Transportista.xlsx</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                {!! Form::submit('Importar', ['class'=>'btn btn-convertir mtop25']) !!}

                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                        <div class="row mtop16">
                            <div class="card w-100 ml-2">
                                <div class="card-header">
                                    <h2 class="title">Importar Cámaras</h2>
                                </div>
                                <div class="card-body">
                                    {!! Form::open(['url'=>'/admin/import/camara', 'files' => true]) !!}
                                        {{-- @csrf --}}
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="archivo" class="">Archivo:</label>
                                                <div class="custom-file">
                                                    {!! Form::file('archivo', ['class'=>'custom-file-input','id'=>'customFile', 'accept'=>'.xlsx']) !!}
                                                    <label class="custom-file-label" for="customFile" data-browse="Buscar">Buscar archivo Camara.xlsx</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                {!! Form::submit('Importar', ['class'=>'btn btn-convertir mtop25']) !!}

                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                        <div class="row mtop16">
                            <div class="card w-100 ml-2">
                                <div class="card-header">
                                    <h2 class="title">Importar Empresas Acopiadoras</h2>
                                </div>
                                <div class="card-body">
                                    {!! Form::open(['url'=>'/admin/import/empacopiadora', 'files' => true]) !!}
                                        {{-- @csrf --}}
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="archivo" class="">Archivo:</label>
                                                <div class="custom-file">
                                                    {!! Form::file('archivo', ['class'=>'custom-file-input','id'=>'customFile', 'accept'=>'.xlsx']) !!}
                                                    <label class="custom-file-label" for="customFile" data-browse="Buscar">Buscar archivo Empacopiadora.xlsx</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                {!! Form::submit('Importar', ['class'=>'btn btn-convertir mtop25']) !!}

                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                        <div class="row mtop16">
                            <div class="card w-100 ml-2">
                                <div class="card-header">
                                    <h2 class="title">Importar Acopiadores</h2>
                                </div>
                                <div class="card-body">
                                    {!! Form::open(['url'=>'/admin/import/acopiador', 'files' => true]) !!}
                                        {{-- @csrf --}}
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="archivo" class="">Archivo:</label>
                                                <div class="custom-file">
                                                    {!! Form::file('archivo', ['class'=>'custom-file-input','id'=>'customFile', 'accept'=>'.xlsx']) !!}
                                                    <label class="custom-file-label" for="customFile" data-browse="Buscar">Buscar archivo Acopiador.xlsx</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                {!! Form::submit('Importar', ['class'=>'btn btn-convertir mtop25']) !!}

                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                        <div class="row mtop16">
                            <div class="card w-100 ml-2">
                                <div class="card-header">
                                    <h2 class="title">Importar Choferes</h2>
                                </div>
                                <div class="card-body">
                                    {!! Form::open(['url'=>'/admin/import/chofer', 'files' => true]) !!}
                                        {{-- @csrf --}}
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="archivo" class="">Archivo:</label>
                                                <div class="custom-file">
                                                    {!! Form::file('archivo', ['class'=>'custom-file-input','id'=>'customFile', 'accept'=>'.xlsx']) !!}
                                                    <label class="custom-file-label" for="customFile" data-browse="Buscar">Buscar archivo Chofer.xlsx</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                {!! Form::submit('Importar', ['class'=>'btn btn-convertir mtop25']) !!}

                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                        <div class="row mtop16">
                            <div class="card w-100 ml-2">
                                <div class="card-header">
                                    <h2 class="title">Importar Embarcaciones</h2>
                                </div>
                                <div class="card-body">
                                    {!! Form::open(['url'=>'/admin/import/embarcacion', 'files' => true]) !!}
                                        {{-- @csrf --}}
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="archivo" class="">Archivo:</label>
                                                <div class="custom-file">
                                                    {!! Form::file('archivo', ['class'=>'custom-file-input','id'=>'customFile', 'accept'=>'.xlsx']) !!}
                                                    <label class="custom-file-label" for="customFile" data-browse="Buscar">Buscar archivo Embarcaciones.xlsx</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                {!! Form::submit('Importar', ['class'=>'btn btn-convertir mtop25']) !!}

                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                        <div class="row mtop16">
                            <div class="card w-100 ml-2">
                                <div class="card-header">
                                    <h2 class="title">Importar Productos</h2>
                                </div>
                                <div class="card-body">
                                    {!! Form::open(['url'=>'/admin/import/producto', 'files' => true]) !!}
                                        {{-- @csrf --}}
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="archivo" class="">Archivo:</label>
                                                <div class="custom-file">
                                                    {!! Form::file('archivo', ['class'=>'custom-file-input','id'=>'customFile', 'accept'=>'.xlsx']) !!}
                                                    <label class="custom-file-label" for="customFile" data-browse="Buscar">Buscar archivo Producto.xlsx</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                {!! Form::submit('Importar', ['class'=>'btn btn-convertir mtop25']) !!}

                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                        <div class="row mtop16">
                            <div class="card w-100 ml-2">
                                <div class="card-header">
                                    <h2 class="title">Importar MPD</h2>
                                </div>
                                <div class="card-body">
                                    {!! Form::open(['url'=>'/admin/import/mpd', 'files' => true]) !!}
                                        {{-- @csrf --}}
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="archivo" class="">Archivo:</label>
                                                <div class="custom-file">
                                                    {!! Form::file('archivo', ['class'=>'custom-file-input','id'=>'customFile', 'accept'=>'.xlsx']) !!}
                                                    <label class="custom-file-label" for="customFile" data-browse="Buscar">Buscar archivo MPD.xlsx</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                {!! Form::submit('Importar', ['class'=>'btn btn-convertir mtop25']) !!}

                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                        {{-- <div class="row">
                            <div class="card w-100 ml-2">
                                <div class="card-header">
                                    <h2 class="title">Actualiza Tipo de Cuenta</h2>
                                </div>
                                <div class="card-body">
                                    <a class="btn btn-convertir" href="{{ route('admin.clientes.actualizacuenta') }}">
                                        Actualiza Tipo de Cuenta
                                    </a>
                                </div>
                            </div>
                        </div> --}}

                        {{-- <div class="row mtop16">
                            <div class="col-md-12">
                                <div class="panelprin shadow">
                                    <div class="headercontent">
                                        <h2 class="title">Importar Comprobantes</h2>
                                    </div>
                                    <div class="inside">
                                        {!! Form::open(['url'=>'/admin/import/comprobantes', 'files' => true]) !!}
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="archivo" class="">Archivo:</label>
                                                <div class="custom-file">
                                                    {!! Form::file('archivo', ['class'=>'custom-file-input','id'=>'customFile', 'accept'=>'.xlsx']) !!}
                                                    <label class="custom-file-label" for="customFile" data-browse="Buscar">Buscar archivo Comprantes.xlsx</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                {!! Form::submit('Importar', ['class'=>'btn btn-danger mtop30']) !!}
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>				
                                </div>
                            </div>
                        </div> --}}
                        {{-- <div class="row mtop16">
                            <div class="col-md-12">
                                <div class="panelprin shadow">
                                    <div class="headercontent">
                                        <h2 class="title">Importar Afectaciones</h2>
                                    </div>
                                    <div class="inside">
                                        {!! Form::open(['url'=>'/admin/import/afectacion', 'files' => true]) !!}
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="archivo" class="">Archivo:</label>
                                                <div class="custom-file">
                                                    {!! Form::file('archivo', ['class'=>'custom-file-input','id'=>'customFile', 'accept'=>'.xlsx']) !!}
                                                    <label class="custom-file-label" for="customFile" data-browse="Buscar">Buscar archivo Afectacion.xlsx</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                {!! Form::submit('Importar', ['class'=>'btn btn-danger mtop30']) !!}
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>				
                                </div>
                            </div>
                        </div> --}}
                        {{-- <div class="row mtop16">
                            <div class="col-md-12">
                                <div class="panelprin shadow">
                                    <div class="headercontent">
                                        <h2 class="title">Importar Tipos de NC / ND</h2>
                                    </div>
                                    <div class="inside">
                                        {!! Form::open(['url'=>'/admin/import/tiponota', 'files' => true]) !!}
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="archivo" class="">Archivo:</label>
                                                <div class="custom-file">
                                                    {!! Form::file('archivo', ['class'=>'custom-file-input','id'=>'customFile', 'accept'=>'.xlsx']) !!}
                                                    <label class="custom-file-label" for="customFile" data-browse="Buscar">Buscar archivo TipoNota.xlsx</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                {!! Form::submit('Importar', ['class'=>'btn btn-danger mtop30']) !!}
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>				
                                </div>
                            </div>
                        </div> --}}
                        {{-- <div class="row mtop16">
                            <div class="col-md-12">
                                <div class="panelprin shadow">
                                    <div class="headercontent">
                                        <h2 class="title">Importar Detracciones</h2>
                                    </div>
                                    <div class="inside">
                                        {!! Form::open(['url'=>'/admin/import/detraccion', 'files' => true]) !!}
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="archivo" class="">Archivo:</label>
                                                <div class="custom-file">
                                                    {!! Form::file('archivo', ['class'=>'custom-file-input','id'=>'customFile', 'accept'=>'.xlsx']) !!}
                                                    <label class="custom-file-label" for="customFile" data-browse="Buscar">Buscar archivo Detracciones.xlsx</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                {!! Form::submit('Importar', ['class'=>'btn btn-danger mtop30']) !!}
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>				
                                </div>
                            </div>
                        </div> --}}

                    </div>
				</div>
            </div>
            
        </div>
            
			
	</div>

@endsection
{{-- @section('css')
    <link rel="stylesheet" href="{{ url('/static/css/admin.css?v='.time()) }}">
@stop --}}
@extends('adminlte::page')

{{-- @section('title', 'Dashboard') --}}

{{-- @section('content_header')
    <h1>Dashboard</h1>
@stop --}}
@section('css')
@yield('style')
<link rel="stylesheet" href="{{ url('/static/css/admin.css?v='.time()) }}">
@notifyCss
@stop
@section('content')
    

{{-- Content Wrapper --}}
{{-- <div class="content-wrapper {{ config('adminlte.classes_content_wrapper') ?? '' }}"> --}}
    <div class="pageprin">
        <div class="container-fluid">
            <nav aria-lavel="breadcrumb shadow">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/admin') }}"><i class="fas fa-home"></i> Inicio</a>
                    </li>
                    @section('breadcrumb')
                    @show
                </ol>
            </nav>
        </div>
    </div>
        {{-- Mensaje de registro --}}
    @if(Session::has('message'))
    <div class="container">
        <div class="alert alert-{{ Session::get('typealert') }} alertmensaje" style="display:none;">
            {{ Session::get('message') }}
            @if ($errors->any())
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            @endif
            {{-- <script>
                $('.alertmensaje').slideDown();
                setTimeout(function(){ $('.alertmensaje').slideUp(); }, 10000);
            </script>                 --}}
        </div>
    </div>        
    @endif
    {{-- <div id="mensaje_error" class="alert alert-danger" style="display:none;">
        <strong id="contenido_error"></strong>
    </div> --}}
    {{-- Fin Mensaje de registro --}}
    @yield('contenido')
    {{-- @endsection --}}
    {{-- </div> --}}
    @stop
    
    @section('js')
    <script src="{{ url('/vendor/select2/js/i18n/es.js') }}"></script>
    <script src="{{ url('/static/js/admin.js?v='.time()) }}"></script>
    <x:notify-messages />

    {{-- @include('notify::components.notify') --}}
    @notifyJs
    <script>
        $(document).ready(function(){
            $('.alertmensaje').slideDown();
            setTimeout(function(){ $('.alertmensaje').slideUp(); }, 10000);
            
            $('#grid').DataTable({
                "paging":   true,
                "ordering": true,
                "info":     true,
                "language":{
                    "info": "_TOTAL_ Registros",
                    "search": "Buscar",
                    "paginate":{
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                    "lengthMenu": "Mostrar <select>"+
                                    "<option value='10'>10</option>"+
                                    "<option value='25'>25</option>"+
                                    "<option value='50'>50</option>"+
                                    "<option value='100'>100</option>"+
                                    "<option value='-1'>Todos</option>"+
                                    "</select> Registros",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "emptyTable": "No se encontraton coincidencias",
                    "zeroRecords": "No se encontraton coincidencias",
                    "infoEmpty": "",
                    "infoFiltered": ""
                }
            });

            // $('.formulario_eliminar').submit(function(e){
            //     e.preventDefault();
            //     Swal.fire({
            //     title: 'Está Seguro de Eliminar el Registro?',
            //     text: "",
            //     icon: 'warning',
            //     showCancelButton: true,
            //     confirmButtonColor: '#3085d6',
            //     cancelButtonColor: '#d33',
            //     confirmButtonText: '¡Si, eliminar!',
            //     cancelButtonText: 'Cancelar'
            //     }).then((result) => {
            //     if (result.value) {
            //         this.submit();
            //     }
            //     })
            // });

            $('.decimal').keypress(function(event){
                var regex = new RegExp("^[0-9.]+$");
                var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
                if(!regex.test(key)){
                    event.preventDefault();
                    return false;
                }
            });

            $('.numero').keypress(function(event){
                var regex = new RegExp("^[0-9]+$");
                var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
                if(!regex.test(key)){
                    event.preventDefault();
                    return false;
                }
            });

            $('.telefono').keypress(function(event){
                var regex = new RegExp("^[+0-9() -.]+$");
                var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
                if(!regex.test(key)){
                    event.preventDefault();
                    return false;
                }
            });

            $('.mayuscula').blur(function(){
                this.value = this.value.toUpperCase();
            });

            $('.ekg').keypress(function(event){
                var regex = new RegExp("^[0-9.+°-]+$");
                var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
                if(!regex.test(key)){
                    event.preventDefault();
                    return false;
                }
            });

            
        });
        
        $('.formulario_eliminars').submit(function(e){
            e.preventDefault();
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
                this.submit();
            }
            })
        });
    </script>
    @if(Session::has('destroy'))
    <script>
        Swal.fire(
            'Eliminado',
            '{{ Session::get("destroy") }}',
            'success'
            )
    </script>
    @endif

    @if(Session::has('store'))
    <script>
        Swal.fire(
            'Agregado',
            '{{ Session::get("store") }}',
            'success'
            )
    </script>
    @endif
    <div>
        
    </div>
    @if(Session::has('update'))
    <script>
        Swal.fire(
            'Actualizado',
            '{{ Session::get("update") }}',
            'success'
            )
    </script>
    @endif
    @yield('script')
@stop
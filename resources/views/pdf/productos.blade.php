<!DOCTYPE html>
<html>
	<head>
        <meta charset="utf-8">
        <title>Tienda</title>
        <link rel="stylesheet" href="{{ url('/static/css/report.css?v='.time()) }}">
	</head>
	<body>
        {{-- <div class="header">
            <p class="empresa">
                {{$empresa->razsoc}} <span class="page">Página: </span><br>
                <span class="fecha">Fecha: {{\Carbon\Carbon::now()->format('Y-m-d')}}</span>
            </p>
            <p class="titulo">
                REPORTE DE SALDOS<br>
                <span class="subtitulo">
                    PRODUCTOS
                </span>
            </p>
        </div> --}}
        <table class="cuadrosborde">
            <thead>
                <tr>
                    <td width="7%" class="text-left">
                        <img class="logo" src="{{ url('/static/images/logo.jpg') }}" alt="">
                    </td>
                    <td width="33%" class="text-left letra8 negrita">
                        {{ $empresa->razsoc }}
                    </td>
                    <td width="40%"></td>
                    <td width="20%" valign='top'  class="text-right letra8">
                        <span class="negrita">Fecha:</span>  {{ Carbon\Carbon::now()->format('Y-m-d') }}
                    </td>
                </tr>
            </thead>
        </table>
        <div class="text-center letra12 negrita">
            PRODUCTOS <br>
        </div>
        <br>
        @foreach ($tipoproductos as $tp)            
        <div class="letra9 negrita">TIPO DE PRODUCTO: {{ $tp->nombre }}</div>
        <div class="detalle">
            <table>
                <tbody>
                    <tr>
                        <td width='60%' class="negrita">NOMBRE</td>
                        <td width='20%' class="negrita">U.MEDIDA</td>
                        @can('admin.productos.stock')
                        <td width='10%' class="negrita">STOCK</td>                            
                        @endcan
                        @can('admin.productos.price')
                        <td width='10%' class="negrita">PRECIO</td>                            
                        @endcan
                    </tr>
                    @foreach ($tp->productos as $prod)
                    <tr>
                        <td>{{ $prod->nombre }}</td>
                        <td>{{ $prod->umedida->nombre }}</td>
                        @can('admin.productos.stock')
                        <td>{{ $prod->stock }}</td>                            
                        @endcan
                        @can('admin.productos.price')
                        <td>{{ $prod->precompra }}</td>                            
                        @endcan
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <br>
        @endforeach
	</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Pesquera</title>

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="routeName" content="{{ Route::currentRouteName() }}">

        <!-- Styles
        <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css"/>
        -->
        <link rel="stylesheet" href="{{ url('/static/css/invoice.css?v='.time()) }}">
</head>
<body>
    <div class="detalle">
        <table class="table-materia-prima">
            <thead>
                <tr>
                    <th class="text-center"><strong>Chofer</strong></th>
                    <th class="text-center"><strong>Empresa Transportista</strong></th>
                    <th class="text-center"><strong>Empresa Acopiadora</strong></th>
                    <th class="text-center"><strong>Acopiador</strong></th>
                    <th class="text-center"><strong>Marca</strong></th>
                    <th class="text-center"><strong>Placa</strong></th>
                    <th class="text-center"><strong>Lote</strong></th>
                    <th class="text-center"><strong>Cajas <br> Declaradas</strong></th>
                    <th class="text-center"><strong>Peso <br> Planta KG</strong></th>
                    <th class="text-center"><strong>Fecha <br> Partida</strong></th>
                    <th class="text-center"><strong>Fecha <br> Llegada</strong></th>
                    <th class="text-center"><strong>Ingreso <br> Planta</strong></th>
                    <th class="text-center"><strong>Hora <br> Descarga</strong></th>
                    <th class="text-center"><strong>Proveedor</strong></th>
                    <th class="text-center"><strong>Precio</strong></th>
                    <th class="text-center"><strong>Lugar</strong></th>
                    <th class="text-center"><strong>Tipo Producto</strong></th>
                    <th class="text-center"><strong>Destare KG</strong></th>
                    <th class="text-center"><strong>Observaciones</strong></th>
                </tr>
            </thead>
            <tbody>
                @foreach($materiaprimas as $materiaprima)
                <tr>
                    <td>{{ $materiaprima->chofer->nombre }}</td>
                    <td>{{ $materiaprima->transportista->nombre }}</td>
                    <td>{{ $materiaprima->empacopiadora->nombre }}</td>
                    <td>{{ $materiaprima->acopiador->nombre }}</td>
                    <td>{{ $materiaprima->camara->marca }}</td>
                    <td>{{ $materiaprima->camara->placa }}</td>
                    <td>{{ $materiaprima->lote }}</td>
                    <td>{{ $materiaprima->cajas }}</td>
                    <td>{{ $materiaprima->pplanta }}</td>
                    <td>{{ $materiaprima->fpartida }}</td>
                    <td>{{ $materiaprima->fllegada }}</td>
                    <td>{{ $materiaprima->ingplanta }}</td>
                    <td>{{ $materiaprima->hfin }}</td>
                    <td>{{ $materiaprima->cliente->razsoc }}</td>
                    <td>{{ $materiaprima->precio }}</td>
                    <td>{{ $materiaprima->lugar }}</td>
                    <td>{{ $materiaprima->producto->nombre }}</td>
                    <td>{{ $materiaprima->destare }}</td>
                    <td>{{ $materiaprima->observaciones }}</td>
                </tr>
                @endforeach
                </tbody>
        </table>

    </div>
</body>
</html>
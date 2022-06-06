<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Pesquera HL</h1>
    <br>
    <p>Tiene un requerimiento de materiales:</p>
    <br>
    <p><strong>Solicita: </strong>{{ Auth::user()->name }}.</p>
    <p><strong>Destino: </strong>{{ $pedido->detdestino->destino->nombre }}.</p>
    <p><strong>Detalle: </strong>{{ $pedido->detdestino->nombre }}.</p>
    <p><strong>Observaciones: </strong>{{ $pedido->observaciones }}.</p>
    <p><strong>PRODUCTOS:</strong></p>
    @foreach ($pedido->detpedidos as $det)
        - {{ number_format($det->cantidad,2) . ' '. $det->producto->umedida->nombre . ' ' . $det->producto->nombre }} <br>
    @endforeach

    <br>
    Atentamente,
    <br>
    {{ Auth::user()->name }}
</body>
</html>
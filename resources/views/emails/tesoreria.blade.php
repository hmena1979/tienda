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
    <p>Tiene un Pago masivo por Aprobar en Banca por Internet:</p>
    <br>
    <p><strong>Glosa: </strong>{{ $masivo->glosa }}.</p>
    <p><strong>Banco: </strong>{{ $masivo->cuenta->banco->nombre }}.</p>
    <p><strong>Moneda: </strong>{{ $masivo->cuenta->moneda=='PEN'?'SOLES':'DÓLARES AMERICANOS' }}.</p>
    <p><strong>Monto: </strong>{{ number_format($masivo->monto,2) }}</p>
    <br>
    Atentamente,
    <br>
    {{ Auth::user()->name }}
</body>
</html>
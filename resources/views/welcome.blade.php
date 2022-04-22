<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Pesquera</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ url('/static/css/inicio.css?v='.time()) }}">

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body>
        <div class="contenedor">
            
            <div class="acceso">
                @auth
                    <a href="{{ url('/admin') }}" class="acceso__btn">Inicio</a>
                @else
                    <a href="{{ route('login') }}" class="acceso__btn">Ingreso</a>
                @endauth
            </div>
            <div class="logo">
                <img class="logo__img" src="{{ url('/static/images/logo.png') }}" alt="">
            </div>
            
        </div>
    </body>
</html>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">     
	<link rel="stylesheet" href="{{ url('/static/css/connect.css?v='.time()) }}">
    
</head>
<body>

	@section('content')
	@show
    
    <script src="{{ url('/js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ url('/js/all.js') }}"></script>

    @if(Session::has('message'))
        <div class="container">
            <div class="alert alert-{{ Session::get('typealert') }}" style="display:none;">
                {{ Session::get('message') }}
                @if ($errors->any())
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
                <script>
                    $('.alert').slideDown();
                    setTimeout(function(){ $('.alert').slideUp(); }, 10000);
                </script>                
            </div>
        </div>
        
    @endif

</body>
</html>

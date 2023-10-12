<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div id="app">
        @include('layouts.header')
        <main class="">
            {{-- @include('layouts.navbar') --}}
            @yield('content')
        </main>
    </div>
    <script>
        @if ($errors = session('errors'))
            @if (is_object($errors))
                @foreach ($errors->all() as $error)
                    alert('{{ $error }}', 'Error!' );
                @endforeach
            @else
                alert('{{ session('errors') }}', 'Error!');
            @endif
        @endif
        @if(Session::has('success'))
            alert("{{ session('success') }}");
        @endif
    </script>
</body>
</html>

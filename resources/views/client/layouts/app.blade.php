<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'My Web')</title>
    {{-- Vite --}}
    @vite(['resources/css/client.css', 'resources/js/client.js', 'resources/js/cart.js'])
</head>

<body>
    {{-- ================ HEADER TOP ================ --}}
    @include('client._partials.header')

    {{-- ================ navbar ================ --}}
    @include('client._partials.navbar')

    {{-- ================ CONTENT ================ --}}
    <main class="container mt-3">
        @yield('content')
    </main>
    {{-- ================ FOOTER ================ --}}
    @include('client._partials.footer')

</body>

</html>
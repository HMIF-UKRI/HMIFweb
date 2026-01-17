<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{ $meta ?? '' }}
    @stack('styles')
</head>

<body class="antialiased bg-dark font-poppins text-white">
    <main>
        {{ $slot }}
    </main>

    @stack('script')
    <script src="https://kit.fontawesome.com/a9ea8e1647.js" crossorigin="anonymous"></script>
</body>

</html>

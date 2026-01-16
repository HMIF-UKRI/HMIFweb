<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-p scroll-pt-20">

<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{ $meta ?? '' }}
    @stack('styles')
</head>

<body class="bg-dark font-poppins text-white">
    <x-navbar />

    @isset($header)
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endisset

    <main>
        {{ $slot }}
    </main>

    <x-footer />

    <script src="{{ asset('js/app.js') }}"></script>

    @stack('script')
    <script src="https://kit.fontawesome.com/a9ea8e1647.js" crossorigin="anonymous"></script>
</body>

</html>

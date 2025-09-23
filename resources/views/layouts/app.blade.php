<!DOCTYPE html>
<html lang="id">
    <head>
        @yield("meta")

        @vite(["resources/css/app.css", "resources/js/app.js"])
        @stack("styles")
    </head>
    <body class="bg-dark font-poppins text-white">
        <!-- Navbar -->
        @include("partials.navbar")

        <!-- Content -->
        <main>
            @yield("content")
        </main>

        <!-- Footer -->
        @include("partials.footer")

        <script src="{{ asset("js/app.js") }}"></script>

        @stack("script")
    </body>
</html>

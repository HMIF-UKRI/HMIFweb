<!DOCTYPE html>
<html lang="id" class="scroll-p scroll-pt-20">
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
        <script
            src="https://kit.fontawesome.com/a9ea8e1647.js"
            crossorigin="anonymous"
        ></script>
    </body>
</html>

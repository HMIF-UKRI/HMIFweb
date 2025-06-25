<!DOCTYPE html>
<html lang="id">
    <head>
        @yield("meta")

        @vite(["resources/css/app.css", "resources/js/app.js"])
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
            body {
                font-family: 'Poppins', sans-serif;
            }
        </style>
    </head>
    <body class="bg-secondary text-white">
        <!-- Navbar -->
        @include("partials.navbar")

        <!-- Content -->
        <main>
            @yield("content")
        </main>

        <!-- Footer -->
        @include("partials.footer")

        <script src="{{ asset("js/app.js") }}"></script>
    </body>
</html>

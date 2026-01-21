<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | HMIF Insight</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700;900&display=swap" rel="stylesheet">
</head>

<body class="bg-gray-950 font-poppins text-white overflow-hidden">
    <div class="relative min-h-screen w-full flex items-center justify-center px-6">

        <div class="pointer-events-none fixed inset-0 z-0 opacity-[0.03]"
            style="background-image: url('https://grainy-gradients.vercel.app/noise.svg');"></div>

        <div class="absolute -top-24 -left-24 h-125 w-125 rounded-full bg-red-900/20 blur-[120px]"></div>
        <div class="absolute -bottom-24 -right-24 h-125 w-125 rounded-full bg-red-600/10 blur-[120px]"></div>

        <div class="relative z-10 text-center">
            <h1 class="text-[12rem] font-black leading-none tracking-tighter text-white/5 md:text-[20rem] select-none">
                @yield('code')
            </h1>

            <div class="absolute inset-0 flex flex-col items-center justify-center mt-20">
                <h2 class="text-2xl font-bold uppercase tracking-[0.3em] text-red-600 mb-2 md:text-4xl">
                    @yield('message')
                </h2>
                <p class="max-w-md text-sm text-gray-500 font-medium mb-10 px-4">
                    @yield('description')
                </p>

                <a href="{{ url('/') }}"
                    class="group relative inline-flex items-center gap-3 overflow-hidden rounded-2xl bg-white/5 border border-white/10 px-8 py-4 text-xs font-black uppercase tracking-widest text-white transition-all hover:bg-red-600 hover:border-red-600 active:scale-95">
                    <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Home
                </a>
            </div>
        </div>
    </div>
</body>

</html>

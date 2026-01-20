<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Josue Molina' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('Images/marcaX.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@latest/dist/full.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="color-body flex flex-col min-h-screen">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            AOS.init({
                duration: 1000,
                once: true,
                offset: 100,
                easing: 'ease-out-cubic'
            });
        });
    </script>
    <!-- Navbar -->
    <nav id="navbar"
        class="navbar font-begum fixed transition-all duration-500 ease-in-out bg-opacity-50 backdrop-blur-md text-white z-50 shadow-lg bg-gray-800/50">
        <div class="navbar-start">
            <!-- Menú móvil -->
            <div class="dropdown lg:hidden">
                <label tabindex="0" class="btn btn-ghost btn-circle">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </label>
                <ul tabindex="0"
                    class="dropdown-content menu menu-sm mt-3 z-[1] p-2 shadow bg-gray-800 rounded-box w-52">
                    <li><a wire:navigate href="/">Inicio</a></li>
                    <li><a href="/proyectos">Proyectos</a></li>
                    <li><a href="/contacto">Contacto</a></li>
                    <li><a href="/acerca">Acerca</a></li>
                </ul>
            </div>

            <!-- Logo - Visible siempre -->
            <a class="btn btn-ghost text-xl" wire:navigate href="/">
                <img src="{{ asset('Images/marcaX.png') }}" alt="Logo" width="40" class="d-inline-block align-text-top">
                Josue Molina
            </a>
        </div>

        <!-- Menú desktop - Oculto en móviles -->
        <div class="navbar-end hidden lg:flex gap-2">
            <a class="btn btn-ghost text-lg rounded-full hover:bg-white/10 hover:border-white/50 border border-transparent transition-all duration-300"
                wire:navigate href="/">Inicio</a>
            <a class="btn btn-ghost text-lg rounded-full hover:bg-white/10 hover:border-white/50 border border-transparent transition-all duration-300"
                href="/proyectos">Proyectos</a>
            <a class="btn btn-ghost text-lg rounded-full hover:bg-white/10 hover:border-white/50 border border-transparent transition-all duration-300"
                href="/contacto">Contacto</a>
            <a class="btn btn-ghost text-lg rounded-full hover:bg-white/10 hover:border-white/50 border border-transparent transition-all duration-300"
                href="/acerca">Acerca</a>
        </div>
    </nav>

    <!-- Contenido principal -->
    <main {{ $attributes->merge(['class' => 'min-h-screen']) }}>
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-black mt-5 bg-opacity-50 text-white text-center py-4 mt-auto">
        <div class="container mx-auto">
            <p class="text-sm font-begum">&copy; 2023 Josue Molina. Todos los derechos reservados.</p>
            <div class="mt-2">
                <a href="#" class="text-white hover:text-gray-300 mx-2"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="text-white hover:text-gray-300 mx-2"><i class="fab fa-twitter"></i></a>
                <a href="#" class="text-white hover:text-gray-300 mx-2"><i class="fab fa-linkedin-in"></i></a>
                <a href="#" class="text-white hover:text-gray-300 mx-2"><i class="fab fa-github"></i></a>
            </div>
        </div>
    </footer>
</body>

</html>
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
        const initAOS = () => {
            AOS.init({
                duration: 1000,
                once: true,
                offset: 100,
                easing: 'ease-out-cubic'
            });
        };

        document.addEventListener('DOMContentLoaded', initAOS);
        document.addEventListener('livewire:navigated', initAOS);
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

    <!-- WhatsApp Button -->
    <a href="https://wa.me/573005591129" target="_blank" 
       class="fixed bottom-6 right-6 z-50 group transition-all duration-300 hover:scale-110 hover:-translate-y-1">
        <!-- Glow efffect -->
        <div class="absolute inset-0 bg-teal-500 blur-xl opacity-30 group-hover:opacity-60 transition-opacity duration-300 rounded-full animate-pulse"></div>
        
        <!-- Button -->
        <div class="relative flex items-center justify-center w-14 h-14 bg-black/60 backdrop-blur-xl border border-white/10 rounded-full shadow-2xl overflow-hidden group-hover:border-teal-500/50 transition-colors">
            <!-- Gradient Overlay -->
            <div class="absolute inset-0 bg-gradient-to-tr from-emerald-500 to-teal-500 opacity-80 group-hover:opacity-100 transition-opacity duration-300"></div>
            
            <!-- Icon -->
            <svg class="w-8 h-8 text-white relative z-10" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.592 2.654-.696c1.001.54 1.973.911 3.03.911h.001c3.187 0 5.778-2.586 5.778-5.766.001-3.187-2.585-5.771-5.776-5.771zm5.289 8.271c-.196.548-1.155.885-1.579.885-.353 0-.616-.073-.863-.169-1.298-.445-2.28-1.536-2.909-2.316-.763-.966-1.127-1.748-1.178-2.361-.061-.75.281-1.428.84-1.929.13-.107.266-.143.415-.143.196 0 .378.01.503.045.163.045.266.116.353.313.338.749.529 1.171.556 1.242.045.108.062.241-.018.42-.08.179-.196.34-.339.492-.125.134-.259.205-.125.446.732 1.323 1.832 1.967 2.681 2.208.241.072.411.018.554-.125.179-.179.742-.867.929-1.153.151-.232.375-.205.616-.116.241.089 1.528.724 1.787.858.268.134.447.197.51.304.071.107.071.617-.126 1.161zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-1.78 0-3.48-.46-4.99-1.28l-5.01 1.28 1.4-4.84C2.55 13.9 2 11.99 2 12c0-5.52 4.48-10 10-10 5.52 0 10 4.48 10 10s-4.48 10-10 10z"/>
            </svg>
        </div>
    </a>

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
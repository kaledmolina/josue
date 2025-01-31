<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Josue Molina' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('Images/marcaX.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@latest/dist/full.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="color-body">
    <!-- Navbar -->
    <nav id="navbar" class="navbar font-begum fixed top-4 transition-all duration-500 ease-in-out bg-opacity-50 backdrop-blur-md text-white z-50 shadow-lg">
        <div class="navbar-start">
            <a class="btn btn-ghost text-xl" wire:navigate href="/">
                <img src="{{ asset('Images/marcaX.png') }}" alt="Logo" width="40" class="d-inline-block align-text-top">
                Josue Molina
            </a>
        </div>
        <div class="navbar-end">
            <a class="btn btn-ghost text-lg" wire:navigate href="/">Inicio</a>
            <a class="btn btn-ghost text-lg"  href="/proyectos">Proyectos</a>
            <a class="btn btn-ghost text-lg"  href="/contacto">Contacto</a>
            <a class="btn btn-ghost text-lg"  href="/acerca">Acerca</a>
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
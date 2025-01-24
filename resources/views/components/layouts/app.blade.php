<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Josue Molina' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@latest/dist/full.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="min-h-screen bg-cover bg-center flex flex-col" style="background-image: url('{{ asset('Images/FondoInicio.png') }}');">
        <!-- Navbar -->
        <nav id="navbar" class="navbar fixed top-4 left-4 right-4 rounded-lg transition-all duration-500 ease-in-out bg-opacity-50 backdrop-blur-md text-white z-50 shadow-lg">
            <div class="navbar-start ">
                <!-- Logo -->
                <a class="btn btn-ghost text-xl">
                    <img src="{{ asset('Images/marcaX.png') }}" alt="Logo" width="40" height="auto" class="d-inline-block align-text-top">
                    <!-- Nombre -->
                    Josue Molina
                </a>
            </div>
            <div class="navbar-end ">
                <a class="btn btn-ghost text-lg ">Home</a>
                <a class="btn btn-ghost text-lg ">Projects</a>
                <a class="btn btn-ghost text-lg ">Contact</a>
            </div>
        </nav>
        

        <!-- Contenido principal -->
        {{ $slot }}

        <!-- Footer -->
        <footer class="bg-black bg-opacity-50 text-white text-center py-4 mt-auto">
            <div class="container mx-auto">
                <p class="text-sm">&copy; 2023 Josue Molina. Todos los derechos reservados.</p>
                <div class="mt-2">
                    <a href="#" class="text-white hover:text-gray-300 mx-2"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-white hover:text-gray-300 mx-2"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-white hover:text-gray-300 mx-2"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" class="text-white hover:text-gray-300 mx-2"><i class="fab fa-github"></i></a>
                </div>
            </div>
        </footer>

        <!-- Script para el navbar -->
        <script>
            window.addEventListener('scroll', function () {
                var navbar = document.getElementById('navbar');
                if (window.scrollY > 10) {
                    navbar.classList.remove('top-4', 'left-4', 'right-4', 'rounded-lg');
                    navbar.classList.add('fixed', 'top-0', 'left-0', 'right-0', 'mt-0', 'mx-0', 'rounded-none', 'bg-opacity-90', 'shadow-lg');
                } else {
                    navbar.classList.remove('fixed', 'top-0', 'left-0', 'right-0', 'mt-0', 'mx-0', 'rounded-none', 'bg-opacity-90', 'shadow-lg');
                    navbar.classList.add('top-4', 'left-4', 'right-4', 'rounded-lg');
                }
            });
        </script>
    </div>
</body>
</html>
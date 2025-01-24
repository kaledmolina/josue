<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Josue Molina' }}</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('Images/marcaX.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@latest/dist/full.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>   
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="color-body">
    <div class="min-h-screen bg-cover bg-center flex flex-col" style="background-image: url('{{ asset('Images/ampli-final2.png') }}');">
        <!-- Navbar -->
        <nav id="navbar" class="navbar font-begum fixed top-4 transition-all duration-500 ease-in-out bg-opacity-50 backdrop-blur-md text-white z-50 shadow-lg">
            <div class="navbar-start">
                <!-- Logo -->
                <a class="btn btn-ghost text-xl">
                    <img src="{{ asset('Images/marcaX.png') }}" alt="Logo" width="40" height="auto" class="d-inline-block align-text-top">
                    <!-- Nombre -->
                    Josue Molina
                </a>
            </div>
            <div class="navbar-end">
                <a class="btn btn-ghost text-lg">Home</a>
                <a class="btn btn-ghost text-lg">Projects</a>
                <a class="btn btn-ghost text-lg">Contact</a>
            </div>
        </nav>
        <!-- Texto en la esquina inferior derecha -->
        <div class="absolute bottom-10 right-4 text-white max-w-xs bg-black bg-opacity-50 p-4 rounded-lg">
            <p class="text-lg font-begum ">Cineasta y creador de contenido apasionado, dedicado a capturar historias reales con un estilo cinematográfico único que refleja su visión auténtica del mundo.</p>
        </div>
    </div>

    <!-- Contenido principal -->
    <section class="min-h-screen flex flex-col items-center justify-center  py-12">
        <h2 class="text-4xl font-bold text-white font-begum mb-8">Proyectos</h2>
        <div class="flex w-full flex-col lg:flex-row max-w-7xl mx-4 lg:mx-8">
            <!-- Primer card con contenido del hero -->
            <div class="card bg-base-300 rounded-box grid h-96 flex-grow place-items-center relative overflow-hidden mx-4 lg:mx-8">
                <div class="hero w-full h-full">
                    <img src="https://img.daisyui.com/images/stock/photo-1507358522600-9f71e620c44e.webp" 
                         alt="Fotografía" 
                         class="hero-image w-full h-full object-cover">
                    <div class="hero-content text-neutral-content text-center absolute inset-0 flex items-center justify-center">
                        <div class="max-w-md">
                            <h1 class="mb-5 text-5xl font-begum font-bold">Fotografía</h1>
                            <p class="mb-5 font-begum ">
                                Explora mis trabajos de fotografía, capturando momentos únicos con un estilo cinematográfico.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Divider -->
            <div class="divider bg-base-100 lg:divider-horizontal"></div>

            <!-- Segundo card con contenido del hero -->
            <div class="card bg-base-300 rounded-box grid h-96 flex-grow place-items-center relative overflow-hidden mx-4 lg:mx-8">
                <div class="hero w-full h-full">
                    <img src="https://img.daisyui.com/images/stock/photo-1507358522600-9f71e620c44e.webp" 
                         alt="Videos" 
                         class="hero-image w-full h-full object-cover">
                    <div class="hero-content text-neutral-content text-center absolute inset-0 flex items-center justify-center">
                        <div class="max-w-md">
                            <h1 class="mb-5 text-5xl font-begum  font-bold">Videos</h1>
                            <p class="mb-5 font-begum ">
                                Descubre mis proyectos de video, donde cada historia cobra vida con un enfoque creativo y profesional.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-black mt-5 bg-opacity-50 text-white text-center py-4 mt-auto">
        <div class="container mx-auto">
            <p class="text-sm font-begum ">&copy; 2023 Josue Molina. Todos los derechos reservados.</p>
            <div class="mt-2">
                <a href="#" class="text-white hover:text-gray-300 mx-2"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="text-white hover:text-gray-300 mx-2"><i class="fab fa-twitter"></i></a>
                <a href="#" class="text-white hover:text-gray-300 mx-2"><i class="fab fa-linkedin-in"></i></a>
                <a href="#" class="text-white hover:text-gray-300 mx-2"><i class="fab fa-github"></i></a>
            </div>
        </div>
    </footer>

    <!-- Script para el navbar -->
    
</body>
</html>
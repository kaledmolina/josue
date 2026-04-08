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

<body class="color-body flex flex-col min-h-screen font-dearest">
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
    <!-- Navbar -->
    <nav id="navbar"
        class="navbar font-dearest fixed top-0 w-full z-50 transition-all duration-500 py-6">
        <div class="container mx-auto px-4 md:px-8 flex items-center justify-between">
            <!-- Logo area -->
            <div class="flex-shrink-0">
                <a class="group flex items-center gap-3 px-2 py-1 rounded-lg transition-all hover:bg-white/5"
                    wire:navigate href="/">
                    <img src="{{ asset('Images/marcaX.png') }}" alt="Logo"
                        class="h-9 w-auto opacity-90 transition-transform group-hover:scale-110 duration-500">
                    <span
                        class="text-2xl tracking-[0.2em] text-white font-bold uppercase transition-all duration-500">Josué
                        Molina</span>
                </a>
            </div>

            <div class="hidden lg:flex items-center bg-black/60 backdrop-blur-2xl border border-white/10 rounded-full px-8 py-2 shadow-2xl">
                <ul class="flex items-center gap-3">
                    <li>
                        <a href="/" wire:navigate
                            class="px-4 py-2 rounded-full text-[13px] font-bold tracking-[0.15em] uppercase transition-all duration-300 {{ request()->routeIs('home') ? 'text-white' : 'text-gray-300 hover:text-white' }}">
                            Inicio
                        </a>
                    </li>
                    <li>
                        <a href="/proyectos"
                            class="px-4 py-2 rounded-full text-[13px] font-bold tracking-[0.15em] uppercase transition-all duration-300 {{ request()->is('proyectos*') ? 'text-white' : 'text-gray-300 hover:text-white' }}">
                            Proyectos
                        </a>
                    </li>
                    <li>
                        <a href="/fotografias"
                            class="px-4 py-2 rounded-full text-[13px] font-bold tracking-[0.15em] uppercase transition-all duration-300 {{ request()->is('fotografias*') || request()->is('album*') ? 'text-white' : 'text-gray-300 hover:text-white' }}">
                            Fotografía
                        </a>
                    </li>
                    <li>
                        <a href="/acerca"
                            class="px-4 py-2 rounded-full text-[13px] font-bold tracking-[0.15em] uppercase transition-all duration-300 {{ request()->is('acerca*') ? 'text-white' : 'text-gray-300 hover:text-white' }}">
                            Acerca
                        </a>
                    </li>
                    <li>
                        <a href="/contacto"
                            class="px-4 py-2 rounded-full text-[13px] font-bold tracking-[0.15em] uppercase transition-all duration-300 {{ request()->is('contacto*') ? 'text-white' : 'text-gray-300 hover:text-white' }}">
                            Contacto
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Mobile Menu Button -->
            <div class="navbar-end w-auto lg:hidden">
                <div class="dropdown dropdown-end">
                    <label tabindex="0" class="btn btn-ghost btn-circle text-white hover:bg-white/10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </label>
                    <ul tabindex="0"
                        class="menu dropdown-content mt-3 z-[1] p-2 shadow-2xl bg-black/95 backdrop-blur-xl border border-white/10 rounded-2xl w-64 right-0">
                        <li><a wire:navigate href="/"
                                class="{{ request()->routeIs('home') ? 'text-white bg-white/10' : 'text-gray-400' }}">Inicio</a>
                        </li>
                        <li><a href="/proyectos"
                                class="{{ request()->is('proyectos*') ? 'text-white bg-white/10' : 'text-gray-400' }}">Proyectos</a>
                        </li>
                        <li><a href="/fotografias"
                                class="{{ request()->is('fotografias*') ? 'text-white bg-white/10' : 'text-gray-400' }}">Fotografía</a>
                        </li>
                        <li><a href="/acerca"
                                class="{{ request()->is('acerca*') ? 'text-white bg-white/10' : 'text-gray-400' }}">Acerca</a>
                        </li>
                        <li><a href="/contacto"
                                class="{{ request()->is('contacto*') ? 'text-white bg-white/10' : 'text-gray-400' }}">Contacto</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <main {{ $attributes->merge(['class' => 'min-h-screen']) }}>
        {{ $slot }}
    </main>

    <!-- WhatsApp Button -->
    <a href="https://wa.me/573005591129" target="_blank"
        class="fixed bottom-6 right-6 z-50 group transition-all duration-300 hover:scale-110 hover:-translate-y-1">

        <!-- Button -->
        <div
            class="relative flex items-center justify-center w-14 h-14 bg-white rounded-full shadow-2xl hover:shadow-white/20 transition-all">
            <!-- Icon -->
            <svg class="w-8 h-8 text-black fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
            </svg>
        </div>
    </a>

    <!-- Footer -->
    <footer class="bg-black mt-5 bg-opacity-50 text-white text-center py-4 mt-auto">
        <div class="container mx-auto">
            <p class="text-sm font-dearest">&copy; 2023 Josue Molina. Todos los derechos reservados.</p>
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
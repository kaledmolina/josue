<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Josue Molina' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('Images/marcaX.png') }}">
    <link rel="preconnect" href="https://lh3.googleusercontent.com" crossorigin>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="color-body flex flex-col min-h-screen font-sans">
    <!-- Preloader de entrada (wire:ignore para que Livewire no lo reintroduzca al navegar) -->
    <div id="preloader" wire:ignore aria-hidden="true">
        <img src="{{ asset('Images/marcaX.png') }}" alt="" class="h-14 w-auto opacity-90">
        <div class="preloader-bar"></div>
    </div>

    <!-- Barra de progreso de scroll -->
    <div id="scroll-progress" aria-hidden="true"></div>

    <!-- Cursor personalizado (solo desktop) -->
    <div id="cursor-dot" aria-hidden="true"></div>
    <div id="cursor-ring" aria-hidden="true"></div>

    <!-- Spotlight que sigue al mouse -->
    <div id="spotlight" aria-hidden="true"></div>

    <!-- Fondo ambiental: partículas + iluminación (detrás del contenido, sin bloquear clicks) -->
    <div id="ambient-bg" class="fixed inset-0 z-[1] pointer-events-none overflow-hidden" aria-hidden="true">
        <canvas id="particles-canvas" class="absolute inset-0 w-full h-full"></canvas>
        <div class="glow glow-blue"></div>
        <div class="glow glow-gold"></div>
        <div class="glow glow-center"></div>
    </div>

    <!-- Navbar -->
    @php
        // Página actual para resaltar el enlace activo del menú.
        $navActive = [
            'home' => request()->routeIs('home'),
            'proyectos' => request()->is('proyectos*'),
            'fotografia' => request()->is('fotografias*') || request()->is('album*'),
            'acerca' => request()->is('acerca*'),
            'contacto' => request()->is('contacto*'),
        ];
    @endphp
    <nav id="navbar"
        class="navbar font-dearest fixed top-0 w-full z-50 transition-all duration-500 py-8">
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

            <div class="hidden lg:flex items-center bg-black/90 backdrop-blur-2xl border border-white/10 rounded-full px-12 py-4 shadow-2xl">
                <ul id="nav-menu" class="relative flex items-center gap-3">
                    <li id="nav-indicator" aria-hidden="true"></li>
                    @foreach([
                        ['href' => '/', 'label' => 'Inicio', 'active' => $navActive['home'], 'navigate' => true],
                        ['href' => '/proyectos', 'label' => 'Proyectos', 'active' => $navActive['proyectos'], 'navigate' => false],
                        ['href' => '/fotografias', 'label' => 'Fotografía', 'active' => $navActive['fotografia'], 'navigate' => false],
                        ['href' => '/acerca', 'label' => 'Acerca', 'active' => $navActive['acerca'], 'navigate' => false],
                        ['href' => '/contacto', 'label' => 'Contacto', 'active' => $navActive['contacto'], 'navigate' => false],
                    ] as $item)
                        <li>
                            <a href="{{ $item['href'] }}"
                                @if($item['navigate']) wire:navigate @endif
                                @class([
                                    'relative z-10 px-4 py-2 rounded-full text-[13px] font-bold tracking-[0.15em] uppercase transition-colors duration-300',
                                    'text-black' => $item['active'],
                                    'text-gray-300 hover:text-white' => ! $item['active'],
                                ])
                                @if($item['active']) aria-current="page" @endif>
                                {{ $item['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Mobile Menu: overlay fullscreen -->
            <div class="navbar-end w-auto lg:hidden" x-data="{ open: false }"
                x-effect="document.body.style.overflow = open ? 'hidden' : ''">
                <button @click="open = true" aria-label="Abrir menú"
                    class="btn btn-ghost btn-circle text-white hover:bg-white/10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <div x-show="open" x-cloak
                    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                    class="fixed inset-0 z-[90] bg-black/95 backdrop-blur-2xl flex flex-col items-center justify-center"
                    @keydown.escape.window="open = false">
                    <button @click="open = false" aria-label="Cerrar menú"
                        class="absolute top-6 right-6 text-white/70 hover:text-white p-2 rounded-full hover:bg-white/10 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <nav class="flex flex-col items-center gap-2 w-full px-8">
                        @foreach([
                            ['href' => '/', 'label' => 'Inicio', 'active' => $navActive['home'], 'navigate' => true],
                            ['href' => '/proyectos', 'label' => 'Proyectos', 'active' => $navActive['proyectos'], 'navigate' => false],
                            ['href' => '/fotografias', 'label' => 'Fotografía', 'active' => $navActive['fotografia'], 'navigate' => false],
                            ['href' => '/acerca', 'label' => 'Acerca', 'active' => $navActive['acerca'], 'navigate' => false],
                            ['href' => '/contacto', 'label' => 'Contacto', 'active' => $navActive['contacto'], 'navigate' => false],
                        ] as $item)
                            <a href="{{ $item['href'] }}" @if($item['navigate']) wire:navigate @endif
                                @click="open = false"
                                :class="open ? 'menu-item-in' : 'opacity-0'"
                                :style="open ? { animationDelay: ({{ $loop->index }} * 70 + 60) + 'ms' } : {}"
                                @class([
                                    'px-8 py-3 text-2xl font-bold tracking-[0.15em] uppercase rounded-full transition-colors',
                                    'bg-white text-black' => $item['active'],
                                    'text-gray-300 hover:text-white' => ! $item['active'],
                                ])
                                @if($item['active']) aria-current="page" @endif>
                                {{ $item['label'] }}
                            </a>
                        @endforeach
                    </nav>
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

    <!-- Botón volver arriba -->
    <button id="back-to-top" aria-label="Volver arriba">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
        </svg>
    </button>

    <!-- Footer -->
    <footer class="bg-black mt-5 bg-opacity-50 text-white text-center py-4 mt-auto">
        <div class="container mx-auto">
            <p class="text-sm">&copy; 2026 Josue Molina. Todos los derechos reservados.</p>
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
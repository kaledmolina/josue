@php
    // Marcador de imagen rota: un SVG oscuro con ícono de imagen.
    $placeholder = "data:image/svg+xml;charset=utf-8," . rawurlencode("<svg xmlns='http://www.w3.org/2000/svg' width='800' height='600' viewBox='0 0 800 600'><rect width='800' height='600' fill='#101318'/><g fill='none' stroke='#3f3f46' stroke-width='20' stroke-linecap='round'><circle cx='400' cy='250' r='70'/><path d='M230 440c20-100 140-130 330-60 110 40 180 10 210 60'/></g></svg>");
    $totalPhotos = count($albumData['photos']);
@endphp

<div class="min-h-screen pt-32 pb-20 px-4 md:px-8 bg-black text-white selection:bg-white selection:text-black">
    <div class="container mx-auto px-4 relative z-10">

        <!-- Navigation -->
        <div class="mb-10" data-aos="fade-right">
            <a href="{{ route('fotografias') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-white text-black font-bold hover:bg-gray-200 transition-all transform hover:scale-105 shadow-lg group">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform group-hover:-translate-x-1"
                    viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                        clip-rule="evenodd" />
                </svg>
                <span>Volver a Álbumes</span>
            </a>
        </div>

        <!-- Album Header -->
        <div class="flex flex-col md:flex-row items-end gap-8 mb-16 bg-white/5 border border-white/10 rounded-3xl p-8 backdrop-blur-md"
            data-aos="fade-up">
            <div class="relative w-full md:w-64 aspect-[4/3] rounded-2xl overflow-hidden shadow-2xl flex-shrink-0 group">
                <img src="{{ $albumData['cover'] }}" alt="Portada de {{ $albumData['title'] }}"
                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                    loading="lazy" onerror="this.onerror=null;this.src='{{ $placeholder }}'">
                <div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition-colors duration-500">
                </div>
            </div>

            <div class="flex-grow w-full">
                <h2 class="text-4xl md:text-5xl font-bold font-dearest mb-4 leading-tight">{{ $albumData['title'] }}</h2>
                <div class="flex flex-wrap items-center gap-4 text-gray-400">
                    <span class="inline-flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        {{ $albumData['date'] }}
                    </span>
                    <span class="w-1 h-1 bg-white/30 rounded-full"></span>
                    <p class="text-gray-200 font-dearest max-w-2xl">{{ $totalPhotos }} {{ $totalPhotos === 1 ? 'fotografía' : 'fotografías' }}</p>
                </div>
            </div>
        </div>

        <!-- Empty State -->
        @if($totalPhotos === 0)
            <div class="text-center py-24" data-aos="fade-up">
                <div
                    class="w-24 h-24 mx-auto mb-8 rounded-3xl bg-white/5 border border-white/10 flex items-center justify-center">
                    <svg class="w-12 h-12 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold font-dearest mb-3">Este álbum aún no tiene fotos</h3>
                <p class="text-gray-400 max-w-md mx-auto">Pronto se publicarán nuevas imágenes en este álbum. Vuelve a visitarlo más tarde.</p>
            </div>
        @endif

        <!-- Photo Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($albumData['photos'] as $index => $photo)
                <div class="relative group cursor-pointer aspect-[3/4] rounded-xl overflow-hidden bg-white/5 border border-white/10"
                    wire:key="photo-{{ $index }}" x-data="{ loaded: false }" data-aos="fade-up"
                    data-aos-delay="{{ ($index % 4) * 100 }}" wire:click="selectPhoto({{ $index }})">

                    <!-- Skeleton -->
                    <div x-show="!loaded"
                        class="absolute inset-0 bg-white/10 animate-pulse flex items-center justify-center">
                        <svg class="w-8 h-8 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>

                    <img src="{{ $photo['url'] }}" alt="{{ $photo['name'] ?? 'Foto del álbum' }}" @load="loaded = true"
                        class="w-full h-full object-cover transition-all duration-700 opacity-0 group-hover:scale-105"
                        :class="{ 'opacity-100': loaded }" loading="lazy"
                        onerror="this.onerror=null;this.src='{{ $placeholder }}'">

                    <!-- Hover Overlay -->
                    <div
                        class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                        <svg class="w-8 h-8 text-white scale-75 group-hover:scale-100 transition-transform duration-300"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                        </svg>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Full Screen Lightbox -->
        @if($selectedIndex !== null && isset($albumData['photos'][$selectedIndex]))
            @php $photo = $albumData['photos'][$selectedIndex]; @endphp
            <div class="fixed inset-0 z-[100] bg-black/95 backdrop-blur-xl flex items-center justify-center animate-fade-in"
                x-data x-on:keydown.window.escape.window.prevent="$wire.closePhoto()"
                x-on:keydown.window.arrow-right.window.prevent="$wire.nextPhoto()"
                x-on:keydown.window.arrow-left.window.prevent="$wire.prevPhoto()"
                @click.self="$wire.closePhoto()">

                <!-- Close -->
                <button
                    class="absolute top-6 right-6 z-10 text-white/50 hover:text-white transition-colors p-2 rounded-full hover:bg-white/10"
                    wire:click="closePhoto" aria-label="Cerrar">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" stroke="currentColor"
                        fill="none">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <!-- Prev -->
                @if($totalPhotos > 1)
                    <button
                        class="absolute left-4 md:left-10 top-1/2 -translate-y-1/2 z-10 text-white/50 hover:text-white transition-colors p-3 rounded-full hover:bg-white/10"
                        wire:click="prevPhoto" aria-label="Anterior">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>

                    <!-- Next -->
                    <button
                        class="absolute right-4 md:right-10 top-1/2 -translate-y-1/2 z-10 text-white/50 hover:text-white transition-colors p-3 rounded-full hover:bg-white/10"
                        wire:click="nextPhoto" aria-label="Siguiente">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                @endif

                <div class="relative max-w-7xl max-h-[90vh] p-4">
                    <img src="{{ $photo['url'] }}" alt="{{ $photo['name'] ?? 'Imagen en tamaño completo' }}"
                        class="max-w-full max-h-[80vh] object-contain rounded-lg shadow-2xl ring-1 ring-white/10"
                        onerror="this.onerror=null;this.src='{{ $placeholder }}'">

                    <!-- Footer info -->
                    <div class="flex items-center justify-between mt-5 px-1">
                        <p class="text-gray-400 text-sm truncate max-w-[70%]">
                            {{ $photo['name'] ?? 'Imagen del álbum' }}
                        </p>
                        <p class="text-gray-500 text-sm tracking-widest uppercase flex-shrink-0 ml-4">
                            {{ $selectedIndex + 1 }} / {{ $totalPhotos }}
                        </p>
                    </div>

                    <p class="text-center text-gray-600 mt-3 text-xs tracking-widest uppercase">
                        Usa las flechas ← → para navegar · ESC para cerrar
                    </p>
                </div>
            </div>
        @endif
    </div>
</div>

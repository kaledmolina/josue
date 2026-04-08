<div class="min-h-screen pt-32 pb-20 px-4 md:px-8 bg-black text-white selection:bg-white selection:text-black">
    <div class="container mx-auto px-4 relative z-10">
        <!-- Header -->
        <div class="text-center mb-16" data-aos="fade-up">
            <h1 class="text-4xl md:text-6xl font-bold font-dearest mb-6 tracking-tight">
                Álbumes Fotográficos
            </h1>
            <p class="text-gray-400 text-lg md:text-xl font-light max-w-2xl mx-auto">
                Una colección de momentos capturados a través de mi lente, explorando la narrativa visual en cada
                imagen.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($albums as $album)
                <a href="{{ route('album.photos', $album['id']) }}" class="group block relative" data-aos="fade-up"
                    data-aos-delay="{{ $loop->index * 100 }}">
                    <!-- Card Container -->
                    <div
                        class="relative overflow-hidden rounded-3xl bg-white/5 border border-white/10 backdrop-blur-sm transition-all duration-500 group-hover:bg-white/10 group-hover:scale-[1.02] group-hover:shadow-2xl">

                        <!-- Search/Loading State Wrapper -->
                        <div class="relative aspect-[4/3] overflow-hidden" x-data="{ loaded: false }">
                            <!-- Skeleton Loader -->
                            <div x-show="!loaded"
                                class="absolute inset-0 bg-white/5 animate-pulse flex items-center justify-center">
                                <svg class="w-10 h-10 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>

                            <!-- Image -->
                            <img src="{{ $album['cover'] }}" alt="{{ $album['title'] }}" @load="loaded = true"
                                class="w-full h-full object-cover transition-all duration-700 opacity-0 group-hover:scale-110 group-hover:rotate-1"
                                :class="{ 'opacity-100': loaded }" loading="lazy"
                                onerror="this.onerror=null;this.src='{{ asset('images/error.jpg') }}'">

                            <!-- Overlay gradient on hover -->
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-6 relative">
                            <!-- Decorative line -->
                            <div class="w-12 h-0.5 bg-white/20 mb-4 group-hover:w-full transition-all duration-500"></div>

                            <h2 class="text-2xl font-bold mb-2 text-white group-hover:text-white/90 transition-colors">
                                {{ $album['title'] }}</h2>

                            <div class="flex justify-between items-center mt-4 text-sm font-medium">
                                <span class="text-gray-400 font-sans tracking-wide">
                                    {{ $album['date'] }}
                                </span>
                                <span
                                    class="px-3 py-1 rounded-full border border-white/20 bg-white/5 text-gray-300 text-xs backdrop-blur-md">
                                    {{ $album['photos_count'] }} FOTOS
                                </span>
                            </div>

                            <!-- Arrow icon that appears on hover -->
                            <div
                                class="absolute right-6 top-6 opacity-0 -translate-x-4 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-500 text-white">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
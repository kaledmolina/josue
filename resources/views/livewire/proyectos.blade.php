<section class="min-h-screen flex flex-col items-center justify-center py-20 bg-black relative overflow-hidden">
    <!-- Background Elements -->
    <div class="absolute inset-0 bg-gradient-to-b from-black via-gray-900 to-black opacity-40"></div>
    <div class="absolute -top-20 -left-20 w-96 h-96 bg-blue-500/5 rounded-full blur-3xl animate-pulse"></div>
    <div class="absolute -bottom-20 -right-20 w-96 h-96 bg-purple-500/5 rounded-full blur-3xl animate-pulse"></div>

    <div class="w-full max-w-7xl mx-auto px-4 lg:px-8 relative z-10">
        <div data-aos="fade-down" class="text-center mb-12">
            <h2 id="proyectos" class="text-3xl md:text-4xl font-bold text-white font-begum mb-2">
                Mis Proyectos
            </h2>
            <div class="w-16 h-1 bg-white/20 mx-auto rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-10 w-full">
            <!-- Tarjeta Fotografía -->
            <a href="/fotografias" wire:navigate data-aos="fade-right" data-aos-delay="100"
                class="group relative h-[400px] rounded-3xl overflow-hidden cursor-pointer shadow-2xl border border-white/10 transition-all duration-500 hover:-translate-y-2 hover:shadow-white/10">

                <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-110"
                    style="background-image: url('{{ asset('Images/fotos.jpg') }}');">
                </div>
                <!-- Overlay oscuro similar a la card del hero -->
                <div class="absolute inset-0 bg-black/50 transition-opacity duration-300 group-hover:bg-black/40"></div>

                <!-- Contenido al estilo del hero card -->
                <div
                    class="absolute bottom-6 left-6 right-6 p-5 bg-black/60 backdrop-blur-xl border border-white/10 rounded-2xl transform translate-y-2 transition-transform duration-500 group-hover:translate-y-0">
                    <span
                        class="inline-block px-3 py-0.5 mb-2 text-[10px] font-bold tracking-wider text-white uppercase bg-white/10 rounded-full border border-white/20">
                        Galería
                    </span>
                    <h3 class="text-2xl font-bold text-white mb-2 font-begum">Fotografía</h3>
                    <p class="text-gray-300 text-xs mb-3 line-clamp-2 font-light">
                        Explora momentos únicos congelados en el tiempo.
                    </p>
                    <div class="flex items-center text-white font-semibold text-xs">
                        <span
                            class="px-4 py-1.5 border border-white rounded-full hover:bg-white/10 transition-colors">Ver
                            Galería</span>
                    </div>
                </div>
            </a>

            <!-- Tarjeta Videos -->
            <a href="/videos" wire:navigate data-aos="fade-left" data-aos-delay="200"
                class="group relative h-[400px] rounded-3xl overflow-hidden cursor-pointer shadow-2xl border border-white/10 transition-all duration-500 hover:-translate-y-2 hover:shadow-white/10">

                <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-110"
                    style="background-image: url('{{ asset('Images/pal-videos3.png') }}');">
                </div>
                <!-- Overlay oscuro -->
                <div class="absolute inset-0 bg-black/50 transition-opacity duration-300 group-hover:bg-black/40"></div>

                <!-- Contenido al estilo del hero card -->
                <div
                    class="absolute bottom-6 left-6 right-6 p-5 bg-black/60 backdrop-blur-xl border border-white/10 rounded-2xl transform translate-y-2 transition-transform duration-500 group-hover:translate-y-0">
                    <span
                        class="inline-block px-3 py-0.5 mb-2 text-[10px] font-bold tracking-wider text-white uppercase bg-white/10 rounded-full border border-white/20">
                        Producción
                    </span>
                    <h3 class="text-2xl font-bold text-white mb-2 font-begum">Videos</h3>
                    <p class="text-gray-300 text-xs mb-3 line-clamp-2 font-light">
                        Descubre narrativas visuales en movimiento.
                    </p>
                    <div class="flex items-center text-white font-semibold text-xs">
                        <span
                            class="px-4 py-1.5 border border-white rounded-full hover:bg-white/10 transition-colors">Ver
                            Videos</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
</section>
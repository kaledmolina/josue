<section class="min-h-screen flex flex-col items-center justify-center py-20 bg-gray-900 relative overflow-hidden">
    <!-- Background Elements -->
    <div class="absolute inset-0 bg-gradient-to-b from-gray-900 via-gray-800 to-gray-900 opacity-50"></div>
    <div class="absolute -top-20 -left-20 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl animate-pulse"></div>
    <div class="absolute -bottom-20 -right-20 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl animate-pulse"></div>

    <div class="w-full max-w-7xl mx-auto px-4 lg:px-8 relative z-10">
        <div data-aos="fade-down" class="text-center mb-16">
            <h2 id="proyectos" class="text-5xl md:text-6xl font-bold text-white font-begum mb-4">
                Mis <span
                    class="bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-indigo-500">Proyectos</span>
            </h2>
            <div class="w-24 h-1 bg-gradient-to-r from-blue-500 to-indigo-500 mx-auto rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12 w-full">
            <!-- Tarjeta Fotografía -->
            <a href="/fotografias" wire:navigate data-aos="fade-right" data-aos-delay="100"
                class="group relative h-[500px] rounded-3xl overflow-hidden cursor-pointer shadow-2xl hover:shadow-blue-500/20 transition-all duration-500 hover:-translate-y-2">

                <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-110"
                    style="background-image: url('{{ asset('Images/fotos.jpg') }}');">
                </div>
                <div
                    class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent opacity-80 transition-opacity duration-300 group-hover:opacity-90">
                </div>

                <div
                    class="absolute bottom-0 left-0 w-full p-8 md:p-12 transform translate-y-4 transition-transform duration-500 group-hover:translate-y-0">
                    <span
                        class="inline-block px-4 py-1.5 mb-4 text-xs font-bold tracking-wider text-blue-300 uppercase bg-blue-500/20 rounded-full backdrop-blur-sm border border-blue-500/30">
                        Galería
                    </span>
                    <h3
                        class="text-4xl font-bold text-white mb-3 font-begum group-hover:text-blue-200 transition-colors">
                        Fotografía</h3>
                    <p
                        class="text-gray-300 font-light leading-relaxed max-w-md opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100">
                        Explora momentos únicos congelados en el tiempo. Cada imagen cuenta una historia con luz, sombra
                        y una perspectiva cinematográfica única.
                    </p>
                    <div
                        class="mt-6 flex items-center text-blue-400 font-semibold group-hover:translate-x-2 transition-transform duration-300">
                        <span>Ver Galería</span>
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Tarjeta Videos -->
            <a href="/videos" wire:navigate data-aos="fade-left" data-aos-delay="200"
                class="group relative h-[500px] rounded-3xl overflow-hidden cursor-pointer shadow-2xl hover:shadow-purple-500/20 transition-all duration-500 hover:-translate-y-2">

                <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-110"
                    style="background-image: url('{{ asset('Images/pal-videos3.png') }}');">
                </div>
                <div
                    class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent opacity-80 transition-opacity duration-300 group-hover:opacity-90">
                </div>

                <div
                    class="absolute bottom-0 left-0 w-full p-8 md:p-12 transform translate-y-4 transition-transform duration-500 group-hover:translate-y-0">
                    <span
                        class="inline-block px-4 py-1.5 mb-4 text-xs font-bold tracking-wider text-purple-300 uppercase bg-purple-500/20 rounded-full backdrop-blur-sm border border-purple-500/30">
                        Producción
                    </span>
                    <h3
                        class="text-4xl font-bold text-white mb-3 font-begum group-hover:text-purple-200 transition-colors">
                        Videos</h3>
                    <p
                        class="text-gray-300 font-light leading-relaxed max-w-md opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100">
                        Descubre narrativas visuales en movimiento. Producciones de alta calidad que dan vida a ideas
                        con creatividad y profesionalismo.
                    </p>
                    <div
                        class="mt-6 flex items-center text-purple-400 font-semibold group-hover:translate-x-2 transition-transform duration-300">
                        <span>Ver Videos</span>
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </div>
                </div>
            </a>
        </div>
    </div>
</section>
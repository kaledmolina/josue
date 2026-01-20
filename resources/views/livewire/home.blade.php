<div>
    <!-- Sección Hero mejorada -->
    <!-- Sección Hero mejorada -->
    <div class="h-screen bg-cover bg-center flex flex-col relative bg-gray-900 overflow-hidden">
        <!-- Fondo para mobile -->
        <div class="md:hidden absolute inset-0 bg-cover bg-center transition-transform duration-1000 hover:scale-105"
            style="background-image: url('{{ asset('Images/mobile-bg.png') }}');">
            <div class="absolute inset-0 bg-black/30"></div>
        </div>

        <!-- Fondo para desktop -->
        <div class="hidden md:block absolute inset-0 bg-cover bg-center transition-transform duration-1000"
            style="background-image: url('{{ asset('Images/ampli-final2.png') }}');">
            <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-transparent to-black/60"></div>
        </div>

        <div class="flex-1 pt-16 grid place-items-center">
            <!-- Scroll Down Indicator -->
            <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce hidden md:block z-10">
                <a href="#proyectos" class="text-white opacity-80 hover:opacity-100 transition-opacity">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                </a>
            </div>
        </div>

        <div class="absolute bottom-0 w-full px-4 pb-8 
                sm:px-6 sm:pb-10 md:w-auto md:absolute md:bottom-24 md:left-12
                lg:ml-20 lg:mb-20 transition-all duration-300 z-20">
            <div data-aos="fade-up" data-aos-delay="200" class="bg-black/60 backdrop-blur-xl border border-white/10
                    rounded-3xl shadow-2xl p-6
                    max-w-sm md:max-w-md
                    mx-auto md:mx-0 text-center md:text-left
                    transform transition-all duration-300 hover:bg-black/70 group">

                <h1 class="text-white text-2xl md:text-4xl font-bold font-begum mb-3 leading-tight">
                    Vision <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400">Cinematográfica</span>
                </h1>

                <p class="text-gray-300 text-sm md:text-base 
                        leading-relaxed font-light font-sans mb-4
                        group-hover:text-white transition-colors">
                    Cineasta y creador de contenido apasionado, dedicado a capturar historias reales con un estilo
                    cinematográfico único que refleja su visión auténtica del mundo.
                </p>

                <div class="mt-4 flex justify-center md:justify-start gap-3">
                    <a href="/proyectos"
                        class="px-5 py-2 text-sm bg-white text-black rounded-full font-semibold hover:bg-gray-200 transition-colors">
                        Ver Trabajo
                    </a>
                    <a href="/contacto"
                        class="px-5 py-2 text-sm border border-white text-white rounded-full font-semibold hover:bg-white/10 transition-colors">
                        Contactar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección Proyectos Modificada -->
    <livewire:proyectos />

    <!-- Sección Contacto Modificada -->
    <livewire:contacto />
</div>
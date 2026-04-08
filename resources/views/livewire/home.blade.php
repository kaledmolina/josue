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
            <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-transparent to-black/70"></div>
        </div>

        <!-- Texto gigante de fondo -->
        <div class="hidden lg:block absolute right-[-5%] top-1/2 -translate-y-1/2 z-10 pointer-events-none overflow-hidden">
            <h2 class="text-[28rem] font-bold text-white/[0.07] font-dearest leading-none tracking-tighter uppercase select-none
                    drop-shadow-[0_0_30px_rgba(59,130,246,0.2)]">
                Josué
            </h2>
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
                    rounded-3xl shadow-2xl p-6 md:p-8
                    max-w-sm md:max-w-xl
                    mx-auto md:mx-0 text-center md:text-left
                    transform transition-all duration-300 hover:bg-black/70 group">

                <h1 class="text-white text-3xl md:text-5xl font-bold font-dearest mb-2 leading-none uppercase tracking-wide
                        drop-shadow-[0_0_15px_rgba(59,130,246,0.3)]">
                    Visión Cinematográfica
                </h1>
                <p class="text-gray-200 text-sm md:text-base 
                        font-dearest mb-4
                        group-hover:text-white transition-colors max-w-lg">
                    Cineasta y creador de contenido apasionado, dedicado a capturar historias reales con un estilo
                    cinematográfico único que refleja su visión auténtica del mundo.
                </p>

                <div class="mt-2 flex flex-wrap justify-center md:justify-start gap-3">
                    <a href="/proyectos"
                        class="px-7 py-3 text-xs bg-white text-black rounded-full font-bold uppercase tracking-[0.2em] transform transition-all hover:scale-105 hover:bg-blue-50 shadow-[0_0_20px_rgba(255,255,255,0.2)]">
                        Ver Work
                    </a>
                    <a href="/contacto"
                        class="px-7 py-3 text-xs bg-black/40 text-white border border-white/20 rounded-full font-bold uppercase tracking-[0.2em] backdrop-blur-md transform transition-all hover:scale-105 hover:bg-white hover:text-black shadow-xl">
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
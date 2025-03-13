<div>
    <!-- Sección Hero mejorada -->
    <div class="min-h-screen bg-cover bg-center flex flex-col relative bg-gray-900">
        <!-- Fondo para mobile -->
        <div class="md:hidden absolute inset-0 bg-cover bg-center" 
             style="background-image: url('{{ asset('Images/mobile-bg.png') }}');"></div>
        
        <!-- Fondo para desktop -->
        <div class="hidden md:block absolute inset-0 bg-cover bg-center" 
             style="background-image: url('{{ asset('Images/ampli-final2.png') }}');"></div>

        <div class="flex-1 pt-16"></div>

        <!-- Texto responsive mejorado -->
        <div class="absolute bottom-0 right-0 w-full px-4 pb-4 
                sm:px-6 sm:pb-6 md:w-auto md:static md:ml-auto md:mr-4 md:mb-4
                lg:mr-8 lg:mb-8 transition-all duration-300">
            <p class="text-white text-base sm:text-lg md:text-xl 
                    leading-snug sm:leading-relaxed font-begum 
                    bg-black/40 backdrop-blur-lg 
                    rounded-xl shadow-2xl p-4
                    sm:max-w-xs md:max-w-sm lg:max-w-md 
                    mx-auto md:mx-0 text-center md:text-left
                    transform hover:scale-105 hover:bg-black/50
                    transition-all duration-300 cursor-default">
                Cineasta y creador de contenido apasionado, dedicado a capturar historias reales con un estilo 
                cinematográfico único que refleja su visión auténtica del mundo.
            </p>
        </div>
    </div>

    <!-- Sección Proyectos Modificada -->
    <livewire:proyectos />

    <!-- Sección Contacto Modificada -->
    <livewire:contacto />
</div>
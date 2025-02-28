<div>
    <!-- Sección Hero mejorada -->
    <div class="min-h-screen bg-cover bg-center flex flex-col relative bg-gray-900 
           bg-[image:var(--mobile-bg)] lg:bg-[image:var(--desktop-bg)]"
     style="--mobile-bg: url('{{ asset('Images/ampli-final2-mobile.jpg') }}');
            --desktop-bg: url('{{ asset('Images/ampli-final2-desktop.jpg') }}');">
    
    <!-- Fade-in inicial para transición suave -->
    <div class="absolute inset-0 bg-opacity-0 animate-fade-in"></div>
    
    <div class="flex-1"></div>

    <!-- Texto responsive mejorado -->
    <p class="absolute bottom-4 right-2 md:bottom-8 md:right-4 lg:bottom-12 lg:right-6 
                text-white text-sm sm:text-base md:text-lg lg:text-xl 
                leading-tight sm:leading-snug md:leading-relaxed 
                max-w-[200px] sm:max-w-xs md:max-w-sm lg:max-w-md 
                p-3 sm:p-4 md:p-5 lg:p-6 
                rounded-lg sm:rounded-xl 
                shadow-xl sm:shadow-2xl 
                backdrop-blur-md bg-black/25 
                mx-2 sm:mx-0 
                transition-all duration-300 hover:bg-black/40">
            Cineasta y creador de contenido apasionado, dedicado a capturar historias reales con un estilo 
            cinematográfico único que refleja su visión auténtica del mundo.
        </p>
    </div>

    <!-- Sección Proyectos Modificada -->
    <livewire:proyectos />

    <!-- Sección Contacto Modificada -->
    <livewire:contacto />
</div>
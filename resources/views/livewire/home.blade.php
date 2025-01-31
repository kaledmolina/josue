<div>
    <!-- Sección Hero mejorada -->
    <div class="min-h-screen bg-cover bg-center flex flex-col relative" style="background-image: url('{{ asset('Images/ampli-final2.png') }}');">
        <div class="flex-1"></div>
        
        <!-- Texto con posición original sin div contenedor -->
        <p 
            class="absolute bottom-10 right-4 text-white text-xl leading-relaxed font-begum max-w-xs p-6 rounded-xl shadow-2xl"
            style="transform: translateZ(0); -webkit-backdrop-filter: blur(16px);"
        >
            Cineasta y creador de contenido apasionado, dedicado a capturar historias reales con un estilo 
            cinematográfico único que refleja su visión auténtica del mundo.
        </p>
    </div>

    <!-- Sección Proyectos Modificada -->
    <livewire:proyectos />

    <!-- Sección Contacto Modificada -->
    <livewire:contacto />
</div>
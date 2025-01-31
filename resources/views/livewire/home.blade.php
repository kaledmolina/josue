<div>
    <!-- Sección Hero mejorada -->
    <div class="min-h-screen bg-cover bg-center flex flex-col relative" style="background-image: url('{{ asset('Images/ampli-final2.png') }}');">
        <div class="flex-1"></div>
        
        <!-- Texto con efecto vidrio -->
        <div class="absolute bottom-10 right-4 text-white max-w-xs p-6 rounded-xl bg-black/30 backdrop-blur-lg border border-white/10 shadow-2xl">
            <p class="text-xl leading-relaxed font-begum">
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
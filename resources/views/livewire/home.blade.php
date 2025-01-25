
    <div> <!-- Contenedor raíz único -->
        <!-- Sección Hero -->
        <div class="min-h-screen bg-cover bg-center flex flex-col" style="background-image: url('{{ asset('Images/ampli-final2.png') }}');">
            <div class="flex-1"></div> <!-- Espacio para el navbar fijo -->
            
            <!-- Texto en esquina inferior derecha -->
            <div class="absolute bottom-10 right-4 text-white max-w-xs bg-black bg-opacity-50 p-4 rounded-lg">
                <p class="text-lg font-begum">
                    Cineasta y creador de contenido apasionado, dedicado a capturar historias reales con un estilo 
                    cinematográfico único que refleja su visión auténtica del mundo.
                </p>
            </div>
        </div>

        <!-- Sección Proyectos -->
        <section class="min-h-screen flex flex-col items-center justify-center py-12 bg-cover bg-center">
            <h2 id="proyectos" class="text-4xl font-bold text-white font-begum mb-8">Proyectos</h2>
            <div class="flex w-full flex-col lg:flex-row max-w-7xl mx-4 lg:mx-8">
                <!-- Tarjeta Fotografía -->
                <a href="/fotografia" 
                wire:navigate
                class="card group bg-base-300 rounded-box flex-grow h-96 relative overflow-hidden mx-4 lg:mx-8 
                        transition-transform duration-300 hover:scale-105">
                    <div class="hero w-full h-full">
                        <div class="aspect-square w-full h-full">
                            <img src="{{ asset('Images/fotos.jpg') }}" 
                                    alt="Fotografía" 
                                    class="w-full h-full object-cover object-center">
                        </div>
                        <div class="hero-content text-neutral-content text-center absolute inset-0 flex items-center 
                                justify-center bg-black/30 transition-all duration-300 group-hover:bg-black/40">
                            <div class="max-w-md p-4">
                                <h1 class="mb-5 text-5xl font-begum font-bold">Fotografía</h1>
                                <p class="mb-5 font-begum">
                                    Explora mis trabajos de fotografía, capturando momentos únicos con un estilo cinematográfico.
                                </p>
                            </div>
                        </div>
                    </div>
                </a>

                <div class="divider bg-base-100 lg:divider-horizontal"></div>

                <!-- Tarjeta Videos -->
                <a wire:navigate href="/videos"
                class="card group bg-base-300 rounded-box flex-grow h-96 relative overflow-hidden mx-4 lg:mx-8 
                        transition-transform duration-300 hover:scale-105">
                    <div class="hero w-full h-full">
                        <div class="aspect-square w-full h-full">
                            <img src="{{ asset('Images/pal-videos3.png') }}" 
                                    alt="Videos" 
                                    class="w-full h-full object-cover object-center">
                        </div>
                        <div class="hero-content text-neutral-content text-center absolute inset-0 flex items-center 
                                justify-center bg-black/30 transition-all duration-300 group-hover:bg-black/40">
                            <div class="max-w-md p-4">
                                <h1 class="mb-5 text-5xl font-begum font-bold">Videos</h1>
                                <p class="mb-5 font-begum">
                                    Descubre mis proyectos de video, donde cada historia cobra vida con un enfoque creativo y profesional.
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </section>
    </div> <!-- Cierre del contenedor raíz único -->

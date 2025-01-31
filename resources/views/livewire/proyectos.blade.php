<section class="min-h-screen flex flex-col items-center justify-center py-12 bg-cover bg-center">
        <div class="w-full max-w-7xl mx-auto px-4 lg:px-8">
            <h2 id="proyectos" class="text-4xl font-bold text-white font-begum mb-8 text-center">Proyectos</h2>
            <div class="flex flex-col lg:flex-row gap-8 w-full">
                <!-- Tarjeta Fotografía -->
                <a href="/fotografias" 
                   wire:navigate
                   class="card group bg-base-300 rounded-box flex-grow h-[480px] lg:h-[600px] relative overflow-hidden 
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

                <!-- Tarjeta Videos -->
                <a wire:navigate href="/videos"
                   class="card group bg-base-300 rounded-box flex-grow h-[480px] lg:h-[600px] relative overflow-hidden 
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
        </div>
    </section>
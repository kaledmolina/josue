<div>
    {{-- Agregamos un estilo para la sombra del texto para mejorar la legibilidad --}}
    <style>
        .text-shadow {
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.6);
        }
    </style>

    <div class="min-h-screen bg-cover bg-center bg-fixed pt-20" style="background-image: url('{{ asset('Images/ampli-final2.png') }}');">
        <section class="container mx-auto py-12 px-4">
            <h2 class="text-4xl lg:text-5xl font-bold text-white font-begum mb-12 text-center text-shadow">Videos</h2>
            
            <div class="space-y-16">
                @foreach($videos as $video)
                    {{-- Usamos wire:key para un rendimiento óptimo en Livewire --}}
                    <div wire:key="video-{{ $video->id }}" class="max-w-7xl mx-auto">
                        <div class="flex flex-col {{ $video->alignment === 'right' ? 'lg:flex-row-reverse' : 'lg:flex-row' }} items-stretch gap-8 transition-all duration-300 ease-in-out transform hover:scale-[1.02]">
                            
                            <!-- Contenedor del Video (Adaptativo para videos verticales) -->
                            <div class="w-full lg:w-1/2 flex justify-center items-center">
                                <div class="
                                    {{ $video->is_vertical ? 'aspect-[9/16] w-full max-w-[320px]' : 'aspect-video w-full' }}
                                    bg-black/30 backdrop-blur-lg border border-white/20 rounded-lg shadow-2xl p-2 transition-all duration-300
                                ">
                                    {{-- Usamos {!! !!} para renderizar el HTML del embed --}}
                                    {!! $video->embed_html !!}
                                </div>
                            </div>
                            
                            <!-- Contenedor del Texto con diseño mejorado -->
                            <div class="w-full lg:w-1/2 flex items-center bg-black/30 backdrop-blur-lg border border-white/20 rounded-lg shadow-2xl p-6 lg:p-8">
                                <div class="text-white font-begum space-y-4 text-justify">
                                    <h3 class="text-3xl font-bold mb-4 text-shadow">{{ $video->title }}</h3>
                                    <div class="prose prose-invert prose-lg text-shadow">
                                        {!! $video->description !!}
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Indicador de Carga para el Scroll Infinito --}}
            @if($hasMorePages)
                <div x-data="{
                    observe () {
                        const observer = new IntersectionObserver((entries) => {
                            entries.forEach(entry => {
                                if (entry.isIntersecting) {
                                    @this.call('loadMore')
                                }
                            })
                        }, {
                            root: null
                        })
                        observer.observe(this.$el)
                    }
                }" x-init="observe">
                    {{-- Mientras se carga, muestra este spinner --}}
                    <div wire:loading wire:target="loadMore" class="flex justify-center items-center mt-16">
                        <svg class="animate-spin -ml-1 mr-3 h-10 w-10 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="text-white text-xl font-begum text-shadow">Cargando más videos...</span>
                    </div>
                </div>
            @endif
        </section>
    </div>
</div>
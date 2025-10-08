<div>
    <style>
        .text-shadow {
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.8);
        }
        
        .card-glass {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            transition: all 0.3s ease;
        }
        
        .card-glass:hover {
            background: rgba(255, 255, 255, 0.12);
            border-color: rgba(255, 255, 255, 0.3);
            transform: translateY(-4px);
        }

        /* Estilos para los botones de navegación */
        .nav-button {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 0.75rem 1.5rem;
            border-radius: 9999px;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .nav-button:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        /* Estilos para la navegación flotante */
        .floating-nav-container {
            height: 70px; /* Reserve space for the nav bar to prevent content jump */
            position: relative;
        }

        .floating-nav {
            position: fixed; /* Cambiado a fixed para compatibilidad con el layout */
            top: 5rem; /* Ajustado para aparecer debajo de la navbar principal (aprox 4rem de altura) */
            left: 50%; /* Centrado horizontal */
            transform: translateX(-50%); /* Centrado horizontal */
            z-index: 40; /* Ligeramente por debajo de la navbar principal (z-50) */
            width: -moz-fit-content;
            width: fit-content;
            margin: 0 auto;
            padding: 0.5rem;
            background: rgba(30, 30, 30, 0.6);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 9999px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
            transition: top 0.3s ease;
        }

        /* Animación de entrada */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .video-card {
            animation: fadeInUp 0.6s ease-out;
        }

        .gallery-item {
            animation: fadeInScale 0.5s ease-out;
        }

        /* Gradiente sobre el video */
        .video-overlay {
            position: relative;
        }

        .video-overlay::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, transparent 60%, rgba(0, 0, 0, 0.3));
            pointer-events: none;
            border-radius: 12px;
            z-index: 1;
        }

        /* Grid de galería responsivo */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        @media (min-width: 768px) {
            .gallery-grid {
                grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
                gap: 2rem;
            }
        }

        @media (min-width: 1024px) {
            .gallery-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (min-width: 1280px) {
            .gallery-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        /* Mejora del texto */
        .prose-custom p {
            line-height: 1.8;
            margin-bottom: 1rem;
        }

        /* Overlay para la información del video en galería */
        .gallery-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.9) 0%, rgba(0, 0, 0, 0.4) 50%, transparent 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 1.5rem;
            border-radius: 12px;
            pointer-events: none;
        }

        .gallery-item:hover .gallery-overlay {
            opacity: 1;
        }

        /* Contador de videos */
        .video-counter {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            padding: 0.5rem 1.25rem;
            border-radius: 30px;
            font-size: 0.875rem;
            font-weight: 600;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* Ocultar elementos innecesarios de Instagram */
        .instagram-embed-wrapper iframe {
            border: none !important;
        }

        /* Forzar que el blockquote de Instagram ocupe todo el espacio */
        .instagram-embed-wrapper .instagram-media {
            margin: 0 !important;
            min-width: 100% !important;
            max-width: 100% !important;
            width: 100% !important;
        }

        /* Ocultar información extra de Instagram */
        .instagram-embed-wrapper .instagram-media::after {
            display: none !important;
        }

        /* Intentar ocultar el pie de Instagram con descripción y likes */
        .instagram-embed-wrapper blockquote > div:last-child,
        .instagram-embed-wrapper .instagram-media > div:last-child,
        .instagram-embed-wrapper .instagram-media footer,
        .instagram-embed-wrapper .instagram-media p {
            display: none !important;
            visibility: hidden !important;
            height: 0 !important;
            overflow: hidden !important;
        }

        /* Ocultar el enlace "Ver más en Instagram" */
        .instagram-embed-wrapper a[href*="instagram.com"] {
            display: none !important;
        }

        /* Limitar altura del blockquote al contenedor */
        .instagram-embed-wrapper .instagram-media {
            max-height: 100% !important;
            overflow: hidden !important;
        }
    </style>

    <div class="min-h-screen bg-cover bg-center bg-fixed" style="background-image: url('{{ asset('Images/ampli-final2.png') }}');">
        <div class="min-h-screen bg-black/40">
            <section class="container mx-auto py-16 px-4 lg:px-8">
                
                <div class="text-center mb-16 pt-20">
                                      <!-- NAVEGACIÓN A SECCIONES FLOTANTE -->
                    <div class="floating-nav-container">
                        <div class="floating-nav flex justify-center items-center space-x-2">
                            <a href="#videos" class="nav-button">Videos</a>
                            <a href="#reels" class="nav-button">Shorts & Reels</a>
                        </div>
                    </div>

                    <div class="w-32 h-1 bg-gradient-to-r from-transparent via-white to-transparent mx-auto mt-8"></div>
                </div>

                {{-- VIDEOS HORIZONTALES --}}
                @php
                    $horizontalVideos = $videos->filter(fn($v) => !$v->is_vertical);
                @endphp

                @if($horizontalVideos->isNotEmpty())
                    <div id="videos" class="mb-20" style="scroll-margin-top: 12rem;">
                        <h3 class="text-3xl lg:text-4xl font-bold text-white font-begum text-shadow mb-12 text-center">
                            Videos
                        </h3>
                        
                        <div class="space-y-24">
                            @foreach($horizontalVideos as $index => $video)
                                <div wire:key="horizontal-{{ $video->id }}" 
                                     class="video-card max-w-7xl mx-auto"
                                     style="animation-delay: {{ $index * 0.1 }}s">
                                    
                                    <div class="flex flex-col {{ $video->alignment === 'right' ? 'lg:flex-row-reverse' : 'lg:flex-row' }} items-stretch gap-8 lg:gap-12">
                                        
                                        <div class="w-full lg:w-1/2">
                                            <div class="aspect-video w-full card-glass rounded-2xl overflow-hidden shadow-2xl">
                                                <div class="video-overlay h-full">
                                                    <div class="w-full h-full">
                                                        {!! $video->embed_html !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="w-full lg:w-1/2 flex items-center">
                                            <div class="card-glass rounded-2xl shadow-2xl p-8 lg:p-10 w-full h-full flex flex-col justify-center">
                                                <h3 class="text-3xl lg:text-4xl font-bold text-white font-begum mb-6 text-shadow">
                                                    {{ $video->title }}
                                                </h3>
                                                <div class="text-gray-100 font-begum text-lg leading-relaxed prose-custom text-justify">
                                                    {!! $video->description !!}
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- VIDEOS VERTICALES (SHORTS/REELS) - GALERÍA --}}
                @php
                    $verticalVideos = $videos->filter(fn($v) => $v->is_vertical);
                @endphp

                @if($verticalVideos->isNotEmpty())
                    <div id="reels" class="mt-32" style="scroll-margin-top: 12rem;">
                        <div class="h-px bg-gradient-to-r from-transparent via-white/50 to-transparent mb-20"></div>

                        <h3 class="text-3xl lg:text-4xl font-bold text-white font-begum text-shadow mb-12 text-center">
                            Shorts & Reels
                        </h3>

                        <div class="gallery-grid">
                            @foreach($verticalVideos as $index => $video)
                                <div wire:key="vertical-{{ $video->id }}" 
                                     class="gallery-item"
                                     style="animation-delay: {{ $index * 0.05 }}s">
                                    
                                    <div class="relative group">
                                        <div class="aspect-[9/16] w-full card-glass rounded-2xl overflow-hidden shadow-2xl">
                                            @if(str_contains($video->url, 'instagram.com'))
                                                <div class="instagram-embed-wrapper w-full h-full">
                                                    {!! $video->embed_html !!}
                                                </div>
                                            @else
                                                <div class="w-full h-full p-2">
                                                    {!! $video->embed_html !!}
                                                </div>
                                            @endif
                                        </div>

                                        <div class="gallery-overlay">
                                            <h3 class="text-xl font-bold text-white font-begum mb-2 text-shadow line-clamp-2">
                                                {{ $video->title }}
                                            </h3>
                                            <div class="text-gray-200 font-begum text-sm leading-relaxed line-clamp-3">
                                                {!! strip_tags($video->description) !!}
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Mensaje cuando no hay videos --}}
                @if($videos->isEmpty())
                    <div class="text-center py-20">
                        <div class="card-glass rounded-2xl p-12 max-w-md mx-auto">
                            <svg class="w-20 h-20 mx-auto mb-6 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-white text-xl font-begum">
                                No hay videos disponibles
                            </p>
                        </div>
                    </div>
                @endif

            </section>
        </div>
    </div>
    
    <script async src="//www.instagram.com/embed.js"></script>
    
    @script
    <script>
        function processInstagramEmbeds() {
            if (typeof window.instgrm !== 'undefined' && window.instgrm.Embeds) {
                try {
                    window.instgrm.Embeds.process();
                    
                    // Después de procesar, ocultar elementos adicionales
                    setTimeout(() => {
                        hideInstagramExtras();
                    }, 1000);
                } catch (e) {
                    console.log('Instagram embed processing:', e);
                }
            } else {
                setTimeout(processInstagramEmbeds, 100);
            }
        }

        function hideInstagramExtras() {
            // Buscar todos los iframes de Instagram
            const instagramIframes = document.querySelectorAll('.instagram-embed-wrapper iframe');
            
            instagramIframes.forEach(iframe => {
                try {
                    // Intentar acceder al contenido del iframe (puede fallar por CORS)
                    const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
                    
                    if (iframeDoc) {
                        // Ocultar footer, comentarios y descripción dentro del iframe
                        const style = iframeDoc.createElement('style');
                        style.textContent = `
                            footer, 
                            [role="contentinfo"],
                            .Caption,
                            ._a9zs,
                            ._a9_1,
                            article > div:last-child {
                                display: none !important;
                            }
                            article {
                                padding-bottom: 0 !important;
                            }
                        `;
                        iframeDoc.head.appendChild(style);
                    }
                } catch (e) {
                    // CORS bloqueará esto, pero lo intentamos
                    console.log('No se puede acceder al iframe de Instagram (CORS)');
                }
            });

            // Ocultar elementos fuera del iframe
            document.querySelectorAll('.instagram-embed-wrapper .instagram-media a, .instagram-embed-wrapper .instagram-media footer, .instagram-embed-wrapper .instagram-media p').forEach(el => {
                el.style.display = 'none';
                el.style.visibility = 'hidden';
                el.style.height = '0';
                el.style.overflow = 'hidden';
            });
        }

        document.addEventListener('livewire:initialized', () => {
            setTimeout(() => processInstagramEmbeds(), 300);
        });

        document.addEventListener('livewire:navigated', () => {
            setTimeout(() => processInstagramEmbeds(), 300);
        });
    </script>
    @endscript
</div>


<div class="pt-20 px-4 md:px-8">
    <div class="container mx-auto px-4">
    <h1 class="text-4xl font-bold text-center mb-8">Álbumes Fotográficos</h1>

    <!-- Lista de álbumes -->
    <div class="{{ $selectedAlbum ? 'hidden' : '' }} grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($albums as $album)
        <div 
            class="card bg-base-100 shadow-xl hover:shadow-2xl transition-shadow cursor-pointer group"
            wire:click="selectAlbum({{ $album['id'] }})"
        >
            <figure class="relative aspect-square">
                <img 
                    src="{{ $album['cover'] }}" 
                    alt="{{ $album['title'] }}" 
                    class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105" 
                    loading="lazy"
                />
            </figure>
            <div class="card-body">
                <h2 class="card-title">{{ $album['title'] }}</h2>
                <p class="text-sm text-gray-500">{{ $album['date'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Vista de álbum individual -->
    @if($selectedAlbum)
    <div>
        <button 
            wire:click="deselectAlbum" 
            class="btn btn-primary mb-4 gap-2"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Volver a Álbumes
        </button>
        
        <div class="card bg-base-100 shadow-xl mb-8">
            <figure class="relative aspect-video">
                <img 
                    src="{{ $selectedAlbum['cover'] }}" 
                    alt="{{ $selectedAlbum['title'] }}" 
                    class="w-full h-full object-cover"
                    loading="lazy"
                />
            </figure>
            <div class="card-body">
                <h2 class="card-title text-3xl">{{ $selectedAlbum['title'] }}</h2>
                <p class="text-gray-500">{{ $selectedAlbum['date'] }}</p>
            </div>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($selectedAlbum['photos'] as $photo)
                <div 
                    class="relative group cursor-pointer"
                    wire:click="selectPhoto('{{ urlencode($photo) }}')" 
                >
                    <img 
                        src="{{ $photo }}" 
                        alt="Foto del álbum" 
                        class="w-full h-48 object-cover rounded-lg shadow-md transition-transform duration-300 group-hover:scale-105"
                        loading="lazy"
                    />
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all rounded-lg pointer-events-none"></div>
                </div>
                @endforeach
        </div>
    </div>
    @endif

    <!-- Modal para imagen en tamaño completo -->
    @if($selectedPhoto)
    <div class="fixed inset-0 z-50 bg-black/95 backdrop-blur-sm flex items-center justify-center">
        <button 
            class="absolute top-4 right-4 text-white hover:text-gray-200 transition-colors"
            wire:click="closePhoto"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" stroke="currentColor" fill="none">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        
        <img 
            src="{{ $selectedPhoto }}" 
            alt="Imagen en tamaño completo" 
            class="max-w-[95vw] max-h-[95vh] object-contain cursor-zoom-out"
            wire:click="closePhoto"
        />
    </div>
    @endif
</div>

<style>
    .animate-fade-in {
        animation: fadeIn 0.3s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
</style> </div>
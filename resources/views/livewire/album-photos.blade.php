<div class="pt-20 px-4 md:px-8">
    <div class="container mx-auto px-4">
        <button onclick="window.history.back()" class="btn btn-primary mb-4 gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Volver a Álbumes
        </button>
        
        <div class="card bg-base-100 shadow-xl mb-8">
            <figure class="relative aspect-video">
                <img src="{{ $albumData['cover'] }}" 
                     alt="{{ $albumData['title'] }}"
                     class="w-full h-full object-cover"
                     loading="lazy">
            </figure>
            <div class="card-body">
                <h2 class="card-title text-3xl">{{ $albumData['title'] }}</h2>
                <p class="text-gray-500">{{ $albumData['date'] }}</p>
            </div>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($albumData['photos'] as $photo)
            <div class="relative group cursor-pointer">
                <img src="{{ $photo }}" 
                    alt="Foto del álbum"
                    class="w-full h-48 object-cover rounded-lg shadow-md transition-transform duration-300 group-hover:scale-105"
                    loading="lazy"
                    wire:click="selectPhoto('{{ $photo }}')"
                    onerror="this.onerror=null;this.src='{{ asset('images/error.jpg') }}'">
            </div>
            @endforeach
        </div>

        @if($selectedPhoto)
        <div class="fixed inset-0 z-50 bg-black/95 backdrop-blur-sm flex items-center justify-center animate-fade-in">
            <button class="absolute top-4 right-4 text-white hover:text-gray-200 transition-colors"
                    wire:click="closePhoto">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" stroke="currentColor" fill="none">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            
            <img src="{{ $selectedPhoto }}" 
                 alt="Imagen en tamaño completo"
                 class="max-w-[95vw] max-h-[95vh] object-contain cursor-zoom-out"
                 wire:click="closePhoto"
                 onerror="this.onerror=null;this.src='{{ asset('images/error.jpg') }}'">
        </div>
        @endif
    </div>
</div>
<div class="pt-20 px-4 md:px-8">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-center mb-8">Álbumes Fotográficos</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($albums as $album)
            <a href="{{ route('album.photos', $album['id']) }}" class="block hover:no-underline">
                <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-shadow">
                    <figure class="relative aspect-square">
                        <img src="{{ $album['cover'] }}" 
                             alt="{{ $album['title'] }}"
                             class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                             loading="lazy"
                             onerror="this.onerror=null;this.src='{{ asset('images/error.jpg') }}'">
                    </figure>
                    <div class="card-body">
                        <h2 class="card-title">{{ $album['title'] }}</h2>
                        <div class="flex justify-between items-center">
                            <p class="text-sm text-gray-500">{{ $album['date'] }}</p>
                            <span class="badge badge-primary">
                                {{ $album['photos_count'] }} fotos
                            </span>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</div>
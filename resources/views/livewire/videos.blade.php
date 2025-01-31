<div>
    <div class="min-h-screen bg-cover bg-center pt-20" style="background-image: url('{{ asset('Images/ampli-final2.png') }}');">
        <section class="container mx-auto py-12 px-4">
            <h2 class="text-4xl font-bold text-white font-begum mb-8 text-center">Videos</h2>
            
            @foreach($videos as $video)
            <div class="mb-20 max-w-7xl mx-auto">
                <div class="video-container flex flex-col {{ $video['alignment'] === 'right' ? 'lg:flex-row-reverse' : 'lg:flex-row' }} items-stretch gap-8 bg-opacity-50 rounded-lg p-6 backdrop-blur-md">
                    <!-- Video -->
                    <div class="w-full lg:w-1/2 aspect-video">
                        <iframe 
                            class="w-full h-full rounded-lg shadow-xl"
                            src="{{ $video['url'] }}"
                            title="{{ $video['title'] }}"
                            frameborder="0"
                            allowfullscreen>
                        </iframe>
                    </div>
                    
                    <!-- Texto -->
                    <div class="w-full lg:w-1/2 flex items-center p-6 rounded-lg">
                        <div class="text-white font-begum space-y-4 text-justify">
                            <h3 class="text-3xl font-bold mb-4">{{ $video['title'] }}</h3>
                            {!! nl2br(e($video['description'])) !!}
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            <!-- Cargar más videos cuando el usuario llegue al final -->
            <div x-data="{
                init() {
                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                @this.call('loadMore');
                            }
                        });
                    }, {
                        root: null,
                        rootMargin: '0px',
                        threshold: 0.5
                    });

                    observer.observe(this.$el);
                }
            }" x-init="init">
            </div>
        </section>
    </div>
</div>
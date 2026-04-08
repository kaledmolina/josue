{{-- resources/views/livewire/contacto.blade.php --}}
<section class="min-h-screen relative text-white py-28 bg-gray-900 overflow-hidden"
    style="background-image: url('{{ asset('Images/contador.png') }}'); background-attachment: fixed; background-position: center; background-size: cover;">
    <div class="absolute inset-0 bg-black/70 backdrop-blur-sm"></div>

    <div class="container mx-auto text-center relative z-10 max-w-7xl px-4 lg:px-8">
        <!-- Estadísticas dinámicas -->
        @if($stats->count() > 0)
            <div data-aos="fade-up" class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                <!-- Botón de actualización -->
                @if($lastUpdate)
                    <div class="md:col-span-3 flex justify-end mb-4">
                        <div
                            class="flex items-center space-x-3 text-sm bg-black/40 px-4 py-2 rounded-full border border-white/10 backdrop-blur-md">
                            <span class="text-white/70">
                                Actualizado: {{ $lastUpdate['human'] }}
                                @if(!$lastUpdate['is_today'])
                                    <span
                                        class="ml-2 px-2 py-0.5 bg-yellow-500/20 text-yellow-300 rounded-full text-xs border border-yellow-500/30">Desactualizado</span>
                                @endif
                            </span>
                            <button wire:click="forceRefreshStats" wire:loading.attr="disabled"
                                class="p-1.5 hover:bg-white/10 rounded-full transition-all disabled:opacity-50">
                                <span wire:loading.remove wire:target="forceRefreshStats" class="text-lg">🔄</span>
                                <span wire:loading wire:target="forceRefreshStats" class="animate-spin inline-block">⏳</span>
                            </button>
                        </div>
                    </div>
                @endif

                <!-- Mensajes de estado -->
                @if($isUpdatingStats)
                    <div
                        class="md:col-span-3 mb-4 p-4 bg-blue-500/10 border border-blue-400/30 rounded-xl backdrop-blur-md animate-pulse">
                        <span class="text-blue-300 font-semibold flex items-center justify-center gap-2">
                            <svg class="animate-spin h-5 w-5" viewBox="0 0 24 24"><!-- ... --></svg>
                            Actualizando estadísticas...
                        </span>
                    </div>
                @endif

                @if(session()->has('stats-updated'))
                    <div class="md:col-span-3 mb-4 p-4 bg-green-500/10 border border-green-400/30 rounded-xl backdrop-blur-md">
                        <span class="text-green-300 font-semibold">✅ {{ session('stats-updated') }}</span>
                    </div>
                @endif

                @if(session()->has('stats-error'))
                    <div class="md:col-span-3 mb-4 p-4 bg-red-500/10 border border-red-400/30 rounded-xl backdrop-blur-md">
                        <span class="text-red-300 font-semibold">❌ {{ session('stats-error') }}</span>
                    </div>
                @endif

                <!-- Grid de estadísticas -->
                @foreach($stats as $stat)
                    <div
                        class="bg-white/5 p-6 rounded-3xl backdrop-blur-md border border-white/10 shadow-xl hover:border-white/20 transition-all duration-300 hover:transform hover:-translate-y-1">
                        <h2 class="text-4xl md:text-5xl font-bold mb-3 text-white">
                            {{ $stat->value }}
                        </h2>
                        <p class="text-lg text-white/90 font-medium tracking-wide">{{ $stat->description }}</p>
                        @if($stat->updated_at)
                            <p class="text-[10px] text-white/40 mt-3 font-mono">Act: {{ $stat->updated_at->format('d/m H:i') }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Sección de contacto -->
        <div id="contacto" class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12 mx-auto">
            <!-- Descripción -->
            <div data-aos="fade-right"
                class="bg-black/60 backdrop-blur-xl border border-white/10 rounded-3xl shadow-2xl p-6 md:p-10 transform transition-all duration-300 hover:bg-black/70 group flex items-center">
                <div
                    class="text-base md:text-lg text-white/90 leading-relaxed text-center md:text-left font-dearest space-y-4">
                    @if($contactDescription)
                        {!! $contactDescription !!}
                    @else
                        <h3 class="text-2xl font-bold mb-4 text-white">¿Listo para crear algo increíble?</h3>
                        <p class="font-light">Ya sea que tengas una historia que contar, una marca que elevar o un momento
                            que capturar, estoy aquí para hacerlo realidad.</p>
                        <p class="font-light">Contáctame y comencemos a darle vida a tu visión.</p>
                    @endif
                </div>
            </div>

            <!-- Formulario de contacto -->
            <div data-aos="fade-left"
                class="bg-black/60 backdrop-blur-xl border border-white/10 rounded-3xl shadow-2xl p-6 md:p-10 transform transition-all duration-300 hover:bg-black/70 group">
                <div class="w-full">
                    <h2 class="text-2xl md:text-3xl font-bold text-white mb-6 font-dearest text-left">Contáctanos</h2>
                    <form wire:submit.prevent="submit" class="space-y-6 text-left">
                        @if(session()->has('message'))
                            <div
                                class="bg-green-500/10 border border-green-500/30 p-4 rounded-xl text-green-400 flex items-center gap-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                {{ session('message') }}
                            </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="group">
                                <label
                                    class="block text-sm font-medium text-gray-400 mb-2 ml-1 group-focus-within:text-white transition-colors">Nombre</label>
                                <input type="text" wire:model="name"
                                    class="w-full px-5 py-3 rounded-xl bg-white/5 border border-white/10 focus:border-white focus:ring-1 focus:ring-white/50 outline-none text-white placeholder-white/30 transition-all"
                                    placeholder="Tu nombre">
                                @error('name')<span
                                class="text-red-400 text-sm block mt-1 ml-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="group">
                                <label
                                    class="block text-sm font-medium text-gray-400 mb-2 ml-1 group-focus-within:text-white transition-colors">Email</label>
                                <input type="email" wire:model="email"
                                    class="w-full px-5 py-3 rounded-xl bg-white/5 border border-white/10 focus:border-white focus:ring-1 focus:ring-white/50 outline-none text-white placeholder-white/30 transition-all"
                                    placeholder="tucorreo@ejemplo.com">
                                @error('email')<span
                                class="text-red-400 text-sm block mt-1 ml-1">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="group">
                            <label
                                class="block text-sm font-medium text-gray-400 mb-2 ml-1 group-focus-within:text-white transition-colors">Mensaje</label>
                            <textarea rows="4" wire:model="message"
                                class="w-full px-5 py-3 rounded-xl bg-white/5 border border-white/10 focus:border-white focus:ring-1 focus:ring-white/50 outline-none text-white placeholder-white/30 transition-all resize-none"
                                placeholder="Cuéntame sobre tu proyecto..."></textarea>
                            @error('message')<span
                            class="text-red-400 text-sm block mt-1 ml-1">{{ $message }}</span>@enderror
                        </div>

                        <button type="submit" wire:loading.attr="disabled"
                            class="w-full bg-white text-black font-bold py-4 px-8 rounded-full hover:bg-gray-200 transition-all duration-300 transform hover:scale-[1.02] shadow-lg disabled:opacity-70 disabled:cursor-not-allowed">
                            <span wire:loading.remove wire:target="submit">Enviar Mensaje</span>
                            <span wire:loading wire:target="submit" class="flex items-center justify-center gap-2">
                                <svg class="animate-spin h-5 w-5 text-black" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Enviando...
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('statsUpdated', () => {
            console.log('Estadísticas actualizadas');
        });
    });
</script>
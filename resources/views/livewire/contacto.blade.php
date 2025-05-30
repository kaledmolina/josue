{{-- resources/views/livewire/contacto.blade.php --}}
<section class="min-h-screen relative text-white py-28" style="background-image: url('{{ asset('Images/contador.png') }}');">
    <div class="absolute inset-0 bg-black/60"></div>
    
    <div class="container mx-auto text-center relative z-10 max-w-7xl px-4 lg:px-8">
        <!-- Estadísticas dinámicas -->
        @if($stats->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <!-- Botón de actualización -->
            @if($lastUpdate)
            <div class="md:col-span-3 flex justify-end mb-4">
                <div class="flex items-center space-x-3 text-sm">
                    <span class="text-white/70">
                        Actualizado: {{ $lastUpdate['human'] }}
                        @if(!$lastUpdate['is_today'])
                            <span class="ml-2 px-2 py-1 bg-yellow-500/20 text-yellow-300 rounded-full text-xs">Desactualizado</span>
                        @endif
                    </span>
                    <button wire:click="forceRefreshStats" 
                            wire:loading.attr="disabled"
                            class="px-3 py-1 bg-white/10 hover:bg-white/20 rounded-lg transition-all disabled:opacity-50">
                        <span wire:loading.remove wire:target="forceRefreshStats">🔄</span>
                        <span wire:loading wire:target="forceRefreshStats">⏳</span>
                    </button>
                </div>
            </div>
            @endif

            <!-- Mensajes de estado -->
            @if($isUpdatingStats)
            <div class="md:col-span-3 mb-4 p-3 bg-blue-500/20 border border-blue-400/30 rounded-lg">
                <span class="text-blue-300">🔄 Actualizando estadísticas...</span>
            </div>
            @endif

            @if(session()->has('stats-updated'))
            <div class="md:col-span-3 mb-4 p-3 bg-green-500/20 border border-green-400/30 rounded-lg">
                <span class="text-green-300">✅ {{ session('stats-updated') }}</span>
            </div>
            @endif

            @if(session()->has('stats-error'))
            <div class="md:col-span-3 mb-4 p-3 bg-red-500/20 border border-red-400/30 rounded-lg">
                <span class="text-red-300">❌ {{ session('stats-error') }}</span>
            </div>
            @endif

            <!-- Grid de estadísticas -->
            @foreach($stats as $stat)
            <div class="bg-white/5 p-8 rounded-2xl backdrop-blur-sm border border-white/10">
                <h2 class="text-5xl font-bold mb-4 bg-gradient-to-r from-blue-400 to-cyan-400 bg-clip-text text-transparent">
                    {{ $stat->value }}
                </h2>
                <p class="text-lg text-white/80">{{ $stat->description }}</p>
                @if($stat->updated_at)
                <p class="text-xs text-white/60 mt-2">Act: {{ $stat->updated_at->format('d/m H:i') }}</p>
                @endif
            </div>
            @endforeach
        </div>
        @endif

        <!-- Sección de contacto -->
        <div id="contacto" class="grid grid-cols-1 md:grid-cols-2 gap-8 mx-auto">
            <!-- Descripción -->
            <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-8 border border-white/10 shadow-xl min-h-[400px] flex items-center">
                <div class="text-lg text-white/90 leading-relaxed text-center font-begum">
                    @if($contactDescription)
                        {!! $contactDescription !!}
                    @else
                        <p>¡Estamos aquí para ayudarte! Contáctanos para cualquier consulta o colaboración.</p>
                    @endif
                </div>
            </div>
            
            <!-- Formulario de contacto -->
            <div class="bg-white/10 backdrop-blur-xl rounded-2xl p-8 shadow-2xl border border-white/10 min-h-[400px] flex items-center">
                <div class="w-full">
                    <h2 class="text-4xl font-bold text-white mb-8 font-begum">Contáctanos</h2>
                    <form wire:submit.prevent="submit" class="space-y-6 text-left">
                        @if(session()->has('message'))
                        <div class="bg-green-500/20 p-4 rounded-xl text-green-400">
                            ✅ {{ session('message') }}
                        </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <input type="text" 
                                       wire:model="name"
                                       class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/20 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/30 placeholder-white/50 transition-all"
                                       placeholder="Nombre completo">
                                @error('name')<span class="text-red-400 text-sm block mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div>
                                <input type="email" 
                                       wire:model="email"
                                       class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/20 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/30 placeholder-white/50 transition-all"
                                       placeholder="Correo electrónico">
                                @error('email')<span class="text-red-400 text-sm block mt-1">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        
                        <div>
                            <textarea rows="4" 
                                      wire:model="message"
                                      class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/20 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/30 placeholder-white/50 transition-all"
                                      placeholder="Escribe tu mensaje..."></textarea>
                            @error('message')<span class="text-red-400 text-sm block mt-1">{{ $message }}</span>@enderror
                        </div>
                        
                        <button type="submit" 
                                wire:loading.attr="disabled"
                                class="w-full bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-400 hover:to-blue-500 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 transform hover:scale-[1.02] shadow-lg hover:shadow-2xl disabled:opacity-50">
                            <span wire:loading.remove wire:target="submit">Enviar Mensaje</span>
                            <span wire:loading wire:target="submit">Enviando...</span>
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
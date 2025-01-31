<section class="min-h-screen relative text-white py-28" style="background-image: url('{{ asset('Images/contador.png') }}');">
    <div class="absolute inset-0 bg-black/60"></div>
    
    <div class="container mx-auto text-center relative z-10 max-w-7xl px-4 lg:px-8">
        <!-- Estadísticas dinámicas -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-24">
            @foreach($stats as $stat)
            <div class="bg-white/5 p-8 rounded-2xl backdrop-blur-sm border border-white/10">
                <h2 class="text-5xl font-bold mb-4 bg-gradient-to-r from-blue-400 to-cyan-400 bg-clip-text text-transparent">
                    {{ $stat->value }}
                </h2>
                <p class="text-lg text-white/80">{{ $stat->description }}</p>
            </div>
            @endforeach
        </div>

        <div id="contacto" class="grid grid-cols-1 md:grid-cols-2 gap-8 mx-auto">
            <!-- Descripción (puedes hacerla dinámica también si lo necesitas) -->
            <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-8 border border-white/10 shadow-xl min-h-[400px] flex items-center">
                <p class="text-lg text-white/90 leading-relaxed text-center font-begum">
                {!! $contactDescription !!}
                </p>
            </div>
            
            <!-- Formulario de contacto actualizado -->
            <div class="bg-white/10 backdrop-blur-xl rounded-2xl p-8 shadow-2xl border border-white/10 min-h-[400px] flex items-center">
                <div class="w-full">
                    <h2 class="text-4xl font-bold text-white mb-8 font-begum">Contáctanos</h2>
                    <form wire:submit.prevent="submit" class="space-y-8 text-left">
                        @if(session()->has('message'))
                        <div class="bg-green-500/20 p-4 rounded-xl text-green-400">
                            {{ session('message') }}
                        </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="relative">
                                <input type="text" 
                                       wire:model="name"
                                       class="w-full px-6 py-4 rounded-xl bg-white/5 border border-white/20 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/30 placeholder-white/50 transition-all"
                                       placeholder="Nombre completo">
                                @error('name')<span class="text-red-400 text-sm">{{ $message }}</span>@enderror
                            </div>
                            <div class="relative">
                                <input type="email" 
                                       wire:model="email"
                                       class="w-full px-6 py-4 rounded-xl bg-white/5 border border-white/20 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/30 placeholder-white/50 transition-all"
                                       placeholder="Correo electrónico">
                                @error('email')<span class="text-red-400 text-sm">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="relative">
                            <textarea rows="5" 
                                      wire:model="message"
                                      class="w-full px-6 py-4 rounded-xl bg-white/5 border border-white/20 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/30 placeholder-white/50 transition-all"
                                      placeholder="Escribe tu mensaje..."></textarea>
                            @error('message')<span class="text-red-400 text-sm">{{ $message }}</span>@enderror
                        </div>
                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-400 hover:to-blue-500 text-white font-semibold py-4 px-8 rounded-xl transition-all duration-300 transform hover:scale-[1.02] shadow-lg hover:shadow-2xl">
                            Enviar Mensaje
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
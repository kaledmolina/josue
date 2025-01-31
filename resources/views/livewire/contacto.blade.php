<section class=" min-h-screen relative text-white py-28" style="background-image: url('{{ asset('Images/contador.png') }}');">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>
        
        <div class="container mx-auto text-center relative z-10 max-w-7xl px-4 lg:px-8">
            <!-- Estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-24">
                <div class="bg-white/5 p-8 rounded-2xl backdrop-blur-sm border border-white/10">
                    <h2 class="text-5xl font-bold mb-4 bg-gradient-to-r from-blue-400 to-cyan-400 bg-clip-text text-transparent">1,700,000</h2>
                    <p class="text-lg text-white/80">Seguidores en Instagram</p>
                </div>
                <div class="bg-white/5 p-8 rounded-2xl backdrop-blur-sm border border-white/10">
                    <h2 class="text-5xl font-bold mb-4 bg-gradient-to-r from-blue-400 to-cyan-400 bg-clip-text text-transparent">1,270,000</h2>
                    <p class="text-lg text-white/80">Suscriptores de YouTube</p>
                </div>
                <div class="bg-white/5 p-8 rounded-2xl backdrop-blur-sm border border-white/10">
                    <h2 class="text-5xl font-bold mb-4 bg-gradient-to-r from-blue-400 to-cyan-400 bg-clip-text text-transparent">56,900,000</h2>
                    <p class="text-lg text-white/80">Visualizaciones en YouTube</p>
                </div>
            </div>

            <div id="contacto" class="grid grid-cols-1 md:grid-cols-2 gap-8 mx-auto">
                <!-- Descripción -->
                <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-8 border border-white/10 shadow-xl min-h-[400px] flex items-center">
                    <p class="text-lg text-white/90 leading-relaxed text-center font-begum">
                        Sam Kolder es un reconocido cineasta autodidacta, mejor conocido por su estilo único de edición de video 
                        que influyó en una nueva era de creación de contenido. Desde que comenzó su carrera en 2014, el talento 
                        de Sam para la edición de video lo ha acumulado seguidores dedicados y también lo llevó a salir de gira 
                        con los Chainsmokers, convertirse en jefe de video en hermosos destinos y trabajar con marcas globales 
                        como YouTube, Canon, DJI, Gymshark y muchas más.
                    </p>
                </div>
                
                <!-- Formulario de contacto -->
                <div class="bg-white/10 backdrop-blur-xl rounded-2xl p-8 shadow-2xl border border-white/10 min-h-[400px] flex items-center">
                    <div class="w-full">
                        <h2 class="text-4xl font-bold text-white mb-8 font-begum">Contáctanos</h2>
                        <form class="space-y-8 text-left">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="relative">
                                    <input type="text" 
                                           class="w-full px-6 py-4 rounded-xl bg-white/5 border border-white/20 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/30 placeholder-white/50 transition-all"
                                           placeholder="Nombre completo">
                                </div>
                                <div class="relative">
                                    <input type="email" 
                                           class="w-full px-6 py-4 rounded-xl bg-white/5 border border-white/20 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/30 placeholder-white/50 transition-all"
                                           placeholder="Correo electrónico">
                                </div>
                            </div>
                            <div class="relative">
                                <textarea rows="5" 
                                          class="w-full px-6 py-4 rounded-xl bg-white/5 border border-white/20 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/30 placeholder-white/50 transition-all"
                                          placeholder="Escribe tu mensaje..."></textarea>
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
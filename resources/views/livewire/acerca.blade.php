<section class="relative min-h-screen">
    <!-- Fondo con imagen y blur -->
    <div class="absolute inset-0 w-full h-full bg-cover bg-center"
         style="background-image: url('{{ asset('Images/sobre-miweb.png') }}');">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>
    </div>

    <!-- Contenido -->
    <div class="relative z-10 container mx-auto px-4 py-24 text-white">
        <!-- Sección Hero -->
        <div class="flex flex-col lg:flex-row items-center gap-12">
            <!-- Foto de perfil con efecto -->
            <div class="w-full lg:w-1/3 relative group">
                <div class="absolute -inset-2 bg-gradient-to-r from-blue-400 to-cyan-400 rounded-full blur opacity-50 group-hover:opacity-75 transition-opacity"></div>
                <img src="{{ asset('Images/LateralCamara.png') }}" 
                     alt="Josue Molina"
                     class="rounded-full shadow-2xl w-64 h-64 object-cover mx-auto relative hover:scale-105 transition-transform">
            </div>

            <!-- Texto presentación -->
            <div class="w-full lg:w-2/3 text-center lg:text-left">
                <h1 class="text-5xl font-begum mb-6">
                    <span class="bg-gradient-to-r from-blue-400 to-cyan-400 text-transparent bg-clip-text">
                        {{ $content->hero_title }}
                    </span>
                </h1>
                <p class="text-xl text-white/80 mb-6 bg-white/5 p-6 rounded-xl backdrop-blur-sm border border-white/10">
                    {{ $content->hero_description }}
                </p>
            </div>
        </div>

        <!-- Sección Formación y Experiencia -->
        <div class="grid md:grid-cols-2 gap-12 mt-24">
            <!-- Educación -->
            <div class="card bg-white/5 shadow-xl backdrop-blur-sm border border-white/10">
                <div class="card-body">
                    <h2 class="card-title text-3xl font-begum text-white mb-4">
                        <i class="fas fa-graduation-cap mr-2 text-cyan-400"></i> Formación
                    </h2>
                    <div class="space-y-4">
                        <div class="border-l-4 border-cyan-400 pl-4 hover:bg-white/10 transition-colors p-3 rounded">
                            <h3 class="text-xl font-semibold text-white">{{ $content->education_title }}</h3>
                            <p class="text-white/80">{{ $content->education_institution }} ({{ $content->education_dates }})</p>
                            <p class="text-white/60 mt-2">{{ $content->education_details }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Experiencia -->
            <div class="card bg-white/5 shadow-xl backdrop-blur-sm border border-white/10">
                <div class="card-body">
                    <h2 class="card-title text-3xl font-begum text-white mb-4">
                        <i class="fas fa-briefcase mr-2 text-blue-400"></i> Experiencia
                    </h2>
                    <div class="space-y-4">
                        <div class="border-l-4 border-blue-400 pl-4 hover:bg-white/10 transition-colors p-3 rounded">
                            <h3 class="text-xl font-semibold text-white">{{ $content->experience_title }}</h3>
                            <p class="text-white/80">{{ $content->experience_company }} ({{ $content->experience_dates }})</p>
                            <p class="text-white/60 mt-2">{{ $content->experience_details }}</p>
                            <div class="mt-2 flex gap-2">
                                @foreach($content->skills ?? [] as $skill)
                                    <div class="badge bg-blue-400 text-white">{{ $skill }}</div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Llamado a la acción -->
        <div class="text-center mt-24">
            <h2 class="text-4xl font-begum text-white mb-8">
                <span class="bg-gradient-to-r from-blue-400 to-cyan-400 text-transparent bg-clip-text">
                    ¿Listo para trabajar juntos?
                </span>
            </h2>
            <a href="/contacto" class="btn bg-blue-400 text-white px-6 py-3 rounded-lg hover:scale-105 transition-transform">
                Contáctame
                <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</section>
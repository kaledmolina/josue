<section class="relative min-h-screen bg-gray-900 text-white overflow-hidden">
    <!-- Fondo con imagen y blur -->
    <div class="absolute inset-0 w-full h-full bg-cover bg-center fixed"
        style="background-image: url('{{ asset('Images/sobre-miweb.png') }}');">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>
    </div>

    <!-- Contenido -->
    <div class="relative z-10 container mx-auto px-4 py-32 lg:px-8">

        <!-- Sección Hero -->
        <div class="flex flex-col lg:flex-row items-center gap-12 mb-24">
            <!-- Foto de perfil con efecto -->
            <div data-aos="fade-right" class="w-full lg:w-1/3 relative group flex justify-center lg:justify-start">
                <div
                    class="absolute inset-0 w-64 h-64 mx-auto lg:mx-0 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full blur-2xl opacity-40 group-hover:opacity-60 transition-opacity duration-500">
                </div>
                <img src="{{ asset('Images/LateralCamara.png') }}" alt="Josue Molina"
                    class="rounded-full shadow-2xl w-64 h-64 object-cover relative z-10 border-4 border-white/10 hover:scale-105 transition-transform duration-500">
            </div>

            <!-- Texto presentación -->
            <div data-aos="fade-left" class="w-full lg:w-2/3 text-center lg:text-left">
                <h1 class="text-4xl md:text-5xl font-bold font-begum mb-6 leading-tight">
                    <span class="text-white">
                        {{ $content->hero_title }}
                    </span>
                </h1>
                <div
                    class="bg-black/60 backdrop-blur-xl border border-white/10 rounded-3xl shadow-2xl p-6 md:p-8 transform transition-all duration-300 hover:bg-black/70 group">
                    <p class="text-base md:text-lg text-gray-200 leading-relaxed font-light">
                        {{ $content->hero_description }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Sección Formación y Experiencia -->
        <div class="grid md:grid-cols-2 gap-8 lg:gap-12">
            <!-- Educación -->
            <div data-aos="fade-up"
                class="bg-black/60 backdrop-blur-xl border border-white/10 rounded-3xl shadow-2xl p-6 md:p-8 transform transition-all duration-300 hover:bg-black/70 group">
                <h2 class="text-2xl md:text-3xl font-begum text-white mb-6 flex items-center gap-3">
                    <i class="fas fa-graduation-cap text-blue-400"></i> Formación
                </h2>
                <div class="relative pl-6 border-l-2 border-blue-500/30 space-y-6">
                    <div class="relative">
                        <span
                            class="absolute -left-[29px] top-1.5 w-4 h-4 rounded-full bg-blue-500 border-2 border-gray-900"></span>
                        <h3 class="text-lg font-semibold text-white">{{ $content->education_title }}</h3>
                        <p class="text-blue-300 text-sm mb-2">{{ $content->education_institution }} |
                            {{ $content->education_dates }}
                        </p>
                        <p class="text-gray-400 text-sm leading-relaxed">{{ $content->education_details }}</p>
                    </div>
                </div>
            </div>

            <!-- Experiencia -->
            <div data-aos="fade-up" data-aos-delay="100"
                class="bg-black/60 backdrop-blur-xl border border-white/10 rounded-3xl shadow-2xl p-6 md:p-8 transform transition-all duration-300 hover:bg-black/70 group">
                <h2 class="text-2xl md:text-3xl font-begum text-white mb-6 flex items-center gap-3">
                    <i class="fas fa-briefcase text-purple-400"></i> Experiencia
                </h2>
                <div class="relative pl-6 border-l-2 border-purple-500/30 space-y-6">
                    <div class="relative">
                        <span
                            class="absolute -left-[29px] top-1.5 w-4 h-4 rounded-full bg-purple-500 border-2 border-gray-900"></span>
                        <h3 class="text-lg font-semibold text-white">{{ $content->experience_title }}</h3>
                        <p class="text-purple-300 text-sm mb-2">{{ $content->experience_company }} |
                            {{ $content->experience_dates }}
                        </p>
                        <p class="text-gray-400 text-sm leading-relaxed mb-6">{{ $content->experience_details }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Habilidades (Skills) -->
        <div data-aos="fade-up"
            class="mt-12 bg-black/60 backdrop-blur-xl border border-white/10 rounded-3xl shadow-2xl p-6 md:p-10 transform transition-all duration-300 hover:bg-black/70 group">
            <h2 class="text-3xl font-begum text-white mb-8 text-center md:text-left">
                Habilidades <span class="text-gray-400">Profesionales</span>
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @php
                    $customSkills = [
                        'Producción audiovisual',
                        'Edición y postproducción',
                        'Fotografía',
                        'Diseño gráfico y contenido digital',
                        'Gestión de redes sociales',
                        'Web y comunicación digital',
                        'Música y producción sonora'
                    ];
                @endphp

                @foreach($customSkills as $skill)
                    <div
                        class="bg-white/5 hover:bg-white/10 border border-white/5 hover:border-white/20 rounded-xl p-4 transition-all duration-300 flex items-center gap-3 group">
                        <div class="w-2 h-2 rounded-full bg-white group-hover:scale-150 transition-transform"></div>
                        <span class="text-gray-200 font-medium text-sm group-hover:text-white">{{ $skill }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Llamado a la acción -->
        <div data-aos="zoom-in" class="text-center mt-20 mb-10">
            <h2 class="text-3xl font-begum text-white mb-8">
                <span class="bg-gradient-to-r from-blue-400 to-cyan-400 text-transparent bg-clip-text">
                    ¿Listo para trabajar juntos?
                </span>
            </h2>
            <a href="/contacto"
                class="inline-flex items-center px-8 py-3 bg-white text-black font-bold rounded-full hover:bg-gray-200 transition-all transform hover:-translate-y-1 hover:shadow-lg">
                Contáctame
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3">
                    </path>
                </svg>
            </a>
        </div>
    </div>
</section>
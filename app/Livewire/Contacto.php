<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Statistic;
use App\Models\Contact;
use App\Models\TextContent;
use App\Services\SocialMediaService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class Contacto extends Component
{
    public $name;
    public $email;
    public $message;
    public $isUpdatingStats = false;
    
    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email',
        'message' => 'required|min:10'
    ];

    public function mount()
    {
        // Verificar si necesitamos actualizar las estadísticas
        $this->checkAndUpdateStatsIfNeeded();
    }

    public function render()
    {
        // Obtener estadísticas ordenadas por título para mostrar en orden específico
        $stats = Statistic::whereIn('title', [
            'instagram_followers', 
            'youtube_subscribers', 
            'youtube_views'
        ])->get()->sortBy(function($stat) {
            // Definir el orden de aparición
            $order = [
                'instagram_followers' => 1,
                'youtube_subscribers' => 2,
                'youtube_views' => 3
            ];
            return $order[$stat->title] ?? 999;
        });

        $contactDescription = TextContent::where('key', 'contact-description')->first()?->content;
        
        // Obtener información de la última actualización
        $lastUpdate = $this->getLastUpdateInfo();
        
        return view('livewire.contacto', [
            'stats' => $stats,
            'contactDescription' => $contactDescription,
            'lastUpdate' => $lastUpdate,
            'isUpdatingStats' => $this->isUpdatingStats
        ]);
    }

    /**
     * Verificar si necesitamos actualizar las estadísticas hoy
     */
    private function checkAndUpdateStatsIfNeeded(): void
    {
        $cacheKey = 'stats_updated_today_' . now()->format('Y-m-d');
        
        // Si ya se actualizó hoy, no hacer nada
        if (Cache::has($cacheKey)) {
            return;
        }

        // Verificar si hay estadísticas y cuándo fue la última actualización
        $lastUpdateStat = Statistic::where('title', 'last_stats_update')->first();
        
        $shouldUpdate = false;
        
        if (!$lastUpdateStat) {
            // No hay registro de actualización previa
            $shouldUpdate = true;
        } else {
            // Verificar si la última actualización fue hoy
            $lastUpdateDate = Carbon::parse($lastUpdateStat->value)->format('Y-m-d');
            $today = now()->format('Y-m-d');
            
            if ($lastUpdateDate !== $today) {
                $shouldUpdate = true;
            }
        }

        if ($shouldUpdate) {
            $this->updateStatsInBackground();
        }
    }

    /**
     * Actualizar estadísticas en segundo plano
     */
    private function updateStatsInBackground(): void
    {
        try {
            $this->isUpdatingStats = true;
            
            // Marcar que ya intentamos actualizar hoy (para evitar múltiples intentos)
            $cacheKey = 'stats_updated_today_' . now()->format('Y-m-d');
            Cache::put($cacheKey, true, now()->endOfDay());
            
            // Ejecutar actualización de forma asíncrona si es posible
            if (function_exists('fastcgi_finish_request')) {
                // Para entornos PHP-FPM
                $this->performStatsUpdate();
                fastcgi_finish_request();
            } else {
                // Ejecución normal
                $this->performStatsUpdate();
            }
            
        } catch (\Exception $e) {
            \Log::error('Error en actualización automática de estadísticas', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        } finally {
            $this->isUpdatingStats = false;
        }
    }

    /**
     * Realizar la actualización de estadísticas
     */
    private function performStatsUpdate(): void
    {
        $socialMediaService = app(SocialMediaService::class);
        $startTime = now();
        
        \Log::info('🚀 Iniciando actualización automática de estadísticas');
        
        $results = [];
        
        // Actualizar Instagram
        $instagramFollowers = $socialMediaService->getInstagramFollowers();
        if ($instagramFollowers !== null) {
            $formattedFollowers = $socialMediaService->formatNumber($instagramFollowers);
            
            Statistic::updateOrCreate(
                ['title' => 'instagram_followers'],
                [
                    'value' => $formattedFollowers,
                    'raw_value' => $instagramFollowers,
                    'description' => 'Seguidores en Instagram',
                    'updated_at' => now()
                ]
            );
            
            $results['instagram'] = ['success' => true, 'followers' => $instagramFollowers];
            \Log::info("✅ Instagram actualizado: {$formattedFollowers} seguidores");
        } else {
            $results['instagram'] = ['success' => false];
            \Log::warning('⚠️ No se pudo actualizar Instagram');
        }

        // Actualizar YouTube
        $youtubeStats = $socialMediaService->getYouTubeStats();
        if ($youtubeStats !== null) {
            // Suscriptores
            $formattedSubs = $socialMediaService->formatNumber($youtubeStats['subscribers']);
            Statistic::updateOrCreate(
                ['title' => 'youtube_subscribers'],
                [
                    'value' => $formattedSubs,
                    'raw_value' => $youtubeStats['subscribers'],
                    'description' => 'Suscriptores en YouTube',
                    'updated_at' => now()
                ]
            );

            // Vistas
            $formattedViews = $socialMediaService->formatNumber($youtubeStats['views']);
            Statistic::updateOrCreate(
                ['title' => 'youtube_views'],
                [
                    'value' => $formattedViews,
                    'raw_value' => $youtubeStats['views'],
                    'description' => 'Vistas en YouTube',
                    'updated_at' => now()
                ]
            );

            $results['youtube'] = ['success' => true, 'stats' => $youtubeStats];
            \Log::info("✅ YouTube actualizado: {$formattedSubs} suscriptores, {$formattedViews} vistas");
        } else {
            $results['youtube'] = ['success' => false];
            \Log::warning('⚠️ No se pudo actualizar YouTube');
        }

        // Registrar la actualización
        $successCount = collect($results)->where('success', true)->count();
        $totalCount = count($results);
        
        Statistic::updateOrCreate(
            ['title' => 'last_stats_update'],
            [
                'value' => $startTime->format('Y-m-d H:i:s'),
                'description' => "Actualización automática ({$successCount}/{$totalCount} exitosas)",
                'updated_at' => now()
            ]
        );

        $duration = $startTime->diffInSeconds(now());
        \Log::info("✅ Actualización automática completada en {$duration} segundos");
    }

    /**
     * Obtener información de la última actualización
     */
    private function getLastUpdateInfo(): ?array
    {
        $lastUpdateStat = Statistic::where('title', 'last_stats_update')->first();
        
        if (!$lastUpdateStat) {
            return null;
        }
        
        $lastUpdate = Carbon::parse($lastUpdateStat->value);
        
        return [
            'datetime' => $lastUpdate,
            'formatted' => $lastUpdate->format('d/m/Y H:i'),
            'human' => $lastUpdate->diffForHumans(),
            'is_today' => $lastUpdate->isToday(),
            'description' => $lastUpdateStat->description
        ];
    }

    /**
     * Método para forzar actualización manual (botón en el frontend)
     */
    public function forceRefreshStats()
    {
        try {
            $this->isUpdatingStats = true;
            
            // Limpiar el cache para permitir nueva actualización
            $cacheKey = 'stats_updated_today_' . now()->format('Y-m-d');
            Cache::forget($cacheKey);
            
            // Limpiar cache de las APIs
            $socialMediaService = app(SocialMediaService::class);
            $socialMediaService->clearCache();
            
            // Realizar actualización
            $this->performStatsUpdate();
            
            session()->flash('stats-updated', 'Estadísticas actualizadas manualmente');
            
            // Emitir evento para actualizar la vista
            $this->dispatch('statsUpdated');
            
        } catch (\Exception $e) {
            session()->flash('stats-error', 'Error al actualizar estadísticas: ' . $e->getMessage());
            \Log::error('Error en actualización manual', ['error' => $e->getMessage()]);
        } finally {
            $this->isUpdatingStats = false;
        }
    }

    /**
     * Verificar si las estadísticas están desactualizadas
     */
    public function areStatsOutdated(): bool
    {
        $lastUpdateStat = Statistic::where('title', 'last_stats_update')->first();
        
        if (!$lastUpdateStat) {
            return true; // No hay actualizaciones previas
        }
        
        $lastUpdate = Carbon::parse($lastUpdateStat->value);
        return !$lastUpdate->isToday();
    }

    public function submit()
    {
        $this->validate();

        Contact::create([
            'name' => $this->name,
            'email' => $this->email,
            'message' => $this->message
        ]);

        // Opcional: Enviar email
        // Mail::to('tucorreo@example.com')->send(new ContactFormMail($this->all()));

        $this->resetForm();
        session()->flash('message', '¡Mensaje enviado correctamente!');
    }

    private function resetForm()
    {
        $this->name = '';
        $this->email = '';
        $this->message = '';
    }
}
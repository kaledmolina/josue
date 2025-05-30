<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SocialMediaService;
use App\Models\Statistic;

class UpdateSocialMediaStats extends Command
{
    protected $signature = 'stats:update-social-media';
    protected $description = 'Actualizar estadísticas de redes sociales desde las APIs';

    public function handle()
    {
        $this->info('Actualizando estadísticas de redes sociales...');
        
        $socialMediaService = app(SocialMediaService::class);
        
        try {
            // Verificar configuración
            $config = $socialMediaService->checkConfiguration();
            
            if (!$config['instagram_configured']) {
                $this->warn('Instagram no está configurado correctamente');
            }
            
            if (!$config['youtube_configured']) {
                $this->warn('YouTube no está configurado correctamente');
            }

            // Actualizar Instagram
            if ($config['instagram_configured']) {
                $this->info('Actualizando Instagram...');
                $instagramFollowers = $socialMediaService->getInstagramFollowers();
                
                if ($instagramFollowers !== null) {
                    $formattedFollowers = $socialMediaService->formatNumber($instagramFollowers);
                    Statistic::updateOrCreate(
                        ['title' => 'instagram_followers'],
                        [
                            'value' => $formattedFollowers,
                            'description' => 'Seguidores en Instagram'
                        ]
                    );
                    $this->info("Instagram actualizado: {$formattedFollowers} seguidores");
                } else {
                    $this->error('Error al obtener datos de Instagram');
                }
            }

            // Actualizar YouTube
            if ($config['youtube_configured']) {
                $this->info('Actualizando YouTube...');
                $youtubeStats = $socialMediaService->getYouTubeStats();
                
                if ($youtubeStats !== null) {
                    // Suscriptores
                    $formattedSubscribers = $socialMediaService->formatNumber($youtubeStats['subscribers']);
                    Statistic::updateOrCreate(
                        ['title' => 'youtube_subscribers'],
                        [
                            'value' => $formattedSubscribers,
                            'description' => 'Suscriptores en YouTube'
                        ]
                    );

                    // Vistas
                    $formattedViews = $socialMediaService->formatNumber($youtubeStats['views']);
                    Statistic::updateOrCreate(
                        ['title' => 'youtube_views'],
                        [
                            'value' => $formattedViews,
                            'description' => 'Vistas en YouTube'
                        ]
                    );

                    $this->info("YouTube actualizado: {$formattedSubscribers} suscriptores, {$formattedViews} vistas");
                } else {
                    $this->error('Error al obtener datos de YouTube');
                }
            }

            $this->info('✅ Actualización completada');
            
        } catch (\Exception $e) {
            $this->error('Error durante la actualización: ' . $e->getMessage());
        }
    }
}
<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class SocialMediaService
{
    protected $instagramToken;
    protected $youtubeApiKey;
    protected $youtubeChannelId;
    
    public function __construct()
    {
        $this->instagramToken = config('services.instagram.access_token');
        $this->youtubeApiKey = config('services.youtube.api_key');
        $this->youtubeChannelId = config('services.youtube.channel_id');
    }

    /**
     * Obtener seguidores de Instagram
     */
    public function getInstagramFollowers(): ?int
    {
        try {
            // Cachear por 1 hora para evitar exceso de requests
            return Cache::remember('instagram_followers', 3600, function () {
                
                if (!$this->instagramToken) {
                    Log::warning('Instagram access token no configurado');
                    return null;
                }

                $response = Http::timeout(30)->get('https://graph.instagram.com/me', [
                    'fields' => 'followers_count',
                    'access_token' => $this->instagramToken
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    return $data['followers_count'] ?? null;
                }

                Log::error('Error al obtener seguidores de Instagram', [
                    'status' => $response->status(),
                    'response' => $response->body()
                ]);

                return null;
            });

        } catch (\Exception $e) {
            Log::error('Excepción al obtener seguidores de Instagram: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Obtener estadísticas de YouTube
     */
    public function getYouTubeStats(): ?array
    {
        try {
            // Cachear por 1 hora
            return Cache::remember('youtube_stats', 3600, function () {
                
                if (!$this->youtubeApiKey || !$this->youtubeChannelId) {
                    Log::warning('YouTube API key o Channel ID no configurados');
                    return null;
                }

                $response = Http::timeout(30)->get('https://www.googleapis.com/youtube/v3/channels', [
                    'part' => 'statistics',
                    'id' => $this->youtubeChannelId,
                    'key' => $this->youtubeApiKey
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    
                    if (isset($data['items'][0]['statistics'])) {
                        $stats = $data['items'][0]['statistics'];
                        
                        return [
                            'subscribers' => (int) ($stats['subscriberCount'] ?? 0),
                            'views' => (int) ($stats['viewCount'] ?? 0),
                            'videos' => (int) ($stats['videoCount'] ?? 0)
                        ];
                    }
                }

                Log::error('Error al obtener estadísticas de YouTube', [
                    'status' => $response->status(),
                    'response' => $response->body()
                ]);

                return null;
            });

        } catch (\Exception $e) {
            Log::error('Excepción al obtener estadísticas de YouTube: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Formatear número para mostrar (ej: 1.2K, 1.5M)
     */
    public function formatNumber(int $number): string
    {
        if ($number >= 1000000) {
            return round($number / 1000000, 1) . 'M';
        } elseif ($number >= 1000) {
            return round($number / 1000, 1) . 'K';
        }
        
        return number_format($number);
    }

    /**
     * Limpiar cache de redes sociales
     */
    public function clearCache(): void
    {
        Cache::forget('instagram_followers');
        Cache::forget('youtube_stats');
    }

    /**
     * Obtener datos de Instagram Business (alternativo)
     * Requiere Instagram Business Account y Facebook App
     */
    public function getInstagramBusinessStats(): ?array
    {
        try {
            if (!$this->instagramToken) {
                return null;
            }

            return Cache::remember('instagram_business_stats', 3600, function () {
                $response = Http::timeout(30)->get('https://graph.facebook.com/v18.0/me/accounts', [
                    'access_token' => $this->instagramToken
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    // Procesar datos según la estructura de respuesta de Instagram Business
                    // Esta parte dependerá de tu configuración específica
                    return $data;
                }

                return null;
            });

        } catch (\Exception $e) {
            Log::error('Error al obtener estadísticas de Instagram Business: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Obtener estadísticas de TikTok (si necesitas en el futuro)
     */
    public function getTikTokStats(): ?array
    {
        // Implementación futura para TikTok API
        return null;
    }

    /**
     * Verificar si las APIs están configuradas correctamente
     */
    public function checkConfiguration(): array
    {
        return [
            'instagram_configured' => !empty($this->instagramToken),
            'youtube_configured' => !empty($this->youtubeApiKey) && !empty($this->youtubeChannelId)
        ];
    }

    /**
     * Actualizar todas las estadísticas de una vez
     */
    public function updateAllStats(): array
    {
        $results = [];

        // Instagram
        $instagramFollowers = $this->getInstagramFollowers();
        $results['instagram'] = [
            'success' => $instagramFollowers !== null,
            'data' => $instagramFollowers
        ];

        // YouTube
        $youtubeStats = $this->getYouTubeStats();
        $results['youtube'] = [
            'success' => $youtubeStats !== null,
            'data' => $youtubeStats
        ];

        return $results;
    }
}
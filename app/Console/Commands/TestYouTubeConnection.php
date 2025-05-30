<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Services\SocialMediaService;

class TestYouTubeConnection extends Command
{
    protected $signature = 'test:youtube {--show-full-response : Mostrar respuesta completa de la API}';
    protected $description = 'Verificar la conexión y configuración de YouTube API';

    public function handle()
    {
        $this->info('🔍 Verificando conexión con YouTube API...');
        $this->newLine();

        // Verificar variables de entorno
        $this->checkEnvironmentVariables();
        
        // Verificar configuración del servicio
        $this->checkServiceConfiguration();
        
        // Hacer petición de prueba
        $this->testApiConnection();
        
        // Probar el servicio completo
        $this->testSocialMediaService();
    }

    private function checkEnvironmentVariables()
    {
        $this->info('📋 Verificando variables de entorno:');
        
        $apiKey = config('services.youtube.api_key');
        $channelId = config('services.youtube.channel_id');
        
        if (empty($apiKey)) {
            $this->error('❌ YOUTUBE_API_KEY no está configurada en .env');
        } else {
            $this->info('✅ YOUTUBE_API_KEY configurada');
            $this->line('   Clave: ' . substr($apiKey, 0, 10) . '...' . substr($apiKey, -10));
        }
        
        if (empty($channelId)) {
            $this->error('❌ YOUTUBE_CHANNEL_ID no está configurada en .env');
        } else {
            $this->info('✅ YOUTUBE_CHANNEL_ID configurada');
            $this->line('   Channel ID: ' . $channelId);
        }
        
        $this->newLine();
    }

    private function checkServiceConfiguration()
    {
        $this->info('⚙️ Verificando configuración del SocialMediaService:');
        
        try {
            $service = app(SocialMediaService::class);
            $config = $service->checkConfiguration();
            
            if ($config['youtube_configured']) {
                $this->info('✅ SocialMediaService configurado correctamente para YouTube');
            } else {
                $this->error('❌ SocialMediaService NO está configurado para YouTube');
            }
            
        } catch (\Exception $e) {
            $this->error('❌ Error al instanciar SocialMediaService: ' . $e->getMessage());
        }
        
        $this->newLine();
    }

    private function testApiConnection()
    {
        $this->info('🌐 Probando conexión directa con YouTube API:');
        
        $apiKey = config('services.youtube.api_key');
        $channelId = config('services.youtube.channel_id');
        
        if (empty($apiKey) || empty($channelId)) {
            $this->error('❌ No se puede probar la conexión: faltan credenciales');
            return;
        }

        try {
            $this->line('   Realizando petición a YouTube API...');
            
            $response = Http::timeout(30)->get('https://www.googleapis.com/youtube/v3/channels', [
                'part' => 'snippet,statistics',
                'id' => $channelId,
                'key' => $apiKey
            ]);

            $this->line('   Status Code: ' . $response->status());
            
            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['items']) && count($data['items']) > 0) {
                    $channel = $data['items'][0];
                    $this->info('✅ Conexión exitosa!');
                    
                    // Mostrar información del canal
                    $this->line('   📺 Canal: ' . ($channel['snippet']['title'] ?? 'N/A'));
                    $this->line('   📊 Suscriptores: ' . number_format($channel['statistics']['subscriberCount'] ?? 0));
                    $this->line('   👀 Vistas totales: ' . number_format($channel['statistics']['viewCount'] ?? 0));
                    $this->line('   🎥 Videos: ' . number_format($channel['statistics']['videoCount'] ?? 0));
                    
                    // Mostrar respuesta completa si se solicita
                    if ($this->option('show-full-response')) {
                        $this->newLine();
                        $this->line('📄 Respuesta completa de la API:');
                        $this->line(json_encode($data, JSON_PRETTY_PRINT));
                    }
                    
                } else {
                    $this->error('❌ No se encontró el canal con el ID proporcionado');
                    $this->line('   Verifica que el YOUTUBE_CHANNEL_ID sea correcto');
                }
                
            } else {
                $this->error('❌ Error en la respuesta de la API:');
                $errorData = $response->json();
                
                if (isset($errorData['error'])) {
                    $this->line('   Código: ' . ($errorData['error']['code'] ?? 'N/A'));
                    $this->line('   Mensaje: ' . ($errorData['error']['message'] ?? 'N/A'));
                    
                    // Sugerencias específicas según el error
                    $this->provideTroubleshootingSuggestions($errorData['error']);
                }
                
                if ($this->option('show-full-response')) {
                    $this->newLine();
                    $this->line('📄 Respuesta de error completa:');
                    $this->line($response->body());
                }
            }
            
        } catch (\Exception $e) {
            $this->error('❌ Excepción durante la conexión: ' . $e->getMessage());
        }
        
        $this->newLine();
    }

    private function testSocialMediaService()
    {
        $this->info('🔧 Probando SocialMediaService:');
        
        try {
            $service = app(SocialMediaService::class);
            
            $this->line('   Obteniendo estadísticas...');
            $stats = $service->getYouTubeStats();
            
            if ($stats !== null) {
                $this->info('✅ SocialMediaService funcionando correctamente');
                $this->line('   Suscriptores: ' . number_format($stats['subscribers']));
                $this->line('   Vistas: ' . number_format($stats['views']));
                $this->line('   Videos: ' . number_format($stats['videos']));
                
                // Probar formateo
                $this->newLine();
                $this->line('   🎨 Números formateados:');
                $this->line('   Suscriptores: ' . $service->formatNumber($stats['subscribers']));
                $this->line('   Vistas: ' . $service->formatNumber($stats['views']));
                
            } else {
                $this->error('❌ SocialMediaService devolvió null');
            }
            
        } catch (\Exception $e) {
            $this->error('❌ Error en SocialMediaService: ' . $e->getMessage());
        }
        
        $this->newLine();
    }

    private function provideTroubleshootingSuggestions($error)
    {
        $this->newLine();
        $this->line('💡 Sugerencias de solución:');
        
        switch ($error['code'] ?? null) {
            case 400:
                $this->line('   • Verifica que el YOUTUBE_CHANNEL_ID sea válido');
                $this->line('   • Asegúrate de que el Channel ID no contenga espacios extra');
                break;
                
            case 403:
                if (str_contains($error['message'] ?? '', 'quota')) {
                    $this->line('   • Has excedido la cuota diaria de la API');
                    $this->line('   • Espera hasta mañana o solicita más cuota en Google Cloud Console');
                } else {
                    $this->line('   • Verifica que la YOUTUBE_API_KEY sea válida');
                    $this->line('   • Asegúrate de que YouTube Data API v3 esté habilitada');
                    $this->line('   • Verifica las restricciones de la API key');
                }
                break;
                
            case 404:
                $this->line('   • El canal no existe o no es público');
                $this->line('   • Verifica el YOUTUBE_CHANNEL_ID');
                break;
                
            default:
                $this->line('   • Revisa la documentación de YouTube Data API');
                $this->line('   • Verifica tu configuración en Google Cloud Console');
        }
        
        $this->newLine();
        $this->line('📚 Recursos útiles:');
        $this->line('   • Google Cloud Console: https://console.cloud.google.com');
        $this->line('   • YouTube Data API: https://developers.google.com/youtube/v3');
        $this->line('   • Encontrar Channel ID: https://www.youtube.com/@tu-canal -> Ver código fuente -> buscar "channelId"');
    }
}
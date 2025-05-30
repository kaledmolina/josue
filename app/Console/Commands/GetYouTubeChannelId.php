<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GetYouTubeChannelId extends Command
{
    protected $signature = 'youtube:get-channel-id {username : El username del canal (sin @)}';
    protected $description = 'Obtener el Channel ID de YouTube usando el username del canal';

    public function handle()
    {
        $username = $this->argument('username');
        $apiKey = config('services.youtube.api_key');
        
        if (empty($apiKey)) {
            $this->error('❌ YOUTUBE_API_KEY no está configurada');
            return;
        }
        
        $this->info("🔍 Buscando Channel ID para: @{$username}");
        
        try {
            // Buscar por username
            $response = Http::timeout(30)->get('https://www.googleapis.com/youtube/v3/channels', [
                'part' => 'id,snippet',
                'forUsername' => $username,
                'key' => $apiKey
            ]);
            
            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['items']) && count($data['items']) > 0) {
                    $channel = $data['items'][0];
                    $channelId = $channel['id'];
                    $channelTitle = $channel['snippet']['title'];
                    
                    $this->info('✅ Canal encontrado!');
                    $this->line("   📺 Nombre: {$channelTitle}");
                    $this->line("   🆔 Channel ID: {$channelId}");
                    $this->newLine();
                    $this->line('📋 Agrega esta línea a tu archivo .env:');
                    $this->line("YOUTUBE_CHANNEL_ID={$channelId}");
                    
                } else {
                    $this->error('❌ No se encontró el canal');
                    $this->line('💡 Intenta con estos métodos alternativos:');
                    $this->line('   1. Ve a tu canal de YouTube');
                    $this->line('   2. Clic derecho -> Ver código fuente');
                    $this->line('   3. Busca "channelId" en el código');
                    $this->line('   4. O usa: https://commentpicker.com/youtube-channel-id.php');
                }
            } else {
                $this->error('❌ Error en la API: ' . $response->status());
            }
            
        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
        }
    }
}
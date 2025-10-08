<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Video extends Model
{
    use HasFactory;
    
    protected $appends = ['embed_html', 'is_vertical'];

    protected $fillable = [
        'title',
        'url',
        'description',
        'alignment',
    ];

    public function getIsVerticalAttribute(): bool
    {
        $url = $this->url;
        return str_contains($url, 'instagram.com/p/') ||
               str_contains($url, 'instagram.com/reel/') ||
               str_contains($url, 'youtube.com/shorts/') ||
               str_contains($url, 'tiktok.com');
    }

    public function getEmbedHtmlAttribute(): string
    {
        $url = $this->url;

        // --- Instagram ---
        if (str_contains($url, 'instagram.com')) {
            $cleanUrl = rtrim($url, '/') . '/';
            
            // Embed minimalista de Instagram - solo video
            return '<blockquote class="instagram-media" 
                        data-instgrm-permalink="' . $cleanUrl . '" 
                        data-instgrm-version="14"
                        data-instgrm-captioned
                        style="
                            background: transparent;
                            border: 0;
                            margin: 0;
                            padding: 0;
                            width: 100%;
                            max-width: 100%;
                        "></blockquote>';
        }

        // --- YouTube & Shorts ---
        if (str_contains($url, 'youtu.be/') || str_contains($url, 'youtube.com/')) {
            $videoId = $this->extractYoutubeId($url);
            
            if ($videoId) {
                $embedUrl = 'https://www.youtube.com/embed/' . $videoId;
                
                $params = http_build_query([
                    'autoplay' => 0,
                    'modestbranding' => 1,
                    'rel' => 0,
                    'showinfo' => 0,
                ]);
                
                return sprintf(
                    '<iframe src="%s?%s" class="w-full h-full rounded-lg" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
                    $embedUrl,
                    $params
                );
            }
        }
        
        // --- Vimeo ---
        if (str_contains($url, 'vimeo.com')) {
            $videoId = last(explode('/', parse_url($url, PHP_URL_PATH)));
            
            if ($videoId) {
                return sprintf(
                    '<iframe src="https://player.vimeo.com/video/%s?title=0&byline=0&portrait=0" class="w-full h-full rounded-lg" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>',
                    $videoId
                );
            }
        }

        // --- TikTok ---
        if (str_contains($url, 'tiktok.com')) {
            preg_match('/video\/(\d+)/', $url, $matches);
            $videoId = $matches[1] ?? null;
            
            if ($videoId) {
                return sprintf(
                    '<blockquote class="tiktok-embed" cite="%s" data-video-id="%s" style="max-width: 605px; min-width: 325px; margin: 0 auto;"><section></section></blockquote><script async src="https://www.tiktok.com/embed.js"></script>',
                    $url,
                    $videoId
                );
            }
        }

        return '<div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-800 to-gray-900 text-white rounded-lg p-8"><p class="text-center">⚠️ No se pudo cargar el video<br><span class="text-sm text-gray-400 mt-2 block">URL no soportada</span></p></div>';
    }

    /**
     * Extrae el ID de video de diferentes formatos de URL de YouTube
     */
    private function extractYoutubeId(string $url): ?string
    {
        if (str_contains($url, 'youtube.com/shorts/')) {
            return last(explode('/shorts/', explode('?', $url)[0]));
        }
        
        $patterns = [
            '/youtube\.com\/watch\?v=([^&]+)/',
            '/youtube\.com\/embed\/([^?]+)/',
            '/youtu\.be\/([^?]+)/',
            '/youtube\.com\/v\/([^?]+)/',
        ];
        
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return $matches[1];
            }
        }
        
        return null;
    }
}
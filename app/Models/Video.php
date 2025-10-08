<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Video extends Model
{
    use HasFactory;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['source', 'embed_html', 'is_vertical'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'url',
        'description',
        'alignment',
    ];

    /**
     * Detecta la plataforma del video basado en la URL.
     *
     * @return string
     */
    public function getSourceAttribute(): string
    {
        $url = $this->url;
        if (str_contains($url, 'youtube.com') || str_contains($url, 'youtu.be')) {
            return 'youtube';
        }
        if (str_contains($url, 'vimeo.com')) {
            return 'vimeo';
        }
        if (str_contains($url, 'instagram.com')) {
            return 'instagram';
        }
        return 'unknown';
    }

    /**
     * Determina si el video tiene un formato vertical (como un Short o Reel).
     *
     * @return bool
     */
    public function getIsVerticalAttribute(): bool
    {
        if ($this->source === 'instagram') {
            return true;
        }

        if ($this->source === 'youtube' && str_contains($this->url, '/shorts/')) {
            return true;
        }

        return false;
    }


    /**
     * Genera el código HTML para incrustar el video según la plataforma.
     *
     * @return string
     */
    public function getEmbedHtmlAttribute(): string
    {
        switch ($this->source) {
            case 'youtube':
                return $this->generateYoutubeEmbed();
            case 'vimeo':
                return $this->generateVimeoEmbed();
            case 'instagram':
                return $this->generateInstagramEmbed();
            default:
                return '<div class="w-full h-full bg-black/50 flex items-center justify-center text-white rounded-lg"><p>Video no soportado.</p></div>';
        }
    }

    private function generateYoutubeEmbed(): string
    {
        // Regex mejorada para capturar IDs de videos normales, shorts y embeds.
        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?|shorts)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/', $this->url, $matches);
        $videoId = $matches[1] ?? null;

        if (!$videoId) {
            return '<div class="w-full h-full bg-black/50 flex items-center justify-center text-white rounded-lg p-4 text-center"><p>ID de video de YouTube inválido. Verifique la URL.</p></div>';
        }
        
        $embedUrl = 'https://www.youtube.com/embed/' . $videoId;
        return '<iframe class="w-full h-full rounded-lg shadow-xl" src="' . $embedUrl . '" title="' . $this->title . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
    }

    private function generateVimeoEmbed(): string
    {
        preg_match('/vimeo\.com\/(?:video\/)?(\d+)/', $this->url, $matches);
        $videoId = $matches[1] ?? null;

        if (!$videoId) return '<p>ID de video de Vimeo inválido.</p>';

        $embedUrl = 'https://player.vimeo.com/video/' . $videoId;
        return '<iframe class="w-full h-full rounded-lg shadow-xl" src="' . $embedUrl . '" title="' . $this->title . '" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>';
    }

    private function generateInstagramEmbed(): string
    {
        // Instagram requiere un script y un blockquote, por lo que devolvemos todo el HTML.
        // La URL debe ser del tipo: https://www.instagram.com/p/C3XYZ123abc/
        return '<iframe class="w-full h-full rounded-lg" src="' . rtrim($this->url, '/') . '/embed" frameborder="0" scrolling="no" allowtransparency="true"></iframe>';
    }
}
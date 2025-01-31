<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Video extends Model
{
    use HasFactory;
    protected $appends = ['embed_url'];


    protected $fillable = [
        'title',
        'url',
        'description',
        'alignment',
    ];
    public function getEmbedUrlAttribute()
    {
        $url = $this->url;
        
        // Si ya es una URL de embed
        if (str_contains($url, 'embed')) {
            return $url;
        }
        
        // Extraer el ID del video de diferentes formatos
        parse_str(parse_url($url, PHP_URL_QUERY), $query);
        $videoId = $query['v'] ?? null;
        
        // Para enlaces acortados (youtu.be)
        if (!$videoId) {
            $path = parse_url($url, PHP_URL_PATH);
            $videoId = ltrim($path, '/');
        }
        
        return 'https://www.youtube.com/embed/'.$videoId;
    }
}

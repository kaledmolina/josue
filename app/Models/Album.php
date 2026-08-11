<?php

namespace App\Models;

use App\Support\ImageUrl;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $fillable = [
        'title',
        'path',
        'disk',
        'cover_image_url',
    ];

    protected $appends = ['cover_url'];

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function getCoverUrlAttribute()
    {
        // Si el álbum tiene portada por URL externa, la usamos directamente.
        // Los enlaces de Google Drive se convierten a su formato directo de imagen.
        if ($cover = ImageUrl::normalize($this->cover_image_url)) {
            return $cover;
        }

        return route('album.cover', $this);
    }
}

<?php

namespace App\Models;

use App\Support\ImageUrl;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    protected $fillable = [
        'name',
        'path',
        'mime_type',
        'size',
        'album_id',
        'disk',
        'external_url',
    ];

    protected $appends = ['url'];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    public function getUrlAttribute()
    {
        // Si la imagen fue agregada por enlace externo, usamos esa URL directamente.
        // Los enlaces de Google Drive se convierten a su formato directo de imagen.
        if ($external = ImageUrl::normalize($this->external_url)) {
            return $external;
        }

        return route('file.preview', $this);
    }

    public function getFullPathAttribute()
    {
        return Storage::disk($this->disk)->path($this->path);
    }

    public function isExternal()
    {
        return ! empty($this->external_url);
    }
}

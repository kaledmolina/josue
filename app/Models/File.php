<?php
namespace App\Models;

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
        'disk'
    ];

    protected $appends = ['url'];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    public function getUrlAttribute()
    {
        return route('file.preview', $this);
    }

    public function getFullPathAttribute()
    {
        return Storage::disk($this->disk)->path($this->path);
    }
}
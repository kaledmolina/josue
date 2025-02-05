<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Album extends Model
{
    protected $fillable = [
        'title',
        'path',
        'disk'
    ];

    protected $appends = ['cover_url'];

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function getCoverUrlAttribute()
    {
        return route('album.cover', $this);
    }
}
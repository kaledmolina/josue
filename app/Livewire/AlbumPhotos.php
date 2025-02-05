<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Album;

class AlbumPhotos extends Component
{
    public $album;
    public $selectedPhoto = null;

    public function mount($albumId)
    {
        $this->loadAlbum($albumId);
    }

    protected function loadAlbum($albumId)
    {
        $this->album = Album::with('files')->findOrFail($albumId);
    }

    public function selectPhoto($photoUrl)
    {
        $this->selectedPhoto = $photoUrl;
    }

    public function closePhoto()
    {
        $this->selectedPhoto = null;
    }

    public function render()
    {
        return view('livewire.album-photos', [
            'albumData' => [
                'title' => $this->album->title,
                'cover' => $this->album->cover_url,
                'photos' => $this->album->files->map(function($file) {
                    return $file->url;
                })->toArray(),
                'date' => $this->album->created_at->format('d M Y')
            ]
        ]);
    }
}
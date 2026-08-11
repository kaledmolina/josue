<?php

namespace App\Livewire;

use App\Models\Album;
use Livewire\Component;

class AlbumPhotos extends Component
{
    public $album;

    public $photos = [];

    public $selectedIndex = null;

    public function mount($albumId)
    {
        $this->loadAlbum($albumId);
    }

    protected function loadAlbum($albumId)
    {
        $this->album = Album::with('files')->findOrFail($albumId);

        $this->photos = $this->album->files
            ->sortByDesc('created_at')
            ->values()
            ->map(fn ($file) => [
                'url' => $file->url,
                'name' => $file->name,
            ])
            ->toArray();
    }

    public function selectPhoto($index)
    {
        if (! isset($this->photos[$index])) {
            return;
        }

        $this->selectedIndex = (int) $index;
    }

    public function nextPhoto()
    {
        if ($this->selectedIndex === null || empty($this->photos)) {
            return;
        }

        $this->selectedIndex = ($this->selectedIndex + 1) % count($this->photos);
    }

    public function prevPhoto()
    {
        if ($this->selectedIndex === null || empty($this->photos)) {
            return;
        }

        $this->selectedIndex = ($this->selectedIndex - 1 + count($this->photos)) % count($this->photos);
    }

    public function closePhoto()
    {
        $this->selectedIndex = null;
    }

    public function render()
    {
        return view('livewire.album-photos', [
            'albumData' => [
                'title' => $this->album->title,
                'cover' => $this->album->cover_url,
                'photos' => $this->photos,
                'date' => $this->album->created_at->format('d M Y'),
            ],
        ]);
    }
}

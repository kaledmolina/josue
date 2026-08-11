<?php

namespace App\Livewire;

use App\Models\Album;
use Livewire\Component;

class Fotografias extends Component
{
    public $albums = [];

    public function mount()
    {
        $this->loadAlbums();
    }

    protected function loadAlbums()
    {
        $this->albums = Album::with(['files' => function ($query) {
            $query->latest();
        }])
            ->latest()
            ->get()
            ->map(function ($album) {
                return [
                    'id' => $album->id,
                    'title' => $album->title,
                    'cover' => $album->cover_url,
                    'date' => $album->created_at->format('d M Y'),
                    'photos_count' => $album->files->count(),
                ];
            })
            ->toArray();
    }

    public function render()
    {
        return view('livewire.fotografias', [
            'albums' => $this->albums,
        ]);
    }
}

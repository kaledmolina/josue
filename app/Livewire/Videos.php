<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Video;
use Illuminate\Support\Collection;

class Videos extends Component
{
    /**
     * Obtiene todos los videos.
     */
    public function getVideosProperty(): Collection
    {
        return Video::latest()->get();
    }

    /**
     * Obtiene el contador total de videos.
     */
    public function getVideosCountProperty(): int
    {
        return Video::count();
    }

    public function render()
    {
        return view('livewire.videos', [
            'videos' => $this->videos,
            'videosCount' => $this->videosCount,
        ]);
    }
}
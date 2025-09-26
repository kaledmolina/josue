<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Video;

class Videos extends Component
{
    use WithPagination;

    public $perPage = 5; // Número de videos por página

    protected $listeners = ['loadMore' => 'loadMore'];

    public function loadMore()
    {
        $this->perPage += 5; // Incrementa la cantidad de videos a mostrar
    }

    public function render()
    {
        $videos = Video::latest()->paginate($this->perPage);
        return view('livewire.videos', ['videos' => $videos]);
    }
}
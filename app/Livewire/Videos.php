<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Video;

class Videos extends Component
{
    use WithPagination;

    public $perPage = 5; // Número inicial de videos por página

    /**
     * Carga más videos incrementando la cantidad por página.
     * Este método es llamado desde el frontend.
     */
    public function loadMore()
    {
        $this->perPage += 5;
    }

    /**
     * Renderiza la vista del componente.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $videos = Video::latest()->paginate($this->perPage);

        return view('livewire.videos', [
            'videos' => $videos,
            'hasMorePages' => $videos->hasMorePages(), // Variable para saber si hay más páginas
        ]);
    }
}

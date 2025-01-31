<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Video;



class Videos extends Component
{

    public $videos;

    public function mount()
    {
        // Obtener todos los videos desde la base de datos
        $this->videos = Video::all()->toArray();
    }
    
    public function render()
    {
        return view('livewire.videos');
    }
}

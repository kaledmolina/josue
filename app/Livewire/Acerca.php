<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\AboutContent;

class Acerca extends Component
{
    public function render()
    {
        return view('livewire.acerca', [
            'content' => AboutContent::firstOrNew()
        ]);
    }
}

<?php
namespace App\Livewire;

use Livewire\Component;

class Fotografias extends Component
{
    public $albumId = null;
    public $selectedPhoto = null;

    public function getAlbums()
    {
        return [
            1 => [
                'id' => 1,
                'title' => 'Vacaciones de Verano 2023',
                'date' => '15 Junio 2023',
                'cover' => asset('Images/ampli-final2.png'),
                'photos' => [
                    asset('Images/ampli-final2.png'),
                    asset('Images/ampli-final2.png'),
                    asset('Images/ampli-final2.png'),
                ]
            ],
        ];
    }

    public function getSelectedAlbum()
    {
        return $this->albumId ? $this->getAlbums()[$this->albumId] : null;
    }

    public function selectAlbum($albumId)
    {
        $this->albumId = $albumId;
    }

    public function deselectAlbum()
    {
        $this->albumId = null;
    }

    public function selectPhoto($photoUrl)
    {
        $this->selectedPhoto = urldecode($photoUrl);

    }

    public function closePhoto()
    {
        $this->selectedPhoto = null;
    }

    public function render()
    {
        return view('livewire.fotografias', [
            'albums' => $this->getAlbums(),
            'selectedAlbum' => $this->getSelectedAlbum()
        ]);
    }
}
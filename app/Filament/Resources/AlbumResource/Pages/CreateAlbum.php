<?php

namespace App\Filament\Resources\AlbumResource\Pages;

use App\Filament\Resources\AlbumResource;
use App\Filament\Resources\AlbumResource\Pages\Concerns\HandlesAlbumFormData;
use Filament\Resources\Pages\CreateRecord;

class CreateAlbum extends CreateRecord
{
    use HandlesAlbumFormData;

    protected static string $resource = AlbumResource::class;
}

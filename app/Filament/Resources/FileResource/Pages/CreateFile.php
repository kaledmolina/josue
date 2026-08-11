<?php

namespace App\Filament\Resources\FileResource\Pages;

use App\Filament\Resources\FileResource;
use App\Filament\Resources\FileResource\Pages\Concerns\HandlesFileFormData;
use Filament\Resources\Pages\CreateRecord;

class CreateFile extends CreateRecord
{
    use HandlesFileFormData;

    protected static string $resource = FileResource::class;
}

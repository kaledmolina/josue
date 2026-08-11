<?php

namespace App\Filament\Resources\FileResource\Pages;

use App\Filament\Resources\FileResource;
use App\Filament\Resources\FileResource\Pages\Concerns\HandlesFileFormData;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFile extends EditRecord
{
    use HandlesFileFormData;

    protected static string $resource = FileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

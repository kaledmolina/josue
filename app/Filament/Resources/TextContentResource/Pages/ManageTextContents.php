<?php

namespace App\Filament\Resources\TextContentResource\Pages;

use App\Filament\Resources\TextContentResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageTextContents extends ManageRecords
{
    protected static string $resource = TextContentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

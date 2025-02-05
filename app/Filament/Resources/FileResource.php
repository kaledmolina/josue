<?php

namespace App\Filament\Resources;

use App\Models\File;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;


class FileResource extends Resource
{
    protected static ?string $model = File::class;
    protected static ?string $navigationIcon = 'heroicon-o-document';
    protected static ?string $navigationGroup = 'Galeria';
    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('album_id')
                    ->label('Álbum')
                    ->relationship(name: 'album', titleAttribute: 'title') // Configuración correcta
                    ->searchable()
                    ->preload()
                    ->required()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        FileUpload::make('path')
                            ->disk('google')
                            ->directory('albums/covers')
                            ->image()
                            ->required()
                    ]),
                FileUpload::make('path')
                ->disk('google')
                ->preserveFilenames()
                ->acceptedFileTypes(['image/*'])
                ->required()
                ->columnSpanFull(),
                    
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                    
                Forms\Components\TextInput::make('mime_type')
                    ->required(),
                    
                Forms\Components\TextInput::make('size')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('url')
    ->label('Imagen')
    ->width(75)
    ->height(75) // Agrega esta línea
    ->state(function ($record) {
        return $record->exists ? $record->url : null;
    }),
                
            Tables\Columns\TextColumn::make('name')
                ->searchable()
                ->sortable()
                ->description(fn ($record) => $record->url)
                ->wrap(),
                
            Tables\Columns\TextColumn::make('size')
                ->formatStateUsing(fn ($state) => number_format($state / 1024, 2).' KB')
                ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('download')
                    ->label('Descargar')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function ($record) {
                        return Storage::disk('google')->download($record->path);
                    }),
                    
                    Tables\Actions\EditAction::make()
                    ->mutateRecordDataUsing(function (array $data): array {
                        unset($data['url']); // Elimina la URL del estado del componente
                        return $data;
                    }),
                
                Tables\Actions\DeleteAction::make()
                    ->before(function ($record) {
                        Storage::disk('google')->delete($record->path);
                    }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\FileResource\Pages\ListFiles::route('/'),
            'create' => \App\Filament\Resources\FileResource\Pages\CreateFile::route('/create'),
            'edit' => \App\Filament\Resources\FileResource\Pages\EditFile::route('/{record}/edit'),
        ];
    }
}
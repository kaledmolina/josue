<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AlbumResource\Pages;
use App\Models\Album;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class AlbumResource extends Resource
{
    protected static ?string $model = Album::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Galeria';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                Forms\Components\Section::make('Portada')
                    ->description('Sube un archivo o pega el enlace directo de la imagen de portada.')
                    ->schema([

                        Forms\Components\Toggle::make('is_external_cover')
                            ->label('Usar enlace externo (URL de portada)')
                            ->helperText('Actívalo para pegar la URL de la portada en lugar de subir un archivo.')
                            ->live()
                            ->default(false)
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('cover_image_url')
                            ->label('URL de la portada')
                            ->placeholder('https://ejemplo.com/portada.jpg')
                            ->helperText('Pega el enlace directo de la imagen de portada. También acepta enlaces públicos de Google Drive.')
                            ->visible(fn (Get $get): bool => (bool) $get('is_external_cover'))
                            ->required(fn (Get $get): bool => (bool) $get('is_external_cover'))
                            ->columnSpanFull(),

                        FileUpload::make('path')
                            ->label('Portada del álbum')
                            ->disk('google')
                            ->directory('albums/covers')
                            ->image()
                            ->imageEditor()
                            ->visible(fn (Get $get): bool => ! (bool) $get('is_external_cover'))
                            ->required(fn (Get $get): bool => ! (bool) $get('is_external_cover'))
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Select::make('disk')
                    ->options([
                        'google' => 'Google Drive',
                    ])
                    ->default('google')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('cover_url')
                    ->label('Portada')
                    ->size(60),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('files_count')
                    ->label('Fotos')
                    ->counts('files')
                    ->badge()
                    ->color('gray'),

                Tables\Columns\IconColumn::make('cover_image_url')
                    ->label('Tipo')
                    ->boolean()
                    ->trueIcon('heroicon-o-link')
                    ->trueColor('info')
                    ->falseIcon('heroicon-o-photo')
                    ->falseColor('success')
                    ->tooltip(fn ($state) => $state ? 'Portada por enlace externo' : 'Portada subida'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->before(function (Album $record) {
                        if (! $record->cover_image_url && $record->path) {
                            Storage::disk($record->disk ?? 'google')->delete($record->path);
                        }
                    }),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAlbums::route('/'),
            'create' => Pages\CreateAlbum::route('/create'),
            'edit' => Pages\EditAlbum::route('/{record}/edit'),
        ];
    }
}

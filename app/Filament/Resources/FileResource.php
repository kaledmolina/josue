<?php

namespace App\Filament\Resources;

use App\Models\File;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

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
                    ->relationship(name: 'album', titleAttribute: 'title')
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
                            ->required(),
                    ]),

                Forms\Components\Section::make('Imagen')
                    ->description('Sube un archivo desde tu equipo o pega el enlace directo de una imagen.')
                    ->schema([

                        Toggle::make('is_external')
                            ->onIcon('heroicon-o-link')
                            ->offIcon('heroicon-o-photo')
                            ->label('Usar enlace externo (URL de imagen)')
                            ->helperText('Actívalo para pegar el enlace de una imagen en lugar de subir un archivo.')
                            ->live()
                            ->default(false)
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('external_url')
                            ->label('URL de la imagen')
                            ->placeholder('https://ejemplo.com/imagen.jpg')
                            ->helperText('Pega el enlace directo de la imagen. También acepta enlaces públicos de Google Drive.')
                            ->visible(fn (Get $get): bool => (bool) $get('is_external'))
                            ->required(fn (Get $get): bool => (bool) $get('is_external'))
                            ->columnSpanFull(),

                        FileUpload::make('path')
                            ->disk('google')
                            ->preserveFilenames()
                            ->image()
                            ->imageEditor()
                            ->helperText('Formatos: JPG, PNG, WebP, GIF…')
                            ->visible(fn (Get $get): bool => ! (bool) $get('is_external'))
                            ->required(fn (Get $get): bool => ! (bool) $get('is_external'))
                            ->columnSpanFull(),
                    ]),

                Forms\Components\TextInput::make('name')
                    ->label('Nombre')
                    ->helperText('Opcional. Se completa automáticamente con el nombre del archivo o de la URL.')
                    ->maxLength(255)
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('mime_type')
                    ->hidden(),
                Forms\Components\TextInput::make('size')
                    ->hidden(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('url')
                    ->label('Imagen')
                    ->width(75)
                    ->height(75)
                    ->state(function ($record) {
                        return $record->exists ? $record->url : null;
                    }),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->description(fn ($record) => $record->url)
                    ->wrap()
                    ->limit(40),

                Tables\Columns\TextColumn::make('album.title')
                    ->label('Álbum')
                    ->badge()
                    ->color('gray')
                    ->searchable(),

                Tables\Columns\IconColumn::make('external_url')
                    ->label('Tipo')
                    ->boolean()
                    ->trueIcon('heroicon-o-link')
                    ->trueColor('info')
                    ->falseIcon('heroicon-o-photo')
                    ->falseColor('success')
                    ->tooltip(fn ($state) => $state ? 'Enlace externo' : 'Archivo subido'),

                Tables\Columns\TextColumn::make('size')
                    ->formatStateUsing(fn ($state) => $state ? number_format($state / 1024, 2).' KB' : '—')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('download')
                    ->label('Descargar')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->visible(fn (File $record) => ! $record->isExternal())
                    ->action(function (File $record) {
                        return Storage::disk($record->disk ?? 'google')->download($record->path);
                    }),

                Tables\Actions\Action::make('open_external')
                    ->label('Abrir enlace')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->color('info')
                    ->visible(fn (File $record) => $record->isExternal())
                    ->url(fn (File $record) => $record->external_url)
                    ->openUrlInNewTab(),

                EditAction::make()
                    ->mutateRecordDataUsing(function (array $data): array {
                        unset($data['url']); // Elimina la URL del estado del componente

                        return $data;
                    }),

                DeleteAction::make()
                    ->before(function (File $record) {
                        if (! $record->isExternal() && $record->path) {
                            Storage::disk($record->disk ?? 'google')->delete($record->path);
                        }
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

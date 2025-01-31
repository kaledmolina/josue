<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VideoResource\Pages;
use App\Filament\Resources\VideoResource\RelationManagers;
use App\Models\Video;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VideoResource extends Resource
{
    protected static ?string $model = Video::class;

    protected static ?string $navigationIcon = 'heroicon-o-video-camera'; // Icono más apropiado
    protected static ?string $navigationGroup = 'Contenido Multimedia'; // Agrupar en el menú
    protected static ?string $modelLabel = 'Video';
    protected static ?string $pluralModelLabel = 'Videos';
    protected static ?int $navigationSort = 2; // Orden en el menú

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Título')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                
                Forms\Components\Textarea::make('url')
                    ->label('URL del video')
                    ->required()
                    ->rows(2)
                    ->columnSpanFull()
                    ->hint('URL de YouTube o Vimeo'),
                
                Forms\Components\Select::make('alignment')
                    ->label('Alineación del contenido')
                    ->options([
                        'left' => 'Izquierda',
                        'right' => 'Derecha',
                    ])
                    ->required()
                    ->native(false)
                    ->inlineLabel()
                    ->helperText('Determina la posición del video en la página')
                    ->selectablePlaceholder(false)
                    ->columnSpanFull(),
                
                Forms\Components\RichEditor::make('description') // Editor mejorado
                    ->label('Descripción')
                    ->required()
                    ->columnSpanFull()
                    ->fileAttachmentsDirectory('videos/descripciones')
                    ->toolbarButtons([
                        'blockquote',
                        'bold',
                        'bulletList',
                        'italic',
                        'link',
                        'orderedList',
                        'redo',
                        'strike',
                        'underline',
                        'undo',
                    ])
                    ->maxLength(2000),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\IconColumn::make('alignment')
                    ->label('Alineación')
                    ->icon(fn (string $state): string => match ($state) {
                        'left' => 'heroicon-o-arrow-long-left',
                        'right' => 'heroicon-o-arrow-long-right',
                    })
                    ->color('primary')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Video $record): string => substr($record->description, 0, 50) . '...')
                    ->wrap(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('alignment')
                    ->label('Filtrar por alineación')
                    ->options([
                        'left' => 'Izquierda',
                        'right' => 'Derecha',
                    ])
                    ->native(false),
                
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Desde'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Hasta'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn ($query, $date) => $query->whereDate('created_at', '>=', $date)
                            )
                            ->when(
                                $data['created_until'],
                                fn ($query, $date) => $query->whereDate('created_at', '<=', $date)
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('Ver')
                    ->icon('heroicon-o-eye')
                    ->url(fn (Video $record): string => $record->url)
                    ->openUrlInNewTab(),
                
                Tables\Actions\EditAction::make()
                    ->icon('heroicon-o-pencil')
                    ->successNotificationTitle('Video actualizado exitosamente'),
                
                Tables\Actions\DeleteAction::make()
                    ->icon('heroicon-o-trash')
                    ->successNotificationTitle('Video eliminado exitosamente'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Eliminar seleccionados')
                        ->deselectRecordsAfterCompletion(),
                ]),
            ])
            ->emptyStateHeading('No hay videos registrados')
            ->emptyStateDescription('Crea tu primer video haciendo clic en el botón de arriba')
            ->emptyStateIcon('heroicon-o-film')
            ->deferLoading()
            ->persistSearchInSession()
            ->persistColumnSearchesInSession();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageVideos::route('/'),
        ];
    }
}

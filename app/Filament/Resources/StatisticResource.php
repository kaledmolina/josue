<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StatisticResource\Pages;
use App\Models\Statistic;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class StatisticResource extends Resource
{
    protected static ?string $model = Statistic::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationGroup = 'Gestión';
    protected static ?string $modelLabel = 'Estadística';
    protected static ?string $pluralModelLabel = 'Estadísticas';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Detalles de la estadística')
                    ->schema([
                        Forms\Components\Select::make('title')
                            ->label('Tipo de estadística')
                            ->options([
                                'instagram_followers' => 'Seguidores en Instagram',
                                'youtube_subscribers' => 'Suscriptores de YouTube',
                                'youtube_views' => 'Visualizaciones en YouTube',
                                'other' => 'Otra estadística'
                            ])
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->columnSpanFull(),
                            
                        Forms\Components\TextInput::make('value')
                            ->label('Valor')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Ej: 1,700,000')
                            ->columnSpanFull(),
                            
                        Forms\Components\Textarea::make('description')
                            ->label('Descripción')
                            ->required()
                            ->rows(3)
                            ->placeholder('Ej: Seguidores en Instagram')
                            ->columnSpanFull(),
                            
                        Forms\Components\DateTimePicker::make('created_at')
                            ->label('Fecha de creación')
                            ->displayFormat('d/m/Y H:i')
                            ->disabled()
                            ->dehydrated(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Tipo')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'instagram_followers' => 'Instagram',
                        'youtube_subscribers' => 'YouTube Subs',
                        'youtube_views' => 'YouTube Views',
                        default => 'Otra'
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'instagram_followers' => 'warning',
                        'youtube_subscribers' => 'danger',
                        'youtube_views' => 'primary',
                        default => 'gray'
                    })
                    ->sortable()
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('value')
                    ->label('Valor')
                    ->sortable()
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('description')
                    ->label('Descripción')
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->description)
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Actualizado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('title')
                    ->label('Tipo de estadística')
                    ->options([
                        'instagram_followers' => 'Instagram',
                        'youtube_subscribers' => 'YouTube Subs', 
                        'youtube_views' => 'YouTube Views',
                        'other' => 'Otras'
                    ]),
                    
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
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->iconButton()
                    ->successNotificationTitle('Estadística actualizada'),
                    
                Tables\Actions\DeleteAction::make()
                    ->iconButton()
                    ->successNotificationTitle('Estadística eliminada'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Eliminar seleccionadas'),
                ]),
            ])
            ->emptyStateHeading('No hay estadísticas registradas')
            ->emptyStateDescription('Crea tu primera estadística haciendo clic en el botón inferior')
            ->emptyStateIcon('heroicon-o-chart-pie')
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageStatistics::route('/'),
        ];
    }
}
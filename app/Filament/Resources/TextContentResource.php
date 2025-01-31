<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TextContentResource\Pages;
use App\Models\TextContent;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class TextContentResource extends Resource
{
    protected static ?string $model = TextContent::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Contenido';
    protected static ?string $modelLabel = 'Texto';
    protected static ?string $pluralModelLabel = 'Textos';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Contenido dinámico')
                    ->schema([
                        Forms\Components\TextInput::make('key')
                            ->label('Identificador único')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->disabledOn('edit')
                            ->helperText('Ej: contact_description, about_intro')
                            ->afterStateUpdated(fn ($set, $state) => $set('key', Str::slug($state)))
                            ->columnSpanFull(),
                            
                        Forms\Components\RichEditor::make('content')
                            ->label('Contenido')
                            ->required()
                            ->fileAttachmentsDirectory('text-content')
                            ->toolbarButtons([
                                'blockquote',
                                'bold',
                                'bulletList',
                                'h2',
                                'h3',
                                'italic',
                                'link',
                                'orderedList',
                                'redo',
                                'strike',
                                'underline',
                                'undo',
                            ])
                            ->columnSpanFull(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->label('Identificador')
                    ->searchable()
                    ->sortable()
                    ->description(fn ($record) => Str::limit($record->content, 50))
                    ->wrap(),
                    
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Última actualización')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('key')
                    ->form([
                        Forms\Components\TextInput::make('search_key')
                            ->label('Buscar por identificador')
                    ])
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->iconButton()
                    ->successNotificationTitle('Contenido actualizado'),
                    
                Tables\Actions\DeleteAction::make()
                    ->iconButton()
                    ->before(function ($action, $record) {
                        if(in_array($record->key, ['contact_description'])) {
                            $action->cancel();
                            session()->flash('error', 'No puedes eliminar este contenido clave');
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Eliminar seleccionados'),
                ]),
            ])
            ->emptyStateHeading('No hay contenidos creados')
            ->emptyStateDescription('Empieza a crear textos dinámicos para tu sitio web')
            ->emptyStateIcon('heroicon-o-document-text')
            ->defaultSort('updated_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageTextContents::route('/'),
        ];
    }
}
<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutContentResource\Pages;
use App\Filament\Resources\AboutContentResource\RelationManagers;
use App\Models\AboutContent;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AboutContentResource extends Resource
{
    protected static ?string $model = AboutContent::class;
    protected static ?string $navigationLabel = 'Contenido Acerca de';
    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static ?string $navigationGroup = 'Contenido';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Sección Principal')
                    ->collapsible()
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('hero_title')
                            ->label('Título principal')
                            ->required()
                            ->maxLength(100),
                        
                        Forms\Components\Textarea::make('hero_description')
                            ->label('Descripción')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
                
                Forms\Components\Section::make('Formación Académica')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('education_title')
                            ->label('Título obtenido')
                            ->required(),
                        
                        Forms\Components\TextInput::make('education_institution')
                            ->label('Institución')
                            ->required(),
                        
                        Forms\Components\TextInput::make('education_dates')
                            ->label('Periodo de estudios')
                            ->placeholder('Ej: 2020-2024')
                            ->required(),
                        
                        Forms\Components\Textarea::make('education_details')
                            ->label('Detalles académicos')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
                
                Forms\Components\Section::make('Experiencia Profesional')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('experience_title')
                            ->label('Puesto de trabajo')
                            ->required(),
                        
                        Forms\Components\TextInput::make('experience_company')
                            ->label('Empresa')
                            ->required(),
                        
                        Forms\Components\TextInput::make('experience_dates')
                            ->label('Periodo laboral')
                            ->placeholder('Ej: 2022-Actualidad')
                            ->required(),
                        
                        Forms\Components\Textarea::make('experience_details')
                            ->label('Responsabilidades')
                            ->rows(3)
                            ->columnSpanFull(),
                        
                        Forms\Components\TagsInput::make('skills')
                            ->label('Habilidades técnicas')
                            ->placeholder('Nueva habilidad')
                            ->required()
                            ->columnSpanFull(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('hero_title')
                    ->label('Título principal')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Última actualización')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->icon('heroicon-o-pencil'),
                
                Tables\Actions\DeleteAction::make()
                    ->icon('heroicon-o-trash'),
            ])
            ->bulkActions([])
            ->emptyStateHeading('No hay contenido configurado')
            ->modifyQueryUsing(fn (Builder $query) => $query->latest());
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
            'index' => Pages\ListAboutContents::route('/'),
            'create' => Pages\CreateAboutContent::route('/create'),
            'edit' => Pages\EditAboutContent::route('/{record}/edit'),
        ];
    }
}

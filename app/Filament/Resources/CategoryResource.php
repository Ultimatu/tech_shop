<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $activeNavigationIcon = 'heroicon-s-tag';

    protected static ?string $navigationGroup = 'Catalogue';

    protected static ?string $navigationLabel = 'Catégorie';
    protected static ?string $pluralModelLabel = 'Catégories';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScope(SoftDeletingScope::class);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label('Nom de la catégorie')
                    ->hint('Veuillez saisir le nom de la catégorie')
                    ->hintIcon('heroicon-s-information-circle')
                    ->prefixIcon('heroicon-s-tag')
                    ->prefixIconColor('info')
                    ->unique(ignoreRecord: true)
                    ->maxLength(70),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->label('Description')
                    ->hint('Veuillez saisir la description de la catégorie')
                    ->hintIcon('heroicon-s-information-circle')
                    ->hintIconTooltip('La description de la catégorie doit être claire et concise')
                    ->maxLength(255),
                Forms\Components\FileUpload::make('image')
                    ->label('Image de la catégorie ou illustration')
                    ->hint('Veuillez sélectionner une image pour la catégorie')
                    ->hintIcon('heroicon-s-information-circle')
                    ->hintIconTooltip('L\'image de la catégorie doit être claire et concise')
                    ->image(),
                Forms\Components\Toggle::make('is_active')
                    ->label('Activer la catégorie')
                    ->hint('Veuillez activer ou désactiver la catégorie')
                    ->hintIcon('heroicon-s-information-circle'),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading('Aucun élément trouvé')
            ->emptyStateDescription('Il n\'y a aucun éléments enregistré.')
            ->emptyStateIcon('heroicon-s-question-mark-circle')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nom')
                    ->badge()
                    ->icon('heroicon-s-tag')
                    ->iconColor('primary')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->icon('heroicon-s-information-circle')
                    ->iconColor('info')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Actif')
                    ->afterStateUpdated(function (Category $record, $state) {
                        $record->update(['is_active' => $state]);
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubCategoryResource\Pages;
use App\Filament\Resources\SubCategoryResource\RelationManagers;
use App\Models\SubCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubCategoryResource extends Resource
{
    protected static ?string $model = SubCategory::class;

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $activeNavigationIcon = 'heroicon-s-shopping-bag';

    protected static ?string $navigationGroup = 'Catalogue';

    protected static ?string $navigationLabel = 'Sous-catégorie';

    protected static ?string $pluralModelLabel = 'Sous-catégories';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('category_id')
                    ->label('Catégorie')
                    ->hint('Veuillez sélectionner la catégorie de la sous-catégorie')
                    ->hintIcon('heroicon-s-information-circle')
                    ->prefixIcon('heroicon-s-tag')
                    ->prefixIconColor('danger')
                    ->required()
                    ->native(false)
                    ->relationship('category', 'name'),
                Forms\Components\TextInput::make('name')
                    ->label('Nom de la sous-catégorie')
                    ->hint('Veuillez saisir le nom de la sous-catégorie')
                    ->hintIcon('heroicon-s-information-circle')
                    ->prefixIcon('heroicon-s-tag')
                    ->prefixIconColor('warning')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->label('Description')
                    ->hint('Veuillez saisir la description de la sous-catégorie')
                    ->hintIcon('heroicon-s-information-circle')
                    ->hintIconTooltip('La description de la sous-catégorie doit être claire et concise')
                    ->maxLength(255),
                Forms\Components\FileUpload::make('image')
                    ->label('Image de la sous-catégorie ou illustration')
                    ->hint('Veuillez sélectionner une image pour la sous-catégorie')
                    ->hintIcon('heroicon-s-information-circle')
                    ->hintIconTooltip('L\'image de la sous-catégorie doit être claire et concise')
                    ->image(),
                Forms\Components\Toggle::make('is_active')
                    ->label('Activer la sous-catégorie')
                    ->hint('Veuillez activer ou désactiver la sous-catégorie')
                    ->hintIcon('heroicon-s-information-circle'),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading('Aucune sous-catégorie trouvée')
            ->emptyStateDescription('Il semble que vous n\'ayez aucun enregistrement de sous-catégorie pour le moment.')
            ->emptyStateIcon('heroicon-s-shopping-bag')
            ->columns([
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Catégorie')
                    ->badge()
                    ->url(fn ($record, $state) => route('filament.admin.resources.categories.edit', $record->category_id))
                    ->color('danger')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nom')
                    ->badge()
                    ->icon('heroicon-s-tag')
                    ->iconColor('warning')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->icon('heroicon-s-information-circle')
                    ->iconColor('info')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Actif')
                    ->afterStateUpdated(function (SubCategory $record, $state) {
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
            ->filters([
                //
            ])
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
            'index' => Pages\ListSubCategories::route('/'),
            'create' => Pages\CreateSubCategory::route('/create'),
            'edit' => Pages\EditSubCategory::route('/{record}/edit'),
        ];
    }
}

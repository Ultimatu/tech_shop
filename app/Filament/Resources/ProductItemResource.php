<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductItemResource\Pages;
use App\Filament\Resources\ProductItemResource\RelationManagers;
use App\Models\ProductItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\SelectFilter;

class ProductItemResource extends Resource
{
    protected static ?string $model = ProductItem::class;
    protected static ?int $navigationSort = 11;

    protected static ?string $navigationIcon = 'heroicon-o-wallet';
    protected static ?string $activeNavigationIcon = 'heroicon-s-wallet';

    protected static ?string $navigationGroup = 'Produits';

    protected static ?string $navigationLabel = 'Détail Produit';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('product_id')
                    ->required()
                    ->native(false)
                    ->relationship('product', 'name')
                    ->prefixIcon('heroicon-o-shopping-cart')
                    ->prefixIconColor('primary')
                    ->hint('Selectionnez le produit correspondant'),
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->required()
                    ->hint('Téléchargez l\'image du produit'),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading('Aucune image de produit trouvée')
            ->emptyStateDescription('Il semble que vous n\'ayez aucune image de produit pour le moment.')
            ->emptyStateIcon('heroicon-s-photograph')
            ->columns([
                Tables\Columns\TextColumn::make('product.subCategory.name')
                    ->sortable()
                    ->label('Sous-catégorie')
                    ->url(fn($record, $state) => route('filament.admin.resources.sub-categories.edit', $record->product->subCategory->id))
                    ->icon('heroicon-o-shopping-cart') // Icone de préfixe
                    ->iconColor('danger'),
                Tables\Columns\TextColumn::make('product.name')
                    ->sortable()
                    ->label('Produit')
                    ->url(fn($record, $state) => route('filament.admin.resources.products.edit', $record->product_id))
                    ->icon('heroicon-o-shopping-cart') // Icone de préfixe
                    ->iconColor('success'),
                Tables\Columns\ImageColumn::make('image')
                    ->label('Image'),
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
                SelectFilter::make('product_id')
                    ->label('Produit')
                    ->native(false)
                    ->relationship('product', 'name'),
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
            'index' => Pages\ListProductItems::route('/'),
            'create' => Pages\CreateProductItem::route('/create'),
            'edit' => Pages\EditProductItem::route('/{record}/edit'),
        ];
    }
}

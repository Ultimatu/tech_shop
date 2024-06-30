<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\RichEditor;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Get;
use Filament\Tables\Columns\ToggleColumn;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?int $navigationSort = 10;

    protected static ?string $navigationIcon = 'heroicon-o-wallet';
    protected static ?string $activeNavigationIcon = 'heroicon-s-wallet';

    protected static ?string $modelLabel = "Produit";

    protected static ?string $navigationGroup = 'Produits';

    protected static ?string $navigationLabel = 'Produit';

    protected static ?string $pluralModelLabel = 'Produits';



    public static function form(Form $form): Form
    {

        return $form
            ->schema([
                Select::make('sub_category_id')
                    ->label('Sous-catégorie')
                    ->relationship('subCategory', 'name')
                    ->required()
                    ->prefixIcon('heroicon-o-tag')
                    ->prefixIconColor('danger')
                    ->native(false)
                    ->live()
                    ->hint('Sélectionnez une sous-catégorie pour le produit'),
                TextInput::make('name')
                    ->required()
                    ->label('Nom du produit')
                    ->prefixIcon('heroicon-o-tag')
                    ->prefixIconColor('warning')
                    ->hint('Entrez le nom du produit'),
                RichEditor::make('description')
                    ->label('Description')
                    ->required()
                    ->hint('Entrez une description détaillée du produit'),
                FileUpload::make('image_primary')
                    ->label('Image principale')
                    ->image()
                    ->required()
                    ->hint('Téléchargez l\'image principale du produit'),
                TextInput::make('price_with_discount')
                    ->label('Prix avec réduction')
                    ->numeric()
                    ->required()
                    ->prefixIcon('heroicon-s-currency-euro')
                    ->prefixIconColor('success')
                    ->hint('Entrez le prix avec réduction'),
                TextInput::make('price_without_discount')
                    ->label('Prix original')
                    ->numeric()
                    ->required()
                    ->prefixIcon('heroicon-s-currency-euro')
                    ->prefixIconColor('danger')
                    ->hint('Entrez le prix original'),
                TextInput::make('stock')
                    ->label('Quantité en stock')
                    ->numeric()
                    ->required()
                    ->prefixIcon('heroicon-s-archive-box')
                    ->prefixIconColor('info')
                    ->hint('Entrez la quantité en stock'),
                TagsInput::make('tags')
                    ->label('Mots-clés de recherche')
                    ->separator(',')
                    ->nestedRecursiveRules([
                        'min:3',
                        'max:255',
                    ])
                    ->reorderable()
                    ->splitKeys(['Tab', ' '])
                    ->prefixIcon('heroicon-o-tag')
                    ->prefixIconColor('success')
                    ->label('Mots-clés')
                    ->hint('Entrez les mots-clés du produit pour les recherches')
                    ->hintIcon('heroicon-s-information-circle')
                    ->hintIconTooltip('Les mots-clés doivent être séparés par des virgules'),
                Toggle::make('is_promoted')
                    ->label('Promu')
                    ->live()
                    ->hint('Définir si le produit est promu ou non'),
                TextInput::make('promotion_percent')
                    ->label('Pourcentage de promotion')
                    ->numeric()
                    ->visible(fn (Get $get) => $get('is_promoted') === true)
                    ->prefixIcon('heroicon-s-receipt-percent')
                    ->prefixIconColor('warning')
                    ->requiredIf('is_promoted', true)
                    ->hint('Entrez le pourcentage de promotion'),
                DatePicker::make('promotion_start')
                    ->label('Début de la promotion')
                    ->requiredIf('is_promoted', true)
                    ->visible(fn (Get $get) => $get('is_promoted') === true)
                    ->hint('Entrez la date de début de la promotion'),
                DatePicker::make('promotion_end')
                    ->label('Fin de la promotion')
                    ->requiredIf('is_promoted', true)
                    ->visible(fn (Get $get) => $get('is_promoted') === true)
                    ->hint('Entrez la date de fin de la promotion'),
                Repeater::make('productItems')
                    ->label('Images supplémentaires')
                    ->columns(1)
                    ->relationship('items')
                    ->visible(fn ($get) => !$get('id'))
                    ->schema([
                        FileUpload::make('image')
                            ->image()
                            ->required()
                            ->hint('Téléchargez une image supplémentaire'),
                    ])
                    ->addActionLabel('Ajouter une image')
                    ->columnSpan('full'),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading('Aucun produit trouvé')
            ->emptyStateDescription('Il semble que vous n\'ayez aucun produit pour le moment.')
            ->emptyStateIcon('heroicon-s-shopping-cart')
            ->columns([
                TextColumn::make('subCategory.category.name')
                    ->sortable()
                    ->searchable()
                    ->url(fn($record, $state) => route('filament.admin.resources.categories.edit', $record->subCategory->category_id))
                    ->icon('heroicon-o-tag')
                    ->color('danger')
                    ->label('Catégorie'),
                TextColumn::make('subCategory.name')
                    ->sortable()
                    ->searchable()
                    ->url(fn($record, $state) => route('filament.admin.resources.sub-categories.edit', $record->sub_category_id))
                    ->icon('heroicon-o-tag')
                    ->color('warning')
                    ->label('Sous-catégorie'),
                TextColumn::make('name')
                    ->sortable()
                    ->searchable()
                    ->icon('heroicon-s-tag')
                    ->color('primary')
                    ->label('Nom du produit'),
                ImageColumn::make('image_primary')
                    ->label('Image principale'),
                TextColumn::make('price_with_discount')
                    ->sortable()
                    ->suffix(' FCFA')
                    ->color('success')
                    ->badge()
                    ->label('Prix avec réduction'),
                TextColumn::make('price_without_discount')
                    ->sortable()
                    ->suffix(' FCFA')
                    ->color('danger')
                    ->badge()
                    ->label('Prix original'),
                TextColumn::make('stock')
                    ->sortable()
                    ->icon('heroicon-s-archive-box')
                    ->color('info')
                    ->label('Quantité en stock'),
                ToggleColumn::make('is_active')
                    ->label('Visible')
                    ->afterStateUpdated(function (Product $record, $state) {
                        $record->update(['is_active' => $state]);
                    }),
                ToggleColumn::make('is_featured')
                    ->label('Mis en avant')
                    ->afterStateUpdated(function (Product $record, $state) {
                        $record->update(['is_featured' => $state]);
                    }),
                IconColumn::make('is_promoted')
                    ->label('En Promotion'),
                TextColumn::make('promotion_start')
                    ->dateTime()
                    ->sortable()
                    ->when(fn ($state) => $state == true)
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Date de debut de la promotion'),
                TextColumn::make('promotion_end')
                    ->dateTime()
                    ->sortable()
                    ->when(fn ($state) => $state == true)
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Date de fin de la promotion'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Créé le'),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Modifié le'),


            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->filters([
                SelectFilter::make('sub_category_id')
                    ->label('Sous-catégorie')
                    ->native(false)
                    ->relationship('subCategory', 'name')
                    ->placeholder('Toutes les sous-catégories'),

                TernaryFilter::make('is_active')
                    ->label('Actif')
                    ->native(false)
                    ->nullable(),

                TernaryFilter::make('is_featured')
                    ->label('Mis en avant')
                    ->native(false)
                    ->nullable(),

                Filter::make('En stock')
                    ->query(fn (Builder $query) => $query->where('is_in_stock', true)),

                Filter::make('En promotion')
                    ->query(fn (Builder $query) => $query->where('is_promoted', true)),

                Filter::make('Prix réduit')
                    ->query(fn (Builder $query) => $query->whereColumn('price_with_discount', '<', 'price_without_discount')),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}

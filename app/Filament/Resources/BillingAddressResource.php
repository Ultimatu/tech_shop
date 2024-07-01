<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BillingAddressResource\Pages;
use App\Filament\Resources\BillingAddressResource\RelationManagers;
use App\Models\BillingAddress;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BillingAddressResource extends Resource
{
    protected static ?string $model = BillingAddress::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $activeNavigationIcon = 'heroicon-s-credit-card';

    protected static ?string $navigationGroup = 'Commandes';

    protected static ?string $navigationLabel = 'Addresse de paiement de commande';

    protected static ?string $pluralModelLabel = "Addresse de paiement de commandes";

    public static function canCreate():bool
    {
        return false;
    }

    public static function canDelete($record):bool 
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('first_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('last_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('address')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('city')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('country')
                    ->required()
                    ->maxLength(255)
                    ->default('CIV'),
                Forms\Components\TextInput::make('phone_number')
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('is_default')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\Layout\Grid::make('Client')
                    ->schema([
                        Tables\Columns\TextColumn::make('user.first_name')
                            ->label('Nom du client')
                            ->color('secondary')
                            ->icon('heroicon-s-user-circle')
                            ->url(fn ($record) => route('filament.admin.resources.users.show', $record->user_id))
                            ->sortable(),
                        Tables\Columns\TextColumn::make('user.last_name')
                            ->label('Prénom du client')
                            ->color('secondary')
                            ->icon('heroicon-s-user-circle')
                            ->url(fn ($record) => route('filament.admin.resources.users.show', $record->user_id))
                            ->sortable(),
                    ])->collapsible(),
                Tables\Columns\Layout\Grid::make('Commande associée')
                    ->schema([
                        Tables\Columns\TextColumn::make('order.order_number')
                            ->badge()
                            ->color('danger')
                            ->url(fn ($record) => ($record->order?->id ? route('filament.admin.resources.orders.show', $record->order?->id) : null ))
                            ->sortable(),
                    ])->collapsible(),
                Tables\Columns\Layout\Grid::make('Addresse de paiement')
                    ->schema([
                        Tables\Columns\TextColumn::make('first_name')
                            ->searchable(),
                        Tables\Columns\TextColumn::make('last_name')
                            ->searchable(),
                        Tables\Columns\TextColumn::make('email')
                            ->searchable(),
                        Tables\Columns\TextColumn::make('address')
                            ->searchable(),
                        Tables\Columns\TextColumn::make('city')
                            ->searchable(),
                        Tables\Columns\TextColumn::make('country')
                            ->searchable(),
                        Tables\Columns\TextColumn::make('phone_number')
                            ->searchable(),
                        Tables\Columns\IconColumn::make('is_default')
                            ->boolean(),
                        Tables\Columns\TextColumn::make('created_at')
                            ->dateTime()
                            ->sortable()
                            ->toggleable(isToggledHiddenByDefault: true),
                        Tables\Columns\TextColumn::make('updated_at')
                            ->dateTime()
                            ->sortable()
                            ->toggleable(isToggledHiddenByDefault: true),
                    ]),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'index' => Pages\ListBillingAddresses::route('/'),
            'create' => Pages\CreateBillingAddress::route('/create'),
            'edit' => Pages\EditBillingAddress::route('/{record}/edit'),
        ];
    }
}

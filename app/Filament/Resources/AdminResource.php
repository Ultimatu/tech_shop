<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdminResource\Pages;
use App\Filament\Resources\AdminResource\RelationManagers;
use App\Models\Admin;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AdminResource extends Resource
{
    protected static ?string $model = Admin::class;

    protected static ?int $navigationSort = 38;


    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $activeNavigationIcon = 'heroicon-s-user-group';

    protected static ?string $navigationGroup = 'Admins';

    protected static ?string $navigationLabel = 'Admin';

    public static function canDelete($record): bool
    {
        return auth("admin")->id() !== $record->id;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nom complet')
                    ->hint('Veuillez saisir le nom complet de l\'administrateur')
                    ->hintIcon('heroicon-s-information-circle')
                    ->prefixIcon('heroicon-s-user')
                    ->prefixIconColor('info')
                    ->required()
                    ->maxLength(50),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->label('Adresse email')
                    ->hint('Veuillez saisir l\'adresse email de l\'administrateur')
                    ->hintIcon('heroicon-s-information-circle')
                    ->prefixIcon('heroicon-s-envelope')
                    ->prefixIconColor('warning')
                    ->required()
                    ->maxLength(50),
                Forms\Components\TextInput::make('phone_number')
                    ->required()
                    ->label('Numéro de téléphone')
                    ->hint('Veuillez saisir le numéro de téléphone de l\'administrateur')
                    ->hintIcon('heroicon-s-information-circle')
                    ->prefixIcon('heroicon-s-phone')
                    ->prefixIconColor('warning')
                    ->maxLength(20),
                Forms\Components\TextInput::make('address')
                    ->required()
                    ->label('Adresse')
                    ->hint('Veuillez saisir l\'adresse de l\'administrateur')
                    ->hintIcon('heroicon-s-information-circle')
                    ->prefixIcon('heroicon-s-map-pin')
                    ->prefixIconColor('primary')
                    ->maxLength(255),
                Forms\Components\TextInput::make('city')
                    ->required()
                    ->label('Ville')
                    ->hint('Veuillez saisir la ville de l\'administrateur')
                    ->hintIcon('heroicon-s-information-circle')
                    ->prefixIcon('heroicon-s-map-pin')
                    ->prefixIconColor('primary')
                    ->maxLength(50),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->visible(fn($record)=> !$record->id)
                    ->label('Mot de passe')
                    ->hint('Veuillez saisir le mot de passe de l\'administrateur')
                    ->hintIcon('heroicon-s-information-circle')
                    ->prefixIcon('heroicon-s-lock-closed')
                    ->revealable()
                    ->prefixIconColor('danger')
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('profile_picture')
                    ->image()
                    ->avatar()
                    ->nullable(),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading('Aucun élément trouvé')
            ->emptyStateDescription('Il n\'y a aucun éléments enregistré.')
            ->emptyStateIcon('heroicon-s-question-mark-circle')
            ->columns([
                Tables\Columns\ImageColumn::make('profile_picture')
                    ->label('Photo de profil')
                    ->circular()
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nom complet')
                    ->badge()
                    ->icon('heroicon-s-user')
                    ->iconColor('info')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Adresse email')
                    ->icon('heroicon-s-envelope')
                    ->iconColor('warning')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone_number')
                    ->label('Numéro de téléphone')
                    ->icon('heroicon-s-phone')
                    ->iconColor('warning')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->label('Adresse')
                    ->icon('heroicon-s-map-pin')
                    ->iconColor('primary')
                    ->searchable(),
                Tables\Columns\TextColumn::make('city')
                    ->label('Ville')
                    ->icon('heroicon-s-map-pin')
                    ->iconColor('primary')
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
            'index' => Pages\ListAdmins::route('/'),
            'create' => Pages\CreateAdmin::route('/create'),
            'edit' => Pages\EditAdmin::route('/{record}/edit'),
        ];
    }
}

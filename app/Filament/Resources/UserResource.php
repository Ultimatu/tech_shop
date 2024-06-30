<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?int $navigationSort = 34;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $activeNavigationIcon = 'heroicon-s-user-group';

    protected static ?string $navigationGroup = 'Utilisateurs';

    protected static ?string $navigationLabel = 'Utilisateur';


    protected static function booted()
    {
        static::query(function (Builder $query) {
            $query->withoutGlobalScope(SoftDeletingScope::class);
        });
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('first_name')
                    ->label('Nom')
                    ->hint('Veuillez saisir le nom de l\'utilisateur')
                    ->hintIcon('heroicon-s-information-circle')
                    ->prefixIcon('heroicon-s-user')
                    ->prefixIconColor('info')
                    ->required()
                    ->maxLength(50),
                Forms\Components\TextInput::make('last_name')
                    ->label('Prénom')
                    ->hint('Veuillez saisir le nom de l\'utilisateur')
                    ->hintIcon('heroicon-s-information-circle')
                    ->prefixIcon('heroicon-s-user')
                    ->prefixIconColor('info')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone_number')
                    ->label('Numéro de téléphone')
                    ->hint('Veuillez saisir le numéro de téléphone de l\'utilisateur')
                    ->hintIcon('heroicon-s-information-circle')
                    ->prefixIcon('heroicon-s-phone')
                    ->prefixIconColor('warning')
                    ->maxLength(20),
                Forms\Components\TextInput::make('email')
                    ->label('Adresse email')
                    ->hint('Veuillez saisir l\'adresse email de l\'utilisateur')
                    ->hintIcon('heroicon-s-information-circle')
                    ->prefixIcon('heroicon-s-envelope')
                    ->prefixIconColor('warning')
                    ->email()
                    ->required()
                    ->maxLength(50),
                Forms\Components\DateTimePicker::make('email_verified_at')->label('Email vérifié le')->nullable(),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->label('Mot de passe')
                    ->revealable()
                    ->hint('Veuillez saisir le mot de passe de l\'utilisateur')
                    ->hintIcon('heroicon-s-information-circle')
                    ->prefixIcon('heroicon-s-lock-closed')
                    ->prefixIconColor('danger')
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('profile_picture')
                    ->image()
                    ->label('Photo de profil')
                    ->hint('Veuillez choisir une photo de profil pour l\'utilisateur')
                    ->hintIcon('heroicon-s-information-circle')
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
                Tables\Columns\TextColumn::make('first_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('profile_picture')
                    ->circular(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}

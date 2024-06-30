<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WebSiteInfoResource\Pages;
use App\Filament\Resources\WebSiteInfoResource\RelationManagers;
use App\Models\WebSiteInfo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WebSiteInfoResource extends Resource
{
    protected static ?string $model = WebSiteInfo::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';
    protected static ?string $activeNavigationIcon = 'heroicon-s-building-library';

    protected static ?string $navigationGroup = 'Informations du site';

    protected static ?string $navigationLabel = 'Paramétrage principal';

    protected static ?string $label = 'un paramétrage principal';

    protected static ?string $pluralModelLabel = 'paramétrages principaux';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('web_site_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('web_site_description')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone_number_1')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone_number_2')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email_1')
                    ->email()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email_2')
                    ->email()
                    ->maxLength(255),
                Forms\Components\TextInput::make('working_hours')
                    ->required()
                    ->maxLength(255)
                    ->default('24h/24 7j/7'),
                Forms\Components\TextInput::make('address')
                    ->maxLength(255),
                Forms\Components\TextInput::make('city')
                    ->maxLength(255),
                Forms\Components\TextInput::make('facebook')
                    ->maxLength(255),
                Forms\Components\TextInput::make('whatsapp')
                    ->maxLength(255),
                Forms\Components\TextInput::make('instagram')
                    ->maxLength(255),
                Forms\Components\TextInput::make('shoppify')
                    ->maxLength(255),
                Forms\Components\FileUpload::make('image_logo')
                    ->image(),
                Forms\Components\FileUpload::make('image_favicon')
                    ->image(),
                Forms\Components\Toggle::make('is_active')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading('Aucun élément trouvé')
            ->emptyStateDescription('Il n\'y a aucun éléments enregistré.')
            ->emptyStateIcon('heroicon-s-question-mark-circle')
            ->columns([
                Tables\Columns\TextColumn::make('web_site_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('web_site_description')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone_number_1')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone_number_2')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email_1')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email_2')
                    ->searchable(),
                Tables\Columns\TextColumn::make('working_hours')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('city')
                    ->searchable(),
                Tables\Columns\TextColumn::make('facebook')
                    ->searchable(),
                Tables\Columns\TextColumn::make('whatsapp')
                    ->searchable(),
                Tables\Columns\TextColumn::make('instagram')
                    ->searchable(),
                Tables\Columns\TextColumn::make('shoppify')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image_logo'),
                Tables\Columns\ImageColumn::make('image_favicon'),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
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
            'index' => Pages\ListWebSiteInfos::route('/'),
            'create' => Pages\CreateWebSiteInfo::route('/create'),
            'edit' => Pages\EditWebSiteInfo::route('/{record}/edit'),
        ];
    }
}

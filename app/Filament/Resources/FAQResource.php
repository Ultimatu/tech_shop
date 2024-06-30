<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FAQResource\Pages;
use App\Filament\Resources\FAQResource\RelationManagers;
use App\Models\FAQ;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FAQResource extends Resource
{
    protected static ?string $model = FAQ::class;
    protected static ?int $navigationSort = 35;

    protected static ?string $navigationIcon = 'heroicon-o-information-circle';
    protected static ?string $activeNavigationIcon = 'heroicon-s-information-circle';

    protected static ?string $navigationGroup = 'Informations du site';

    protected static ?string $navigationLabel = 'Question Fréquente';

    protected static ?string $label = 'une Question Fréquente';

    protected static ?string $pluralModelLabel = 'Question Fréquentes';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('question')
                    ->required()
                    ->label('Question')
                    ->prefixIcon('heroicon-s-question-mark-circle')
                    ->prefixIconColor('danger')
                    ->hint('Entrez la question fréquente')
                    ->hintIcon('heroicon-s-information-circle')
                    ->maxLength(500),
                Forms\Components\RichEditor::make('answer')
                    ->label('Réponse')
                    ->required()
                    ->hint('Entrez la réponse à la question fréquente')
                    ->hintIcon('heroicon-s-information-circle')
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_active')->label("Afficher sur le site"),
                Forms\Components\Select::make('priority')
                    ->label("Prioroté (Ordre de classement sur le site)")
                    ->native(false)
                    ->options([
                        10 => "Très important",
                        8 => "Important",
                        5 => "Standard",
                        0 => "Moins important"
                    ])
                    ->placeholder('Sélectionnez une priorité')
                    ->prefixIcon('heroicon-s-adjustments-horizontal')
                    ->prefixIconColor("warning")
                    ->required(),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading('Aucun élément trouvé')
            ->emptyStateDescription('Il n\'y a aucun éléments enregistré.')
            ->emptyStateIcon('heroicon-s-question-mark-circle')
            ->columns([
                Tables\Columns\TextColumn::make('question')
                    ->icon('heroicon-s-question-mark-circle')
                    ->color('danger')
                    ->searchable(),
                Tables\Columns\TextColumn::make('answer')
                    ->icon('heroicon-s-chat-bubble-bottom-center-text')
                    ->color('success')
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Activer')
                    ->afterStateUpdated(fn ($record, $state) => (
                        $record->update(['is_active' => $state])
                    )),
                Tables\Columns\TextColumn::make('priority')
                    ->label("Prioroté (Ordre de classement sur le site)")
                    ->icon('heroicon-s-adjustments-horizontal')
                    ->color("warning")
                    ->sortable(),
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
            'index' => Pages\ListFAQS::route('/'),
            'create' => Pages\CreateFAQ::route('/create'),
            'edit' => Pages\EditFAQ::route('/{record}/edit'),
        ];
    }
}

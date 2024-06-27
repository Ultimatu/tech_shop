<?php

namespace App\Filament\Pages;

use Exception;
use Filament\Facades\Filament;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Pages\Concerns;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\Password;
use Illuminate\Contracts\Auth\Authenticatable;

class EditProfile extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $activeNavigationIcon = 'heroicon-s-user';

    protected static ?int $navigationSort = 20;


    protected static ?string $title = 'Profil';
    protected static ?string $modelLabel = 'Profil';
    protected static ?string $navigationLabel = 'Profil';

    protected static ?string $navigationGroup = 'Paramètres';


    protected static string $view = 'filament.pages.edit-profile';


    public ?array $profileData = [];
    public ?array $passwordData = [];

    public function mount(): void
    {
        $this->fillForms();
    }

    protected function getForms(): array
    {

        return [
            'editProfileForm',
            'editPasswordForm',
        ];
    }


    protected function getUpdateProfileFormActions(): array
    {
        return [
            Action::make('updateProfileAction')
                ->label(__('filament-panels::pages/auth/edit-profile.form.actions.save.label'))
                ->submit('editProfileForm'),
        ];
    }
    protected function getUpdatePasswordFormActions(): array
    {
        return [
            Action::make('updatePasswordAction')
                ->label(__('filament-panels::pages/auth/edit-profile.form.actions.save.label'))
                ->submit('editPasswordForm'),
        ];
    }

    public function editProfileForm(Form $form): Form
    {
        return
            $form
            ->schema([
                Forms\Components\Section::make('Informations personnelles')
                    ->description('Mettre à jour vos informations personnelles.')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nom Complet')
                            ->hintIcon('heroicon-s-user')
                            ->hintColor('warning')
                            ->hintIconTooltip('Votre nom')
                            ->rules('regex:/^[a-zA-Z]+$/')
                            ->required(),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->label('Email')
                            ->hintIcon('heroicon-s-envelope-open')
                            ->hintColor('warning')
                            ->hintIconTooltip('Votre email')
                            ->required()
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('phone_number')
                            ->required()
                            ->hintIcon('heroicon-s-phone')
                            ->hintColor('warning')
                            ->hintIconTooltip('Votre numéro de téléphone')
                            ->rules('regex:/^[0-9]+$/')
                            ->unique(ignoreRecord: true)
                            ->maxLength(20),
                        Forms\Components\TextInput::make('address')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('city')
                            ->required()
                            ->maxLength(50),
                        Forms\Components\FileUpload::make('profile_picture')
                            ->label('Image')
                            ->hintIcon('heroicon-s-globe-alt')
                            ->hintColor('warning')
                            ->hintIconTooltip('Votre image')
                    ]),
            ])
            ->model($this->getUser())
            ->statePath('profileData');
    }
    public function editPasswordForm(Form $form): Form
    {
        return
            $form
            ->schema([
                Forms\Components\Section::make('Modifier le mot de passe')
                    ->description('Mettre à jour votre mot de passe.')
                    ->schema([
                        Forms\Components\TextInput::make('Mot de passe actuel')
                            ->password()
                            ->required()
                            ->currentPassword(),
                        Forms\Components\TextInput::make('password')
                            ->label('Nouveau mot de passe')
                            ->password()
                            ->required()
                            ->rule(Password::default())
                            ->autocomplete('new-password')
                            ->live(debounce: 500)
                            ->same('passwordConfirmation'),
                        Forms\Components\TextInput::make('passwordConfirmation')
                            ->password()
                            ->label('Confirmer le mot de passe')
                            ->required()
                            ->dehydrated(false),
                    ]),
            ])
            ->model($this->getUser())
            ->statePath('passwordData');
    }


    public function updateProfile($isConfirmed = false)
    {
        $data = $this->editProfileForm->getState();
        $this->handleRecordUpdate($this->getUser(), $data);
        $this->sendSuccessNotification();
    }

    public function updatePassword(): void
    {
        $data = $this->editPasswordForm->getState();
        $this->handleRecordUpdate($this->getUser(), $data);
        if (request()->hasSession() && array_key_exists('password', $data)) {
            request()->session()->put(['password_hash_' . Filament::getAuthGuard() => $data['password']]);
        }
        $this->editPasswordForm->fill();
        $this->sendSuccessNotification();
    }
    private function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update($data);
        return $record;
    }

    /**
     * Send a success notification.
     *
     * @return Authenticatable|Model
     */
    protected function getUser()
    {
        $user = Filament::auth()->user();
        if (!$user instanceof Model) {
            throw new Exception('The authenticated user object must be an Eloquent model to allow the profile page to update it.');
        }
        return $user;
    }


    protected function fillForms(): void
    {
        $data = $this->getUser()->attributesToArray();
        $this->editProfileForm->fill($data);
        $this->editPasswordForm->fill();
    }


    private function sendSuccessNotification(): void
    {
        Notification::make()
            ->success()
            ->title(__('Votre profil a été mis à jour avec succès.'))
            ->duration(5000)
            ->color('success')
            ->send();
    }


    private function sendErrorNotification(): void
    {
        Notification::make()
            ->danger()
            ->title('Une erreur est survenue lors de la modification de votre profil. Veuillez réessayer.')
            ->duration(5000)
            ->color('danger')
            ->send();
    }
}

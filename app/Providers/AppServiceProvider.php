<?php

namespace App\Providers;

use App\Models\WebSiteInfo;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            return (new \Illuminate\Notifications\Messages\MailMessage)
                ->greeting('Hey')
                ->subject('Verification de l\'adresse e-mail')
                ->line('Veuillez cliquer sur le bouton ci-dessous pour vérifier votre adresse e-mail.')
                ->action('Vérifier l\'adresse e-mail', $url)
                ->line('Si vous n\'avez pas créé de compte, aucune autre action n\'est requise.')
                ->salutation('Cordialement, ' . config('app.name'));
        });

        ResetPassword::toMailUsing(function ($notifiable, $url) {
            return (new \Illuminate\Notifications\Messages\MailMessage)
                ->greeting('Hey')
                ->subject('Réinitialisation de mot de passe')
                ->line('Vous recevez cet e-mail car nous avons reçu une demande de réinitialisation de mot de passe pour votre compte.')
                ->action('Réinitialiser le mot de passe', $url)
                ->line('Ce lien de réinitialisation de mot de passe expirera dans :count minutes.', ['count' => config('auth.passwords.' . config('auth.defaults.passwords') . '.expire')])
                ->line('Si vous n\'avez pas demandé de réinitialisation de mot de passe, aucune autre action n\'est requise.')
                ->salutation('Cordialement, ' . config('app.name'));
        });

        //sharing data with all views
        view()->composer('*', function ($view) {
            $webSiteInfo = WebSiteInfo::where('is_active', true)->first();
            $view->with('appName', config('app.name'));
            $view->with('webSiteInfo', $webSiteInfo);
        });
    }
}

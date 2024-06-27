<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class BestCustomer extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $activeNavigationIcon = 'heroicon-s-user';

    protected static ?string $navigationGroup = 'Utilisateurs';

    protected static ?string $navigationLabel = 'Meilleur client';

    protected static string $view = 'filament.pages.best-customer';
}

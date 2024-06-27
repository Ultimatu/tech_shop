<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class BestSeller extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $activeNavigationIcon = 'heroicon-s-currency-dollar';

    protected static ?string $navigationGroup = 'Produits';

    protected static ?string $navigationLabel = 'Les plus vendus';
    
    protected static string $view = 'filament.pages.best-seller';
}

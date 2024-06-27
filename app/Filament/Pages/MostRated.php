<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class MostRated extends Page
{

    protected static ?string $navigationIcon = 'heroicon-o-star';
    protected static ?string $activeNavigationIcon = 'heroicon-s-star';

    protected static ?string $navigationGroup = 'Produits';

    protected static ?string $navigationLabel = 'Les plus notés';

    protected static string $view = 'filament.pages.most-rated';
}

<?php

namespace App\Filament\Resources\WebSiteSponsorResource\Pages;

use App\Filament\Resources\WebSiteSponsorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWebSiteSponsors extends ListRecords
{
    protected static string $resource = WebSiteSponsorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

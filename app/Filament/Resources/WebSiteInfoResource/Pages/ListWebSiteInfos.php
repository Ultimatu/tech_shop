<?php

namespace App\Filament\Resources\WebSiteInfoResource\Pages;

use App\Filament\Resources\WebSiteInfoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWebSiteInfos extends ListRecords
{
    protected static string $resource = WebSiteInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

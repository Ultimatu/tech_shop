<?php

namespace App\Filament\Resources\WebCarouselResource\Pages;

use App\Filament\Resources\WebCarouselResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWebCarousels extends ListRecords
{
    protected static string $resource = WebCarouselResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

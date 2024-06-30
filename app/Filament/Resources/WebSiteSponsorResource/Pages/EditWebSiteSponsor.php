<?php

namespace App\Filament\Resources\WebSiteSponsorResource\Pages;

use App\Filament\Resources\WebSiteSponsorResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWebSiteSponsor extends EditRecord
{
    protected static string $resource = WebSiteSponsorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

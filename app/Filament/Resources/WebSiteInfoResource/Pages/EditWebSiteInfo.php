<?php

namespace App\Filament\Resources\WebSiteInfoResource\Pages;

use App\Filament\Resources\WebSiteInfoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWebSiteInfo extends EditRecord
{
    protected static string $resource = WebSiteInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

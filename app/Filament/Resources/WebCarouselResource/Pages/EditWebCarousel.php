<?php

namespace App\Filament\Resources\WebCarouselResource\Pages;

use App\Filament\Resources\WebCarouselResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWebCarousel extends EditRecord
{
    protected static string $resource = WebCarouselResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

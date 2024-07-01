<?php

namespace App\Filament\Resources\BillingAddressResource\Pages;

use App\Filament\Resources\BillingAddressResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBillingAddress extends EditRecord
{
    protected static string $resource = BillingAddressResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

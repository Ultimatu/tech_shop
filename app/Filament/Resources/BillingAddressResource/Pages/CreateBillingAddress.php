<?php

namespace App\Filament\Resources\BillingAddressResource\Pages;

use App\Filament\Resources\BillingAddressResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBillingAddress extends CreateRecord
{
    protected static string $resource = BillingAddressResource::class;
}

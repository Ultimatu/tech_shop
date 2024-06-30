<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Models\Product;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;
class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected  array $items  = [];

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Traiter l'upload des images et associer les ProductItems
        $productItemsData = $data['items'] ?? [];
        $this->items = $productItemsData;
        unset($data['items']);
        
        $data['slug'] = Str::slug($data['name']) . '-' . uniqid();
        return $data;
    }

    protected function afterCreate(){
        foreach ($this->items as $itemData) {
            $this->record->items()->create($itemData);
        }
    }
}

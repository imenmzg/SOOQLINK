<?php

namespace App\Filament\Resources\Supplier\SupplierDocumentResource\Pages;

use App\Filament\Resources\Supplier\SupplierDocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSupplierDocuments extends ListRecords
{
    protected static string $resource = SupplierDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

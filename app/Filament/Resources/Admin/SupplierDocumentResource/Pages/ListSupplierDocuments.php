<?php

namespace App\Filament\Resources\Admin\SupplierDocumentResource\Pages;

use App\Filament\Resources\Admin\SupplierDocumentResource;
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

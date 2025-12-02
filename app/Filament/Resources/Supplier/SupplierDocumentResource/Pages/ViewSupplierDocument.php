<?php

namespace App\Filament\Resources\Supplier\SupplierDocumentResource\Pages;

use App\Filament\Resources\Supplier\SupplierDocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSupplierDocument extends ViewRecord
{
    protected static string $resource = SupplierDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->visible(fn () => $this->record->status === 'pending' || $this->record->status === 'rejected'),
        ];
    }
}


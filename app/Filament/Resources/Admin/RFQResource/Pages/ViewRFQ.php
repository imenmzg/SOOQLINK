<?php

namespace App\Filament\Resources\Admin\RFQResource\Pages;

use App\Filament\Resources\Admin\RFQResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewRFQ extends ViewRecord
{
    protected static string $resource = RFQResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}


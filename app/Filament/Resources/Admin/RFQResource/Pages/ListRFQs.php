<?php

namespace App\Filament\Resources\Admin\RFQResource\Pages;

use App\Filament\Resources\Admin\RFQResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRFQs extends ListRecords
{
    protected static string $resource = RFQResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}


<?php

namespace App\Filament\Resources\Client\RFQResource\Pages;

use App\Filament\Resources\Client\RFQResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRFQs extends ListRecords
{
    protected static string $resource = RFQResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Create RFQ')
                ->icon('heroicon-o-plus-circle'),
        ];
    }
}


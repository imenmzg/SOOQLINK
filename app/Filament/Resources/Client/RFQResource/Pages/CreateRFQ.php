<?php

namespace App\Filament\Resources\Client\RFQResource\Pages;

use App\Filament\Resources\Client\RFQResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateRFQ extends CreateRecord
{
    protected static string $resource = RFQResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['client_id'] = auth()->id();
        
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('RFQ Created')
            ->body('Your RFQ has been sent to the supplier.');
    }
}


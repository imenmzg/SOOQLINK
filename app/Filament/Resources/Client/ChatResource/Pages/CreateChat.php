<?php

namespace App\Filament\Resources\Client\ChatResource\Pages;

use App\Filament\Resources\Client\ChatResource;
use App\Models\Chat;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateChat extends CreateRecord
{
    protected static string $resource = ChatResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['client_id'] = auth()->id();
        $data['last_message_at'] = now();
        
        // Check if chat already exists
        $existingChat = Chat::where('client_id', auth()->id())
            ->where('supplier_id', $data['supplier_id'])
            ->first();
        
        if ($existingChat) {
            Notification::make()
                ->warning()
                ->title('Chat Already Exists')
                ->body('You already have a chat with this supplier.')
                ->send();
            
            // Redirect to existing chat
            $this->redirect(static::getResource()::getUrl('view', ['record' => $existingChat->id]));
            $this->halt();
        }
        
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->record->id]);
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Chat Created')
            ->body('You can now start messaging the supplier.');
    }
}


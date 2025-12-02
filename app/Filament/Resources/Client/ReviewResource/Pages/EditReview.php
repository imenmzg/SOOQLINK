<?php

namespace App\Filament\Resources\Client\ReviewResource\Pages;

use App\Filament\Resources\Client\ReviewResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditReview extends EditRecord
{
    protected static string $resource = ReviewResource::class;

    public function mount(int | string $record): void
    {
        parent::mount($record);
        
        // Prevent editing approved reviews
        if ($this->record->is_approved) {
            Notification::make()
                ->warning()
                ->title('Cannot Edit Approved Review')
                ->body('This review has been approved and cannot be edited. Please contact support if you need to make changes.')
                ->send();
            
            $this->redirect($this->getResource()::getUrl('index'));
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->visible(fn () => !$this->record->is_approved),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Ensure client_id and supplier_id cannot be changed
        $data['client_id'] = $this->record->client_id;
        $data['supplier_id'] = $this->record->supplier_id;
        
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Review Updated')
            ->body('Your review has been updated and is pending approval.');
    }
}


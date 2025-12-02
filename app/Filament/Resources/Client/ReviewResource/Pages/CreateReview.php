<?php

namespace App\Filament\Resources\Client\ReviewResource\Pages;

use App\Filament\Resources\Client\ReviewResource;
use App\Models\Review;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Illuminate\Database\QueryException;

class CreateReview extends CreateRecord
{
    protected static string $resource = ReviewResource::class;

    protected function authorizeAccess(): void
    {
        // Allow all authenticated users who can access the client panel
        // Form validation will handle eligibility checks
        if (!auth()->check()) {
            abort(403, 'You must be logged in to create a review.');
        }
        
        // If they can access the client panel, allow them to create reviews
        // The form will validate if they have eligible RFQs
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['client_id'] = auth()->id();
        
        // Check if review already exists
        $existingReview = Review::where('client_id', auth()->id())
            ->where('supplier_id', $data['supplier_id'])
            ->first();
        
        if ($existingReview) {
            throw new \Exception('You have already submitted a review for this supplier.');
        }
        
        return $data;
    }

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        try {
            return parent::handleRecordCreation($data);
        } catch (QueryException $e) {
            // Handle unique constraint violation
            if ($e->getCode() === '23000' || str_contains($e->getMessage(), 'UNIQUE constraint')) {
                throw new \Exception('You have already submitted a review for this supplier. You can edit your existing review instead.');
            }
            throw $e;
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Review Submitted Successfully')
            ->body('Your review is pending admin approval. Once approved, it will be visible on the supplier\'s profile.');
    }
}


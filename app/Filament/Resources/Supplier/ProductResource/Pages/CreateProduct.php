<?php

namespace App\Filament\Resources\Supplier\ProductResource\Pages;

use App\Filament\Resources\Supplier\ProductResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $supplier = auth()->user()->supplier;
        
        if (!$supplier) {
            Notification::make()
                ->danger()
                ->title('Supplier profile not found')
                ->body('Please contact support.')
                ->send();
            
            $this->halt();
        }
        
        $data['supplier_id'] = $supplier->id;
        
        // Only allow publishing if supplier is verified
        if (isset($data['is_published']) && $data['is_published'] && $supplier->verification_status !== 'verified') {
            $data['is_published'] = false;
            Notification::make()
                ->warning()
                ->title('Product saved as draft')
                ->body('You must be verified by admin before you can publish products. Your product has been saved but will not be visible to clients until you are verified.')
                ->send();
        }
        
        return $data;
    }
    
    protected function afterCreate(): void
    {
        // Handle image uploads to Media Library
        // Filament's FileUpload should handle this automatically, but we ensure it's synced
        if (isset($this->data['images']) && is_array($this->data['images'])) {
            foreach ($this->data['images'] as $imagePath) {
                if ($imagePath && \Storage::disk('public')->exists($imagePath)) {
                    $this->record->addMediaFromDisk($imagePath, 'public')
                        ->toMediaCollection('images');
                }
            }
        }
    }
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    protected function getCreatedNotification(): ?Notification
    {
        $supplier = auth()->user()->supplier;
        $isPublished = $this->record->is_published ?? false;
        
        if ($isPublished && $supplier && $supplier->verification_status === 'verified') {
            return Notification::make()
                ->success()
                ->title('Product created and published')
                ->body('Your product is now visible to clients on the website.');
        }
        
        return Notification::make()
            ->success()
            ->title('Product created')
            ->body($supplier && $supplier->verification_status !== 'verified' 
                ? 'Product saved as draft. It will be visible after admin verification.' 
                : 'Product created successfully.');
    }
}


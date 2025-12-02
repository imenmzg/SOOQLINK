<?php

namespace App\Filament\Resources\Supplier\ProductResource\Pages;

use App\Filament\Resources\Supplier\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
    
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $supplier = auth()->user()->supplier;
        
        // Only allow publishing if supplier is verified
        if (isset($data['is_published']) && $data['is_published'] && $supplier && $supplier->verification_status !== 'verified') {
            $data['is_published'] = false;
            Notification::make()
                ->warning()
                ->title('Product saved as draft')
                ->body('You must be verified by admin before you can publish products.')
                ->send();
        }
        
        return $data;
    }
    
    protected function afterSave(): void
    {
        // Handle image uploads to Media Library
        // Filament's FileUpload should handle this automatically, but we ensure it's synced
        if (isset($this->data['images']) && is_array($this->data['images'])) {
            // Clear existing images if new ones are uploaded
            $existingImages = $this->record->getMedia('images');
            $newImagePaths = collect($this->data['images'])->filter()->toArray();
            
            // Remove images that are no longer in the form
            foreach ($existingImages as $existingImage) {
                $existingPath = $existingImage->getPath();
                $found = false;
                foreach ($newImagePaths as $newPath) {
                    if (\Storage::disk('public')->exists($newPath) && 
                        str_contains($existingPath, basename($newPath))) {
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    $existingImage->delete();
                }
            }
            
            // Add new images
            foreach ($newImagePaths as $imagePath) {
                if ($imagePath && \Storage::disk('public')->exists($imagePath)) {
                    // Check if image already exists
                    $exists = $this->record->getMedia('images')
                        ->contains(function ($media) use ($imagePath) {
                            return str_contains($media->getPath(), basename($imagePath));
                        });
                    
                    if (!$exists) {
                        $this->record->addMediaFromDisk($imagePath, 'public')
                            ->toMediaCollection('images');
                    }
                }
            }
        }
    }
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    protected function getSavedNotification(): ?Notification
    {
        $supplier = auth()->user()->supplier;
        $isPublished = $this->record->is_published ?? false;
        
        if ($isPublished && $supplier && $supplier->verification_status === 'verified') {
            return Notification::make()
                ->success()
                ->title('Product updated and published')
                ->body('Your product is now visible to clients on the website.');
        }
        
        return Notification::make()
            ->success()
            ->title('Product updated')
            ->body('Product saved successfully.');
    }
}


<?php

namespace App\Filament\Resources\Supplier\SupplierDocumentResource\Pages;

use App\Filament\Resources\Supplier\SupplierDocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditSupplierDocument extends EditRecord
{
    protected static string $resource = SupplierDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make()
                ->visible(fn () => $this->record->status === 'pending' || $this->record->status === 'rejected'),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Reset status to pending if document is updated
        if ($this->record->status === 'rejected') {
            $data['status'] = 'pending';
            $data['rejection_reason'] = null;
        }
        
        // Remove document_file from data as we'll handle it after save
        unset($data['document_file']);
        
        return $data;
    }

    protected function afterSave(): void
    {
        // Handle file upload to media library if new file is uploaded
        $fileData = $this->data['document_file'] ?? null;
        
        if ($fileData) {
            $filePath = null;
            
            // Extract file path from the data structure
            if (is_array($fileData)) {
                // Handle nested array structure from Livewire
                $flattened = $this->flattenArray($fileData);
                foreach ($flattened as $value) {
                    if (is_string($value) && 
                        !str_contains($value, 'livewire-file:') && 
                        (str_contains($value, 'supplier-documents/') || str_contains($value, '/'))) {
                        $filePath = $value;
                        break;
                    }
                }
            } elseif (is_string($fileData)) {
                $filePath = $fileData;
            }
            
            // If we have a file path, update media library
            if ($filePath) {
                // Ensure path is correct
                if (!str_starts_with($filePath, 'supplier-documents/')) {
                    $filePath = 'supplier-documents/' . basename($filePath);
                }
                
                // Check if file exists on public disk
                if (\Storage::disk('public')->exists($filePath)) {
                    // Clear old media
                    $this->record->clearMediaCollection('document');
                    
                    // Add new media
                    $this->record->addMediaFromDisk($filePath, 'public')
                        ->toMediaCollection('document');
                }
            }
        }
    }
    
    /**
     * Flatten nested array to find file paths
     */
    protected function flattenArray($array): array
    {
        $result = [];
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $result = array_merge($result, $this->flattenArray($value));
            } else {
                $result[] = $value;
            }
        }
        return $result;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('تم تحديث الوثيقة')
            ->body('تم تحديث الوثيقة بنجاح. سيتم مراجعتها من قبل الإدارة.');
    }
}

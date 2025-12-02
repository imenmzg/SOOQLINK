<?php

namespace App\Filament\Resources\Supplier\SupplierDocumentResource\Pages;

use App\Filament\Resources\Supplier\SupplierDocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateSupplierDocument extends CreateRecord
{
    protected static string $resource = SupplierDocumentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['supplier_id'] = auth()->user()->supplier->id;
        $data['status'] = 'pending';
        
        // Store the file path - Filament stores it and returns the path
        $this->documentFile = $data['document_file'] ?? null;
        
        // Remove document_file from data as we'll handle it after creation
        unset($data['document_file']);
        
        return $data;
    }

    protected function afterCreate(): void
    {
        // Handle file upload to media library
        if ($this->documentFile) {
            $filePath = null;
            
            // Extract file path from the data structure
            if (is_array($this->documentFile)) {
                // Handle nested array structure from Livewire
                $flattened = $this->flattenArray($this->documentFile);
                foreach ($flattened as $value) {
                    if (is_string($value) && 
                        !str_contains($value, 'livewire-file:') && 
                        (str_contains($value, 'supplier-documents/') || str_contains($value, '/'))) {
                        $filePath = $value;
                        break;
                    }
                }
            } elseif (is_string($this->documentFile)) {
                $filePath = $this->documentFile;
            }
            
            // If we have a file path, add it to media library
            if ($filePath) {
                // Ensure path is correct
                if (!str_starts_with($filePath, 'supplier-documents/')) {
                    $filePath = 'supplier-documents/' . basename($filePath);
                }
                
                // Check if file exists on public disk
                if (\Storage::disk('public')->exists($filePath)) {
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
    
    protected $documentFile = null;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('تم رفع الوثيقة')
            ->body('تم رفع الوثيقة بنجاح. سيتم مراجعتها من قبل الإدارة.');
    }
}

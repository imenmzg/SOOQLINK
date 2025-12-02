<?php

namespace App\Filament\Resources\Admin\SupplierDocumentResource\Pages;

use App\Filament\Resources\Admin\SupplierDocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditSupplierDocument extends EditRecord
{
    protected static string $resource = SupplierDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('view_document')
                ->label('View Document')
                ->icon('heroicon-m-eye')
                ->color('info')
                ->visible(fn () => $this->record->getFirstMedia('document') !== null)
                ->url(fn () => $this->record->getFirstMediaUrl('document'))
                ->openUrlInNewTab(),
            Actions\Action::make('download_document')
                ->label('Download')
                ->icon('heroicon-m-arrow-down-tray')
                ->color('primary')
                ->visible(fn () => $this->record->getFirstMedia('document') !== null)
                ->url(fn () => route('admin.supplier-documents.download', $this->record)),
            Actions\Action::make('approve')
                ->label('Approve')
                ->icon('heroicon-m-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->visible(fn () => $this->record->status === 'pending')
                ->action(function () {
                    $this->record->update([
                        'status' => 'approved',
                        'approved_at' => now(),
                        'approved_by' => auth()->id(),
                        'rejection_reason' => null,
                    ]);
                    
                    Notification::make()
                        ->success()
                        ->title('Document Approved')
                        ->body('The document has been approved successfully.')
                        ->send();
                    
                    $this->redirect($this->getResource()::getUrl('index'));
                }),
            Actions\Action::make('reject')
                ->label('Reject')
                ->icon('heroicon-m-x-circle')
                ->color('danger')
                ->form([
                    \Filament\Forms\Components\Textarea::make('rejection_reason')
                        ->label('Rejection Reason')
                        ->required()
                        ->rows(3),
                ])
                ->requiresConfirmation()
                ->visible(fn () => $this->record->status === 'pending')
                ->action(function (array $data) {
                    $this->record->update([
                        'status' => 'rejected',
                        'rejection_reason' => $data['rejection_reason'],
                        'approved_at' => null,
                        'approved_by' => null,
                    ]);
                    
                    Notification::make()
                        ->danger()
                        ->title('Document Rejected')
                        ->body('The document has been rejected.')
                        ->send();
                    
                    $this->redirect($this->getResource()::getUrl('index'));
                }),
            Actions\DeleteAction::make(),
        ];
    }
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

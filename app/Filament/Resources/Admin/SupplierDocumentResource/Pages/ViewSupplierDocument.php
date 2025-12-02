<?php

namespace App\Filament\Resources\Admin\SupplierDocumentResource\Pages;

use App\Filament\Resources\Admin\SupplierDocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Notifications\Notification;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class ViewSupplierDocument extends ViewRecord
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
                ->modalHeading('Approve Document')
                ->modalDescription('Are you sure you want to approve this document?')
                ->visible(fn () => $this->record->status === 'pending')
                ->action(function () {
                    $this->record->update([
                        'status' => 'approved',
                        'approved_at' => now(),
                        'approved_by' => auth()->id(),
                        'rejection_reason' => null,
                    ]);
                    
                    // Update supplier verification status if all documents are approved
                    $supplier = $this->record->supplier;
                    $allDocumentsApproved = $supplier->documents()
                        ->where('status', '!=', 'approved')
                        ->count() === 0;
                    
                    if ($allDocumentsApproved && $supplier->documents()->where('status', 'approved')->count() >= 3) {
                        $supplier->update([
                            'verification_status' => 'verified',
                            'verified_at' => now(),
                        ]);
                    }
                    
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
                        ->rows(3)
                        ->helperText('Please provide a reason for rejection'),
                ])
                ->requiresConfirmation()
                ->modalHeading('Reject Document')
                ->modalDescription('Please provide a reason for rejecting this document.')
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
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
    
    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Document Information')
                    ->schema([
                        Infolists\Components\TextEntry::make('supplier.company_name')
                            ->label('Supplier')
                            ->icon('heroicon-m-building-office'),
                        Infolists\Components\TextEntry::make('supplier.user.email')
                            ->label('Email')
                            ->icon('heroicon-m-envelope')
                            ->copyable(),
                        Infolists\Components\TextEntry::make('document_type')
                            ->label('Document Type')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'commercial_register' => 'info',
                                'tax_card' => 'warning',
                                'id_card' => 'success',
                                default => 'gray',
                            })
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'commercial_register' => 'Commercial Register',
                                'tax_card' => 'Tax Card',
                                'id_card' => 'ID Card',
                                default => $state,
                            }),
                        Infolists\Components\TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'pending' => 'warning',
                                'approved' => 'success',
                                'rejected' => 'danger',
                                default => 'gray',
                            })
                            ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Submitted At')
                            ->dateTime('d/m/Y H:i')
                            ->icon('heroicon-m-calendar'),
                    ])
                    ->columns(2),
                Infolists\Components\Section::make('Document File')
                    ->schema([
                        Infolists\Components\TextEntry::make('document_file')
                            ->label('Document')
                            ->formatStateUsing(function ($record) {
                                if ($media = $record->getFirstMedia('document')) {
                                    $url = $media->getUrl();
                                    $fileName = $media->file_name;
                                    $fileSize = $media->human_readable_size;
                                    return new \Illuminate\Support\HtmlString(
                                        '<div class="flex flex-col gap-2">
                                            <a href="' . $url . '" target="_blank" class="text-primary-600 hover:underline flex items-center gap-2">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                                View Document
                                            </a>
                                            <span class="text-sm text-gray-500">' . $fileName . ' (' . $fileSize . ')</span>
                                        </div>'
                                    );
                                }
                                return 'No document uploaded';
                            })
                            ->html()
                            ->visible(fn ($record) => $record->getFirstMedia('document') !== null),
                    ])
                    ->visible(fn ($record) => $record->getFirstMedia('document') !== null),
                Infolists\Components\Section::make('Rejection Information')
                    ->schema([
                        Infolists\Components\TextEntry::make('rejection_reason')
                            ->label('Rejection Reason')
                            ->columnSpanFull(),
                    ])
                    ->visible(fn ($record) => $record->status === 'rejected'),
                Infolists\Components\Section::make('Approval Information')
                    ->schema([
                        Infolists\Components\TextEntry::make('approved_at')
                            ->label('Approved At')
                            ->dateTime('d/m/Y H:i')
                            ->icon('heroicon-m-calendar'),
                        Infolists\Components\TextEntry::make('approver.name')
                            ->label('Approved By')
                            ->icon('heroicon-m-user'),
                    ])
                    ->visible(fn ($record) => $record->status === 'approved')
                    ->columns(2),
            ]);
    }
}

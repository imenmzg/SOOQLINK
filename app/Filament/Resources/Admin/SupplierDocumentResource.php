<?php

namespace App\Filament\Resources\Admin;

use App\Filament\Resources\Admin\SupplierDocumentResource\Pages;
use App\Filament\Resources\Admin\SupplierDocumentResource\RelationManagers;
use App\Models\SupplierDocument;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SupplierDocumentResource extends Resource
{
    protected static ?string $model = SupplierDocument::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-check';

    protected static ?string $navigationLabel = 'Verification Documents';

    protected static ?string $navigationGroup = 'Suppliers';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Document Information')
                    ->schema([
                        Forms\Components\Select::make('supplier_id')
                            ->relationship('supplier', 'company_name', fn (Builder $query) => $query->orderBy('company_name'))
                            ->required()
                            ->searchable()
                            ->preload()
                            ->label('Supplier')
                            ->disabled(fn ($record) => $record !== null),
                        Forms\Components\Select::make('document_type')
                            ->label('Document Type')
                            ->options([
                                'commercial_register' => 'Commercial Register',
                                'tax_card' => 'Tax Card',
                                'id_card' => 'ID Card (Legal Representative)',
                            ])
                            ->required()
                            ->native(false)
                            ->disabled(fn ($record) => $record !== null),
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'pending' => 'Pending',
                                'approved' => 'Approved',
                                'rejected' => 'Rejected',
                            ])
                            ->required()
                            ->native(false)
                            ->default('pending')
                            ->disabled(fn ($record) => $record && $record->status === 'approved'),
                        Forms\Components\Textarea::make('rejection_reason')
                            ->label('Rejection Reason')
                            ->rows(3)
                            ->visible(fn ($get) => $get('status') === 'rejected')
                            ->required(fn ($get) => $get('status') === 'rejected')
                            ->helperText('Required when status is Rejected'),
                    ])
                    ->columns(2),
                Forms\Components\Section::make('Document File')
                    ->schema([
                        Forms\Components\Placeholder::make('document_file')
                            ->label('Current Document')
                            ->content(function ($record) {
                                if ($record && $media = $record->getFirstMedia('document')) {
                                    return new \Illuminate\Support\HtmlString(
                                        '<div class="flex items-center gap-2">
                                            <a href="' . $media->getUrl() . '" target="_blank" class="text-primary-600 hover:underline flex items-center gap-2">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                                View Document
                                            </a>
                                            <span class="text-sm text-gray-500">(' . $media->human_readable_size . ')</span>
                                        </div>'
                                    );
                                }
                                return 'No document uploaded';
                            })
                            ->visible(fn ($record) => $record && $record->getFirstMedia('document')),
                    ])
                    ->visible(fn ($record) => $record && $record->getFirstMedia('document')),
                Forms\Components\Section::make('Approval Information')
                    ->schema([
                        Forms\Components\DateTimePicker::make('approved_at')
                            ->label('Approved At')
                            ->disabled()
                            ->visible(fn ($record) => $record && $record->status === 'approved'),
                        Forms\Components\Select::make('approved_by')
                            ->relationship('approver', 'name')
                            ->label('Approved By')
                            ->disabled()
                            ->visible(fn ($record) => $record && $record->status === 'approved'),
                    ])
                    ->visible(fn ($record) => $record && $record->status === 'approved')
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('supplier.company_name')
                    ->label('Supplier')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->icon('heroicon-m-building-office'),
                Tables\Columns\TextColumn::make('supplier.user.email')
                    ->label('Email')
                    ->searchable()
                    ->icon('heroicon-m-envelope')
                    ->copyable()
                    ->copyMessage('Email copied!'),
                Tables\Columns\TextColumn::make('document_type')
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
                    })
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('has_document')
                    ->label('Document')
                    ->boolean()
                    ->trueIcon('heroicon-m-check-circle')
                    ->falseIcon('heroicon-m-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->getStateUsing(fn ($record) => $record && $record->getFirstMedia('document') !== null),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('rejection_reason')
                    ->label('Rejection Reason')
                    ->limit(30)
                    ->wrap()
                    ->visible(fn ($record) => $record && $record->status === 'rejected'),
                Tables\Columns\TextColumn::make('approved_at')
                    ->label('Approved At')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->visible(fn ($record) => $record && $record->status === 'approved'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Submitted At')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ])
                    ->multiple(),
                Tables\Filters\SelectFilter::make('document_type')
                    ->label('Document Type')
                    ->options([
                        'commercial_register' => 'Commercial Register',
                        'tax_card' => 'Tax Card',
                        'id_card' => 'ID Card',
                    ])
                    ->multiple(),
                Tables\Filters\Filter::make('has_document')
                    ->label('Has Document')
                    ->query(fn (Builder $query): Builder => $query->whereHas('media', fn ($q) => $q->where('collection_name', 'document'))),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Action::make('view_document')
                    ->label('View Document')
                    ->icon('heroicon-m-document')
                    ->color('info')
                    ->visible(fn ($record) => $record && $record->getFirstMedia('document') !== null)
                    ->url(fn ($record) => $record->getFirstMediaUrl('document'))
                    ->openUrlInNewTab(),
                Action::make('download_document')
                    ->label('Download')
                    ->icon('heroicon-m-arrow-down-tray')
                    ->color('primary')
                    ->visible(fn ($record) => $record && $record->getFirstMedia('document') !== null)
                    ->url(fn ($record) => route('admin.supplier-documents.download', $record)),
                Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-m-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Approve Document')
                    ->modalDescription('Are you sure you want to approve this document?')
                    ->visible(fn ($record) => $record && $record->status === 'pending')
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'approved',
                            'approved_at' => now(),
                            'approved_by' => auth()->id(),
                            'rejection_reason' => null,
                        ]);
                        
                        // Update supplier verification status if all documents are approved
                        $supplier = $record->supplier;
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
                    }),
                Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-m-x-circle')
                    ->color('danger')
                    ->form([
                        Forms\Components\Textarea::make('rejection_reason')
                            ->label('Rejection Reason')
                            ->required()
                            ->rows(3)
                            ->helperText('Please provide a reason for rejection'),
                    ])
                    ->requiresConfirmation()
                    ->modalHeading('Reject Document')
                    ->modalDescription('Please provide a reason for rejecting this document.')
                    ->visible(fn ($record) => $record && $record->status === 'pending')
                    ->action(function ($record, array $data) {
                        $record->update([
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
                    }),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Action::make('bulk_approve')
                        ->label('Approve Selected')
                        ->icon('heroicon-m-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function ($records) {
                            $count = 0;
                            foreach ($records as $record) {
                                if ($record->status === 'pending') {
                                    $record->update([
                                        'status' => 'approved',
                                        'approved_at' => now(),
                                        'approved_by' => auth()->id(),
                                    ]);
                                    $count++;
                                }
                            }
                            
                            Notification::make()
                                ->success()
                                ->title("{$count} documents approved")
                                ->send();
                        }),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('30s');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSupplierDocuments::route('/'),
            'create' => Pages\CreateSupplierDocument::route('/create'),
            'view' => Pages\ViewSupplierDocument::route('/{record}'),
            'edit' => Pages\EditSupplierDocument::route('/{record}/edit'),
        ];
    }
}

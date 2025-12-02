<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Admin\SupplierDocumentResource;
use App\Models\SupplierDocument;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class PendingVerifications extends BaseWidget
{
    protected static ?int $sort = 2;
    
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                SupplierDocument::query()
                    ->where('status', 'pending')
                    ->with(['supplier.user'])
                    ->latest()
            )
            ->columns([
                Tables\Columns\TextColumn::make('supplier.company_name')
                    ->label('Company Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
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
                    }),
                Tables\Columns\TextColumn::make('supplier.user.email')
                    ->label('Email')
                    ->searchable()
                    ->icon('heroicon-m-envelope'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Submitted At')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->icon('heroicon-m-calendar'),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('View')
                    ->icon('heroicon-m-eye')
                    ->url(fn (SupplierDocument $record): string => SupplierDocumentResource::getUrl('edit', ['record' => $record]))
                    ->color('primary'),
            ])
            ->heading('Pending Verifications')
            ->description('Documents awaiting review and approval')
            ->emptyStateHeading('No pending requests')
            ->emptyStateDescription('All verification requests have been processed')
            ->emptyStateIcon('heroicon-m-check-circle');
    }
}


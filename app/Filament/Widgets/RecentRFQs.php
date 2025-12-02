<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Admin\RFQResource;
use App\Models\RFQ;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentRFQs extends BaseWidget
{
    protected static ?int $sort = 3;
    
    protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 1,
    ];

    public function table(Table $table): Table
    {
        return $table
            ->query(
                RFQ::query()
                    ->with(['client', 'supplier', 'product'])
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('subject')
                    ->label('Subject')
                    ->searchable()
                    ->limit(30)
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('client.name')
                    ->label('Client')
                    ->searchable()
                    ->icon('heroicon-m-user'),
                Tables\Columns\TextColumn::make('supplier.company_name')
                    ->label('Supplier')
                    ->searchable()
                    ->limit(20),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'sent' => 'warning',
                        'replied' => 'info',
                        'accepted' => 'success',
                        'closed' => 'gray',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'sent' => 'Sent',
                        'replied' => 'Replied',
                        'accepted' => 'Accepted',
                        'closed' => 'Closed',
                        'cancelled' => 'Cancelled',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->icon('heroicon-m-calendar'),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('View')
                    ->icon('heroicon-m-eye')
                    ->url(fn (RFQ $record): string => RFQResource::getUrl('view', ['record' => $record]))
                    ->color('primary'),
            ])
            ->heading('Recent RFQs')
            ->description('Latest 5 quotation requests')
            ->emptyStateHeading('No RFQs')
            ->emptyStateDescription('No quotation requests have been created yet')
            ->emptyStateIcon('heroicon-m-document-text');
    }
}


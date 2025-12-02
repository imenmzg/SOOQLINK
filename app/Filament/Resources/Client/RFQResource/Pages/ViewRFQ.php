<?php

namespace App\Filament\Resources\Client\RFQResource\Pages;

use App\Filament\Resources\Client\RFQResource;
use App\Models\Chat;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;

class ViewRFQ extends ViewRecord
{
    protected static string $resource = RFQResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('accept_reply')
                ->label('Accept Reply')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(fn () => $this->record->status === 'replied' && $this->record->replies()->exists())
                ->requiresConfirmation()
                ->modalHeading('Accept RFQ Reply')
                ->modalDescription('Are you sure you want to accept this supplier\'s reply?')
                ->action(function () {
                    $reply = $this->record->replies()->first();
                    if ($reply) {
                        $reply->update(['is_accepted' => true]);
                        $this->record->markAsAccepted();
                        
                        Notification::make()
                            ->success()
                            ->title('RFQ Accepted')
                            ->body('You have accepted the supplier\'s reply.')
                            ->send();
                    }
                }),
            Actions\Action::make('start_chat')
                ->label('Start Chat')
                ->icon('heroicon-o-chat-bubble-left-right')
                ->color('primary')
                ->action(function () {
                    // Check if chat already exists
                    $chat = Chat::where('client_id', auth()->id())
                        ->where('supplier_id', $this->record->supplier_id)
                        ->first();
                    
                    if (!$chat) {
                        // Create new chat
                        $chat = Chat::create([
                            'client_id' => auth()->id(),
                            'supplier_id' => $this->record->supplier_id,
                            'rfq_id' => $this->record->id,
                            'last_message_at' => now(),
                        ]);
                    }
                    
                    // Redirect to chat
                    return redirect()->to(\App\Filament\Resources\Client\ChatResource::getUrl('view', ['record' => $chat->id]));
                }),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('RFQ Information')
                    ->schema([
                        Infolists\Components\TextEntry::make('subject')
                            ->label('Subject'),
                        Infolists\Components\TextEntry::make('description')
                            ->label('Description')
                            ->columnSpanFull(),
                        Infolists\Components\TextEntry::make('quantity')
                            ->label('Quantity'),
                        Infolists\Components\TextEntry::make('supplier.company_name')
                            ->label('Supplier'),
                        Infolists\Components\TextEntry::make('status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'sent' => 'primary',
                                'replied' => 'warning',
                                'accepted' => 'success',
                                'closed' => 'gray',
                                'cancelled' => 'danger',
                                default => 'gray',
                            }),
                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Created At')
                            ->dateTime('d/m/Y H:i'),
                    ])
                    ->columns(2),
                Infolists\Components\Section::make('Supplier Replies')
                    ->schema([
                        Infolists\Components\RepeatableEntry::make('replies')
                            ->schema([
                                Infolists\Components\TextEntry::make('price')
                                    ->label('Price')
                                    ->money('DZD'),
                                Infolists\Components\TextEntry::make('delivery_date')
                                    ->label('Delivery Date')
                                    ->date('d/m/Y'),
                                Infolists\Components\TextEntry::make('message')
                                    ->label('Message')
                                    ->columnSpanFull(),
                                Infolists\Components\TextEntry::make('terms')
                                    ->label('Terms & Conditions')
                                    ->columnSpanFull()
                                    ->visible(fn ($record) => !empty($record->terms)),
                                Infolists\Components\TextEntry::make('is_accepted')
                                    ->label('Status')
                                    ->formatStateUsing(fn ($state) => $state ? 'Accepted' : 'Pending')
                                    ->badge()
                                    ->color(fn ($state) => $state ? 'success' : 'warning'),
                                Infolists\Components\TextEntry::make('created_at')
                                    ->label('Replied At')
                                    ->dateTime('d/m/Y H:i'),
                            ])
                            ->columns(2),
                    ])
                    ->visible(fn ($record) => $record->replies()->count() > 0),
            ]);
    }
}


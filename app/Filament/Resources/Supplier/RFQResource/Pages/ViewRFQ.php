<?php

namespace App\Filament\Resources\Supplier\RFQResource\Pages;

use App\Filament\Resources\Supplier\RFQResource;
use Filament\Actions;
use Filament\Forms;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use Filament\Notifications\Notification;

class ViewRFQ extends ViewRecord
{
    protected static string $resource = RFQResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('reply')
                ->label('Reply to RFQ')
                ->icon('heroicon-o-paper-airplane')
                ->color('success')
                ->visible(fn () => $this->record->status === 'sent')
                ->form([
                    Forms\Components\TextInput::make('price')
                        ->label('Price (DZD)')
                        ->required()
                        ->numeric()
                        ->minValue(0)
                        ->prefix('DZD'),
                    Forms\Components\DatePicker::make('delivery_date')
                        ->label('Delivery Date')
                        ->required()
                        ->minDate(now()),
                    Forms\Components\Textarea::make('message')
                        ->label('Message')
                        ->rows(4)
                        ->placeholder('Enter your reply message...')
                        ->required(),
                    Forms\Components\Textarea::make('terms')
                        ->label('Terms & Conditions')
                        ->rows(4)
                        ->placeholder('Enter terms and conditions...'),
                ])
                ->action(function (array $data) {
                    $this->record->replies()->create([
                        'supplier_id' => $this->record->supplier_id,
                        'price' => $data['price'],
                        'delivery_date' => $data['delivery_date'],
                        'message' => $data['message'],
                        'terms' => $data['terms'] ?? null,
                    ]);

                    $this->record->markAsReplied();

                    // Send notification
                    $this->record->client->notify(new \App\Notifications\RFQReplyNotification($this->record));

                    Notification::make()
                        ->title('RFQ replied successfully')
                        ->body('The client has been notified of your reply.')
                        ->success()
                        ->send();
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
                        Infolists\Components\TextEntry::make('product.name')
                            ->label('Product'),
                        Infolists\Components\TextEntry::make('client.name')
                            ->label('Client'),
                        Infolists\Components\TextEntry::make('client.email')
                            ->label('Client Email'),
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
                Infolists\Components\Section::make('Your Reply')
                    ->schema([
                        Infolists\Components\TextEntry::make('reply_price')
                            ->label('Price')
                            ->formatStateUsing(function () {
                                $reply = $this->record->replies()->first();
                                return $reply ? number_format($reply->price, 2) . ' DZD' : 'N/A';
                            }),
                        Infolists\Components\TextEntry::make('reply_delivery_date')
                            ->label('Delivery Date')
                            ->formatStateUsing(function () {
                                $reply = $this->record->replies()->first();
                                return $reply && $reply->delivery_date ? $reply->delivery_date->format('d/m/Y') : 'N/A';
                            }),
                        Infolists\Components\TextEntry::make('reply_message')
                            ->label('Message')
                            ->columnSpanFull()
                            ->formatStateUsing(function () {
                                $reply = $this->record->replies()->first();
                                return $reply ? $reply->message : 'N/A';
                            }),
                        Infolists\Components\TextEntry::make('reply_terms')
                            ->label('Terms & Conditions')
                            ->columnSpanFull()
                            ->formatStateUsing(function () {
                                $reply = $this->record->replies()->first();
                                return $reply ? $reply->terms : 'N/A';
                            })
                            ->visible(fn () => $this->record->replies()->exists() && $this->record->replies()->first()->terms),
                        Infolists\Components\TextEntry::make('replied_at')
                            ->label('Replied At')
                            ->dateTime('d/m/Y H:i')
                            ->visible(fn () => $this->record->replied_at),
                    ])
                    ->columns(2)
                    ->visible(fn () => $this->record->status !== 'sent' && $this->record->replies()->exists()),
            ]);
    }
}


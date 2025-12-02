<?php

namespace App\Filament\Resources\Supplier;

use App\Filament\Resources\Supplier\RFQResource\Pages;
use App\Models\RFQ;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;

class RFQResource extends Resource
{
    protected static ?string $model = RFQ::class;

    protected static ?string $slug = 'rfqs';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'RFQ Requests';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('RFQ Information')
                    ->schema([
                        Forms\Components\TextInput::make('subject')
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\Textarea::make('description')
                            ->disabled()
                            ->dehydrated(false)
                            ->rows(4),
                        Forms\Components\TextInput::make('quantity')
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\TextInput::make('client.name')
                            ->label('Client')
                            ->disabled()
                            ->dehydrated(false),
                    ]),
                Forms\Components\Section::make('Reply to RFQ')
                    ->schema([
                        Forms\Components\TextInput::make('reply_price')
                            ->label('Price (DZD)')
                            ->required()
                            ->numeric()
                            ->minValue(0),
                        Forms\Components\DatePicker::make('reply_delivery_date')
                            ->label('Delivery Date'),
                        Forms\Components\Textarea::make('reply_message')
                            ->label('Message')
                            ->rows(3),
                        Forms\Components\Textarea::make('reply_terms')
                            ->label('Terms & Conditions')
                            ->rows(3),
                    ])
                    ->visible(fn ($record) => $record && $record->status === 'sent'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('subject')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('client.name')
                    ->label('Client')
                    ->searchable(),
                Tables\Columns\TextColumn::make('product.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'primary' => 'sent',
                        'warning' => 'replied',
                        'success' => 'accepted',
                        'gray' => 'closed',
                        'danger' => 'cancelled',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'sent' => 'Sent',
                        'replied' => 'Replied',
                        'accepted' => 'Accepted',
                        'closed' => 'Closed',
                        'cancelled' => 'Cancelled',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('reply')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('success')
                    ->form([
                        Forms\Components\TextInput::make('price')
                            ->label('Price (DZD)')
                            ->required()
                            ->numeric()
                            ->minValue(0),
                        Forms\Components\DatePicker::make('delivery_date')
                            ->label('Delivery Date'),
                        Forms\Components\Textarea::make('message')
                            ->rows(3),
                        Forms\Components\Textarea::make('terms')
                            ->label('Terms & Conditions')
                            ->rows(3),
                    ])
                    ->visible(fn (RFQ $record) => $record->status === 'sent')
                    ->action(function (RFQ $record, array $data) {
                        $record->replies()->create([
                            'supplier_id' => $record->supplier_id,
                            'price' => $data['price'],
                            'delivery_date' => $data['delivery_date'] ?? null,
                            'message' => $data['message'] ?? null,
                            'terms' => $data['terms'] ?? null,
                        ]);

                        $record->markAsReplied();

                        // Send notification
                        $record->client->notify(new \App\Notifications\RFQReplyNotification($record));

                        Notification::make()
                            ->title('RFQ replied successfully')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\ViewAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('supplier_id', auth()->user()->supplier->id ?? 0);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRFQs::route('/'),
            'view' => Pages\ViewRFQ::route('/{record}'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->check() && auth()->user()->isSupplier();
    }
}


<?php

namespace App\Filament\Resources\Supplier;

use App\Filament\Resources\Supplier\ChatResource\Pages;
use App\Models\Chat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ChatResource extends Resource
{
    protected static ?string $model = Chat::class;

    protected static ?string $slug = 'messages';

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationLabel = 'Messages';

    protected static ?string $navigationGroup = 'Communication';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Chat Information')
                    ->schema([
                        Forms\Components\TextInput::make('client.name')
                            ->label('Client')
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\TextInput::make('rfq.id')
                            ->label('Related RFQ')
                            ->disabled()
                            ->dehydrated(false),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('client.name')
                    ->label('Client')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('rfq.id')
                    ->label('RFQ #')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('last_message.body')
                    ->label('Last Message')
                    ->limit(50)
                    ->wrap()
                    ->searchable(false),
                Tables\Columns\TextColumn::make('unread_count')
                    ->label('Unread')
                    ->counts('messages', fn (Builder $query) => $query->where('is_read', false)->where('sender_id', '!=', auth()->id()))
                    ->badge()
                    ->color('danger')
                    ->default(0),
                Tables\Columns\TextColumn::make('last_message_at')
                    ->label('Last Activity')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->since(),
            ])
            ->filters([
                Tables\Filters\Filter::make('unread')
                    ->label('Unread Messages')
                    ->query(fn (Builder $query) => $query->whereHas('messages', fn ($q) => $q->where('is_read', false)->where('sender_id', '!=', auth()->id()))),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->defaultSort('last_message_at', 'desc')
            ->emptyStateHeading('No messages yet')
            ->emptyStateDescription('You will see messages from clients here');
    }

    public static function getEloquentQuery(): Builder
    {
        $supplierId = auth()->user()->supplier->id ?? 0;
        return parent::getEloquentQuery()
            ->where('supplier_id', $supplierId)
            ->with(['client', 'rfq', 'messages' => fn ($q) => $q->latest()->limit(1)]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListChats::route('/'),
            'view' => Pages\ViewChat::route('/{record}'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->check() && auth()->user()->isSupplier();
    }
}

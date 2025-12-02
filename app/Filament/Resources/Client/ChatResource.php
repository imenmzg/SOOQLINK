<?php

namespace App\Filament\Resources\Client;

use App\Filament\Resources\Client\ChatResource\Pages;
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
                        Forms\Components\Select::make('supplier_id')
                            ->relationship('supplier', 'company_name', fn (Builder $query) => $query->verified()->active())
                            ->required()
                            ->searchable()
                            ->preload()
                            ->label('Supplier')
                            ->helperText('Select a supplier to start a conversation')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                // Check if chat already exists
                                if ($state) {
                                    $existingChat = \App\Models\Chat::where('client_id', auth()->id())
                                        ->where('supplier_id', $state)
                                        ->first();
                                    
                                    if ($existingChat) {
                                        \Filament\Notifications\Notification::make()
                                            ->warning()
                                            ->title('Chat Already Exists')
                                            ->body('You already have a chat with this supplier. You will be redirected to the existing chat.')
                                            ->send();
                                    }
                                }
                            }),
                        Forms\Components\Select::make('rfq_id')
                            ->relationship('rfq', 'subject', fn (Builder $query) => $query->where('client_id', auth()->id()))
                            ->searchable()
                            ->preload()
                            ->label('Related RFQ (Optional)')
                            ->helperText('Link this chat to an existing RFQ'),
                    ])
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
            ->emptyStateDescription('You will see messages from suppliers here');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('client_id', auth()->id())
            ->with(['supplier', 'rfq', 'messages' => fn ($q) => $q->latest()->limit(1)]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListChats::route('/'),
            'create' => Pages\CreateChat::route('/create'),
            'view' => Pages\ViewChat::route('/{record}'),
        ];
    }

    public static function canViewAny(): bool
    {
        // If user can access client panel, they can view messages
        return auth()->check();
    }
}

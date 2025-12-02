<?php

namespace App\Filament\Resources\Client;

use App\Filament\Resources\Client\RFQResource\Pages;
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

    protected static ?string $navigationLabel = 'My RFQs';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('RFQ Details')
                    ->schema([
                        Forms\Components\Select::make('supplier_id')
                            ->relationship('supplier', 'company_name', fn (Builder $query) => $query->verified()->active())
                            ->required()
                            ->searchable()
                            ->preload()
                            ->label('Supplier'),
                        Forms\Components\Select::make('product_id')
                            ->relationship('product', 'name', fn (Builder $query) => $query->published())
                            ->searchable()
                            ->preload()
                            ->label('Product (Optional)'),
                        Forms\Components\TextInput::make('subject')
                            ->required()
                            ->maxLength(255)
                            ->label('Subject'),
                        Forms\Components\Textarea::make('description')
                            ->required()
                            ->rows(4)
                            ->label('Description'),
                        Forms\Components\TextInput::make('quantity')
                            ->numeric()
                            ->default(1)
                            ->required()
                            ->minValue(1),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('subject')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('supplier.company_name')
                    ->searchable()
                    ->sortable(),
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
                Tables\Columns\TextColumn::make('replies_count')
                    ->counts('replies')
                    ->label('Replies'),
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
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('view_replies')
                    ->icon('heroicon-o-eye')
                    ->label('View Replies')
                    ->visible(fn (RFQ $record) => $record->replies()->count() > 0)
                    ->url(fn (RFQ $record) => static::getUrl('view', ['record' => $record])),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('client_id', auth()->id());
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRFQs::route('/'),
            'create' => Pages\CreateRFQ::route('/create'),
            'view' => Pages\ViewRFQ::route('/{record}'),
        ];
    }

    public static function canViewAny(): bool
    {
        // If user can access client panel, they can view RFQs
        return auth()->check();
    }

    public static function canCreate(): bool
    {
        // Clients can create RFQs
        return auth()->check();
    }
}


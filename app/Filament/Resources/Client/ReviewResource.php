<?php

namespace App\Filament\Resources\Client;

use App\Filament\Resources\Client\ReviewResource\Pages;
use App\Models\Review;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static ?string $slug = 'reviews';

    protected static ?string $navigationIcon = 'heroicon-o-star';

    protected static ?string $navigationLabel = 'My Reviews';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Review Details')
                    ->schema([
                        Forms\Components\Select::make('supplier_id')
                            ->relationship('supplier', 'company_name', function (Builder $query) {
                                // Only show suppliers where client has an RFQ and hasn't reviewed yet
                                return $query->whereHas('rfqs', function ($q) {
                                    $q->where('client_id', auth()->id())
                                      ->whereIn('status', ['replied', 'accepted']);
                                })
                                ->whereDoesntHave('reviews', function ($q) {
                                    $q->where('client_id', auth()->id());
                                });
                            })
                            ->required()
                            ->searchable()
                            ->preload()
                            ->label('Supplier')
                            ->helperText(function () {
                                $hasEligibleRFQs = \App\Models\RFQ::where('client_id', auth()->id())
                                    ->whereIn('status', ['replied', 'accepted'])
                                    ->exists();
                                
                                if (!$hasEligibleRFQs) {
                                    return '⚠️ You need to have an RFQ with status "replied" or "accepted" before you can create a review. Currently, you have no eligible RFQs.';
                                }
                                
                                return 'Only suppliers you have worked with (replied/accepted RFQs) are shown';
                            })
                            ->live()
                            ->afterStateUpdated(fn (callable $set) => $set('rfq_id', null)),
                        Forms\Components\Select::make('rfq_id')
                            ->relationship('rfq', 'subject', function (Builder $query, callable $get) {
                                $supplierId = $get('supplier_id');
                                if (!$supplierId) {
                                    return $query->whereRaw('1 = 0'); // Return empty query
                                }
                                return $query->where('client_id', auth()->id())
                                    ->where('supplier_id', $supplierId)
                                    ->whereIn('status', ['replied', 'accepted']);
                            })
                            ->searchable()
                            ->preload()
                            ->label('Related RFQ (Optional)')
                            ->helperText('Select the RFQ this review is related to')
                            ->disabled(fn ($record) => $record?->is_approved ?? false)
                            ->visible(fn (callable $get) => !empty($get('supplier_id'))),
                        Forms\Components\Select::make('rating')
                            ->options([
                                1 => '1 ⭐ - Poor',
                                2 => '2 ⭐⭐ - Fair',
                                3 => '3 ⭐⭐⭐ - Good',
                                4 => '4 ⭐⭐⭐⭐ - Very Good',
                                5 => '5 ⭐⭐⭐⭐⭐ - Excellent',
                            ])
                            ->required()
                            ->label('Rating')
                            ->helperText('Select a rating from 1 to 5 stars')
                            ->disabled(fn ($record) => $record?->is_approved ?? false)
                            ->native(false),
                        Forms\Components\Textarea::make('comment')
                            ->rows(4)
                            ->label('Comment')
                            ->helperText('Share your experience with this supplier (optional)')
                            ->disabled(fn ($record) => $record?->is_approved ?? false)
                            ->maxLength(1000),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('supplier.company_name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('rating')
                    ->badge()
                    ->color(fn ($state) => match (true) {
                        $state >= 4 => 'success',
                        $state >= 3 => 'warning',
                        default => 'danger',
                    }),
                Tables\Columns\TextColumn::make('comment')
                    ->limit(50)
                    ->wrap(),
                Tables\Columns\IconColumn::make('is_approved')
                    ->boolean()
                    ->label('Approved'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('is_approved')
                    ->label('Approved')
                    ->query(fn ($query) => $query->where('is_approved', true)),
                Tables\Filters\Filter::make('pending')
                    ->label('Pending Approval')
                    ->query(fn ($query) => $query->where('is_approved', false)),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->visible(fn (Review $record) => !$record->is_approved),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn (Review $record) => !$record->is_approved),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('client_id', auth()->id());
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReviews::route('/'),
            'create' => Pages\CreateReview::route('/create'),
            'view' => Pages\ViewReview::route('/{record}'),
            'edit' => Pages\EditReview::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        // If user can access client panel, they can view reviews
        return auth()->check();
    }

    public static function canCreate(): bool
    {
        // Always allow authenticated users to access the create page
        // The form will handle validation and show appropriate messages
        return auth()->check();
    }
}


<?php

namespace App\Filament\Resources\Supplier;

use App\Filament\Resources\Supplier\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $slug = 'products';

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?string $navigationLabel = 'My Products';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Product Information')
                    ->schema([
                        Forms\Components\Select::make('category_id')
                            ->relationship('category', 'name', fn (Builder $query) => $query->where('is_active', true))
                            ->required()
                            ->searchable()
                            ->preload(),
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description')
                            ->rows(3),
                        Forms\Components\Textarea::make('technical_details')
                            ->rows(3)
                            ->label('Technical Details'),
                        Forms\Components\TextInput::make('price')
                            ->required()
                            ->numeric()
                            ->prefix('DZD')
                            ->minValue(0),
                        Forms\Components\TextInput::make('quantity')
                            ->numeric()
                            ->default(0)
                            ->minValue(0),
                        Forms\Components\Select::make('wilaya')
                            ->label('الولاية')
                            ->options(array_combine(config('wilayas'), config('wilayas')))
                            ->searchable()
                            ->preload(),
                        Forms\Components\TextInput::make('location')
                            ->label('الموقع'),
                        Forms\Components\Toggle::make('is_published')
                            ->default(false)
                            ->label('Publish Product')
                            ->disabled(fn () => !auth()->user()->supplier || auth()->user()->supplier->verification_status !== 'verified')
                            ->helperText(function () {
                                $supplier = auth()->user()->supplier;
                                if (!$supplier) {
                                    return 'Please complete your supplier profile first.';
                                }
                                if ($supplier->verification_status !== 'verified') {
                                    return 'You must be verified by admin before you can publish products. Your verification status: ' . ucfirst($supplier->verification_status);
                                }
                                return 'Published products will be visible to clients on the public website.';
                            })
                            ->dehydrated(fn () => auth()->user()->supplier && auth()->user()->supplier->verification_status === 'verified'),
                    ]),
                Forms\Components\Section::make('Product Images')
                    ->schema([
                        Forms\Components\FileUpload::make('images')
                            ->image()
                            ->multiple()
                            ->minFiles(3)
                            ->maxFiles(6)
                            ->directory('products')
                            ->visibility('public')
                            ->required()
                            ->helperText('Upload 3-6 images of your product (JPG, PNG, or WebP)')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp']),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('images')
                    ->circular()
                    ->stacked()
                    ->limit(3),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('DZD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_published')
                    ->boolean()
                    ->label('Published'),
                Tables\Columns\TextColumn::make('views_count')
                    ->label('Views')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category_id')
                    ->relationship('category', 'name'),
                Tables\Filters\Filter::make('is_published')
                    ->query(fn ($query) => $query->where('is_published', true))
                    ->label('Published Only'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            ->where('supplier_id', auth()->user()->supplier->id ?? 0);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->check() && auth()->user()->isSupplier();
    }
}


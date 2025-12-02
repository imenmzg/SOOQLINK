<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Admin\ProductResource;
use App\Models\Product;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentProducts extends BaseWidget
{
    protected static ?int $sort = 4;
    
    protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 1,
    ];

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Product::query()
                    ->with(['supplier', 'category'])
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Product Name')
                    ->searchable()
                    ->limit(30)
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('supplier.company_name')
                    ->label('Supplier')
                    ->searchable()
                    ->limit(20),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->badge()
                    ->color('info'),
                Tables\Columns\IconColumn::make('is_published')
                    ->label('Published')
                    ->boolean()
                    ->trueIcon('heroicon-m-check-circle')
                    ->falseIcon('heroicon-m-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                Tables\Columns\TextColumn::make('price')
                    ->label('Price')
                    ->money('DZD')
                    ->sortable(),
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
                    ->url(fn (Product $record): string => ProductResource::getUrl('view', ['record' => $record]))
                    ->color('primary'),
            ])
            ->heading('Recent Products')
            ->description('Latest 5 added products')
            ->emptyStateHeading('No products')
            ->emptyStateDescription('No products have been added yet')
            ->emptyStateIcon('heroicon-m-cube');
    }
}


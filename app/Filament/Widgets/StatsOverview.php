<?php

namespace App\Filament\Widgets;

use App\Models\Supplier;
use App\Models\Product;
use App\Models\RFQ;
use App\Models\User;
use App\Models\SupplierDocument;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalSuppliers = Supplier::count();
        $pendingSuppliers = Supplier::pending()->count();
        $verifiedSuppliers = Supplier::verified()->count();
        $totalProducts = Product::count();
        $publishedProducts = Product::published()->count();
        $totalRFQs = RFQ::count();
        $pendingRFQs = RFQ::sent()->count();
        $totalClients = User::clients()->count();
        $pendingDocuments = SupplierDocument::pending()->count();

        return [
            Stat::make('Total Suppliers', Number::format($totalSuppliers))
                ->description('All registered suppliers')
                ->descriptionIcon('heroicon-m-building-office')
                ->color('primary')
                ->chart([7, 12, 15, 18, $totalSuppliers]),
            Stat::make('Verified Suppliers', Number::format($verifiedSuppliers))
                ->description('Approved and active suppliers')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success')
                ->chart([3, 5, 8, 10, $verifiedSuppliers]),
            Stat::make('Pending Verifications', Number::format($pendingDocuments))
                ->description('Awaiting approval')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning')
                ->chart([2, 3, 4, 5, $pendingDocuments]),
            Stat::make('Total Products', Number::format($totalProducts))
                ->description('All products')
                ->descriptionIcon('heroicon-m-cube')
                ->color('info')
                ->chart([10, 20, 30, 40, $totalProducts]),
            Stat::make('Published Products', Number::format($publishedProducts))
                ->description('Products visible to clients')
                ->descriptionIcon('heroicon-m-eye')
                ->color('success')
                ->chart([8, 15, 22, 28, $publishedProducts]),
            Stat::make('Total RFQs', Number::format($totalRFQs))
                ->description('All quotation requests')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary')
                ->chart([5, 10, 15, 20, $totalRFQs]),
            Stat::make('Pending RFQs', Number::format($pendingRFQs))
                ->description('Awaiting response')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning')
                ->chart([2, 4, 6, 8, $pendingRFQs]),
            Stat::make('Total Clients', Number::format($totalClients))
                ->description('Registered clients')
                ->descriptionIcon('heroicon-m-users')
                ->color('info')
                ->chart([3, 6, 9, 12, $totalClients]),
        ];
    }
}

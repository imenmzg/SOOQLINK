<?php

namespace App\Filament\Resources\Client\ReviewResource\Pages;

use App\Filament\Resources\Client\ReviewResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReviews extends ListRecords
{
    protected static string $resource = ReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Create Review')
                ->icon('heroicon-o-star')
                ->authorize(fn () => true), // Force authorization to always allow
        ];
    }

    protected function configureCreateAction(Actions\CreateAction | \Filament\Tables\Actions\CreateAction $action): void
    {
        parent::configureCreateAction($action);
        
        // Override authorization to always allow
        $action->authorize(fn () => true);
    }
}


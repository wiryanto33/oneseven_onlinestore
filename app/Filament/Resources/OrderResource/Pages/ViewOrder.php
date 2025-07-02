<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;
use App\Services\OrderStatusService;
use Filament\Tables\Actions\Action;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Action::make('download_invoice')
            //     ->label('Invoice')
            //     ->icon('heroicon-o-document-arrow-down')
            //     ->color('success')
            //     ->url(fn (Order $record) => url("invoice/{$record->id}/download"))
            //     ->openUrlInNewTab(),
            
            
            Actions\EditAction::make(),
        ];
    }
}
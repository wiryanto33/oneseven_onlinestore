<?php

namespace App\Filament\Resources\RewardExchangeResource\Pages;

use App\Filament\Resources\RewardExchangeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRewardExchanges extends ListRecords
{
    protected static string $resource = RewardExchangeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

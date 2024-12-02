<?php

namespace App\Filament\Resources\WairResource\Pages;

use App\Filament\Resources\WairResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWairs extends ListRecords
{
    protected static string $resource = WairResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}

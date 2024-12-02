<?php

namespace App\Filament\User\Resources\FlexibleWorkResource\Pages;

use App\Filament\User\Resources\FlexibleWorkResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFlexibleWorks extends ListRecords
{
    protected static string $resource = FlexibleWorkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}

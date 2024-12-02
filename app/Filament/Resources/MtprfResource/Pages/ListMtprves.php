<?php

namespace App\Filament\Resources\MtprfResource\Pages;

use App\Filament\Resources\MtprfResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMtprves extends ListRecords
{
    protected static string $resource = MtprfResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

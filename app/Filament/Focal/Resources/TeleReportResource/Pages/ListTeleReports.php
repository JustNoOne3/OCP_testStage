<?php

namespace App\Filament\Focal\Resources\TeleReportResource\Pages;

use App\Filament\Resources\TeleReportResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTeleReports extends ListRecords
{
    protected static string $resource = TeleReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}

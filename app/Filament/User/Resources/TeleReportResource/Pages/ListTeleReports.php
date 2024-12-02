<?php

namespace App\Filament\User\Resources\TeleReportResource\Pages;

use App\Filament\User\Resources\TeleReportResource;
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

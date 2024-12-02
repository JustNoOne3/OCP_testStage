<?php

namespace App\Filament\Resources\TavReportResource\Pages;

use App\Filament\Resources\TavReportResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTavReport extends ViewRecord
{
    protected static string $resource = TavReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}

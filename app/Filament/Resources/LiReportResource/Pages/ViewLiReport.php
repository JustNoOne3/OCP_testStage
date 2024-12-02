<?php

namespace App\Filament\Resources\LiReportResource\Pages;

use App\Filament\Resources\LiReportResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewLiReport extends ViewRecord
{
    protected static string $resource = LiReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}

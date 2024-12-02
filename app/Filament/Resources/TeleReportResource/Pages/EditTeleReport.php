<?php

namespace App\Filament\Resources\TeleReportResource\Pages;

use App\Filament\Resources\TeleReportResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTeleReport extends EditRecord
{
    protected static string $resource = TeleReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

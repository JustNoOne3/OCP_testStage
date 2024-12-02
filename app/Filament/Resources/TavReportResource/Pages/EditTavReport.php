<?php

namespace App\Filament\Resources\TavReportResource\Pages;

use App\Filament\Resources\TavReportResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTavReport extends EditRecord
{
    protected static string $resource = TavReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}

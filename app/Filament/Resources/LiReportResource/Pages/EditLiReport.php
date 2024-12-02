<?php

namespace App\Filament\Resources\LiReportResource\Pages;

use App\Filament\Resources\LiReportResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLiReport extends EditRecord
{
    protected static string $resource = LiReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}

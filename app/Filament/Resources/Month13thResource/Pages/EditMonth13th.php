<?php

namespace App\Filament\Resources\Month13thResource\Pages;

use App\Filament\Resources\Month13thResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMonth13th extends EditRecord
{
    protected static string $resource = Month13thResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

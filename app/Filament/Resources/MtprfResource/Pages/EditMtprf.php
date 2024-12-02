<?php

namespace App\Filament\Resources\MtprfResource\Pages;

use App\Filament\Resources\MtprfResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMtprf extends EditRecord
{
    protected static string $resource = MtprfResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

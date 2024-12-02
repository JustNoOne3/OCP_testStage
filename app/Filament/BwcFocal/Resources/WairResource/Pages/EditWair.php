<?php

namespace App\Filament\BwcFocal\Resources\WairResource\Pages;

use App\Filament\Resources\WairResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWair extends EditRecord
{
    protected static string $resource = WairResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

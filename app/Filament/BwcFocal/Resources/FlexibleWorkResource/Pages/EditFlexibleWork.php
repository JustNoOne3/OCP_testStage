<?php

namespace App\Filament\BwcFocal\Resources\FlexibleWorkResource\Pages;

use App\Filament\Resources\FlexibleWorkResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFlexibleWork extends EditRecord
{
    protected static string $resource = FlexibleWorkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

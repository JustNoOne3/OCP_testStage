<?php

namespace App\Filament\User\Resources\FlexibleWorkResource\Pages;

use App\Filament\User\Resources\FlexibleWorkResource;
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

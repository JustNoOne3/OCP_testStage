<?php

namespace App\Filament\Resources\TavSubmissionResource\Pages;

use App\Filament\Resources\TavSubmissionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTavSubmission extends EditRecord
{
    protected static string $resource = TavSubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

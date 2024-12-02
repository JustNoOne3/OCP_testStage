<?php

namespace App\Filament\Resources\LiSubmissionResource\Pages;

use App\Filament\Resources\LiSubmissionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLiSubmission extends EditRecord
{
    protected static string $resource = LiSubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

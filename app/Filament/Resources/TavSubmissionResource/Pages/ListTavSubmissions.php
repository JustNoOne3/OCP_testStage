<?php

namespace App\Filament\Resources\TavSubmissionResource\Pages;

use App\Filament\Resources\TavSubmissionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTavSubmissions extends ListRecords
{
    protected static string $resource = TavSubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

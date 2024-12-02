<?php

namespace App\Filament\Resources\LiSubmissionResource\Pages;

use App\Filament\Resources\LiSubmissionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLiSubmissions extends ListRecords
{
    protected static string $resource = LiSubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Focal\Resources\EstablishmentResource\Pages;

use App\Filament\Resources\EstablishmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Support\Facades\Auth;

class ListEstablishments extends ListRecords
{
    protected static string $resource = EstablishmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make('All'),
            'approved' => Tab::make()->query(fn ($query) => $query->where('est_status', 'approved')),
            'denied' => Tab::make()->query(fn ($query) => $query->where('est_status', 'denied')),
            'unvalidated' => Tab::make()->query(fn ($query) => $query->where('est_status', 'unvalidated')),
        ];
    }
}

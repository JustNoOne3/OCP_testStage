<?php

namespace App\Filament\User\Resources\WairResource\Pages;

use App\Filament\User\Resources\WairResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWairs extends ListRecords
{
    protected static string $resource = WairResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('submit-report')
                ->label('Submit Report')
                ->color('secondary')
                ->action(function(){
                    return redirect('user/wairs/select');
                }),
        ];
    }
}

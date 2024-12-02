<?php

namespace App\Filament\User\Resources\Month13thResource\Pages;

use App\Filament\User\Resources\Month13thResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMonth13ths extends ListRecords
{
    protected static string $resource = Month13thResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('Submit')
                ->label('Submit Report')
                ->action(function(){
                    return redirect('user/month13ths/submit');
                }),
        ];
    }
}

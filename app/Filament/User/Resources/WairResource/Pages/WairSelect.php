<?php

namespace App\Filament\User\Resources\WairResource\Pages;

use App\Filament\User\Resources\WairResource;
use Filament\Resources\Pages\Page;

class WairSelect extends Page
{
    protected static string $resource = WairResource::class;

    protected static string $view = 'filament.user.resources.wair-resource.pages.wair-select';

    public function accident(){
        return redirect('user/accident-report');
    }

    public function illness(){
        return redirect('user/illness-report');
    }

    public function both(){
        return redirect('user/accident-illness-report');
        
    }

    public function noIncident(){
        return redirect('user/no-accident-illness-report');
    }
}

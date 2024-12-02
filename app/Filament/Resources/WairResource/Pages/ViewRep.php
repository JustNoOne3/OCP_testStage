<?php

namespace App\Filament\Resources\WairResource\Pages;

use App\Filament\Resources\WairResource;
use Filament\Resources\Pages\Page;

class ViewRep extends Page
{
    protected static string $resource = WairResource::class;

    protected static string $view = 'filament.resources.wair-resource.pages.view-rep';
}

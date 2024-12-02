<?php

namespace App\Filament\User\Resources\RequestResource\Pages;

use App\Filament\User\Resources\RequestResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRequest extends CreateRecord
{
    protected static string $resource = RequestResource::class;
}
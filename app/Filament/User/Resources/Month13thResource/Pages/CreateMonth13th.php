<?php

namespace App\Filament\User\Resources\Month13thResource\Pages;

use App\Filament\User\Resources\Month13thResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMonth13th extends CreateRecord
{
    protected static string $resource = Month13thResource::class;

    protected static bool $canCreateAnother = false;

    protected static bool $requireConfirmation = true;
}

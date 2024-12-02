<?php

namespace App\Filament\User\Resources\EmployeesResource\Pages;

use App\Filament\User\Resources\EmployeesResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEmployees extends CreateRecord
{
    protected static string $resource = EmployeesResource::class;
}

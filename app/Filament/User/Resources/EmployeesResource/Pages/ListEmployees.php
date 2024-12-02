<?php

namespace App\Filament\User\Resources\EmployeesResource\Pages;

use App\Filament\User\Resources\EmployeesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Imports\EmployeesImporter;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

use Filament\Actions\ImportAction;
// use Illuminate\Database\Eloquent\Collection;

class ListEmployees extends ListRecords
{
    protected static string $resource = EmployeesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // \EightyNine\ExcelImport\ExcelImportAction::make()
            //     ->color("warning")
            //     ->use(EmployeesImporter::class)
            //     // ->beforeImport(function (array $data, $livewire, $excelImportAction) {

            //     //     $uuid = Uuid::uuid4()->toString();
            //     //     $microseconds = substr(explode('.', microtime(true))[1], 0, 6); // Limit microseconds to 6 digits
            //     //     $uuid = 'emp-' . substr($uuid, 0, 12) . '-' . $microseconds;

            //     //     $defaultEst = Auth::user()->est_id;
            //     //     $defaultId = $uuid;

            //     //     $excelImportAction->additionalData([
            //     //         'emp_estabId' => $defaultEst,
            //     //         'id' => $defaultId
            //     //     ]);
            //     // })
            //     // ->afterImport(function ($data, $livewire, $excelImportAction) {
            //     //     dd($data);
            //     // })
            //     ,

            ImportAction::make()
                ->importer(EmployeesImporter::class)
                ->label('Import Employee Data')
                ->color('danger')
                ->icon('heroicon-o-arrow-up-on-square-stack'),
            Actions\CreateAction::make()
                ->label('Add Record')
                ->createAnother(false) ,
        ];
    }
}

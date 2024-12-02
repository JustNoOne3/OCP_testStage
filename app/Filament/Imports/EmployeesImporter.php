<?php

namespace App\Filament\Imports;

use App\Models\Employees;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class EmployeesImporter extends Importer
{
    protected static ?string $model = Employees::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('emp_lastName')
                ->label('Last Name')
                ->rules(['max:255'])
                ->guess(['Last Name'])
                ->exampleHeader('Last Name'),
            ImportColumn::make('emp_firstName')
                ->label('First Name')
                ->rules(['max:255'])
                ->guess(['First Name'])
                ->exampleHeader('First Name'),
            ImportColumn::make('emp_middleName')
                ->label('Middle Name')
                ->rules(['max:255'])
                ->guess(['Middle Name'])
                ->exampleHeader('Middle Name'),
            ImportColumn::make('emp_extensionName')
                ->label('Extension Name')
                ->rules(['max:255'])
                ->guess(['Extension Name'])
                ->exampleHeader('Extension Name'),
            ImportColumn::make('emp_birthday')
                ->label('Birthday')
                ->guess(['Birthday'])
                ->exampleHeader('Birthday'),
            ImportColumn::make('emp_sex')
                ->label('Sex')
                ->rules(['max:255'])
                ->guess(['Sex'])
                ->exampleHeader('Sex'),
            ImportColumn::make('emp_civilStatus')
                ->label('Civil Status')
                ->rules(['max:255'])
                ->guess(['Civil Status'])
                ->exampleHeader('Civil Status'),
            ImportColumn::make('emp_houseNum')
                ->label('House Number')
                ->rules(['max:255'])
                ->guess(['House Number'])
                ->exampleHeader('House Number'),
            ImportColumn::make('emp_street')
                ->label('Street')
                ->rules(['max:255'])
                ->guess(['Street'])
                ->exampleHeader('Street'),
            ImportColumn::make('emp_region')
                ->label('Region')
                ->rules(['max:255'])
                ->guess(['Region'])
                ->exampleHeader('Region'),
            ImportColumn::make('emp_province')
                ->label('Province')
                ->rules(['max:255'])
                ->guess(['Province'])
                ->exampleHeader('Province'),
            ImportColumn::make('emp_city')
                ->label('City')
                ->rules(['max:255'])
                ->guess(['City'])
                ->exampleHeader('City'),
            ImportColumn::make('emp_barangay')
                ->label('Barangay')
                ->rules(['max:255'])
                ->guess(['Barangay'])
                ->exampleHeader('Barangay'),
            ImportColumn::make('emp_wage')
                ->label('Wage')
                ->rules(['max:255'])
                ->guess(['Wage'])
                ->exampleHeader('Wage'),
            ImportColumn::make('emp_numDependents')
                ->label('Number of Dependents')
                ->rules(['max:255'])
                ->guess(['Number of Dependents'])
                ->exampleHeader('Number of Dependents'),
            ImportColumn::make('emp_serviceLength')
                ->label('Length of Service')
                ->rules(['max:255'])
                ->guess(['Length of Service'])
                ->exampleHeader('Length of Service'),
            ImportColumn::make('emp_occupation')
                ->label('Occupation')
                ->rules(['max:255'])
                ->guess(['Occupation'])
                ->exampleHeader('Occupation'),
            ImportColumn::make('emp_yearsExp')
                ->label('Years of Experience')
                ->rules(['max:255'])
                ->guess(['Years of Experience'])
                ->exampleHeader('Years of Experience'),
            ImportColumn::make('emp_employmentStatus')
                ->label('Employment Status')
                ->rules(['max:255'])
                ->guess(['Employment Status'])
                ->exampleHeader('Employment Status'),
            ImportColumn::make('emp_shiftStart')
                ->label('Start of Shift')
                ->rules(['max:255'])
                ->guess(['Start of Shift'])
                ->exampleHeader('Start of Shift'),
            ImportColumn::make('emp_shiftEnd')
                ->label('End of Shift')
                ->rules(['max:255'])
                ->guess(['End of Shift'])
                ->exampleHeader('End of Shift'),
            ImportColumn::make('emp_workHours')
                ->label('Working Hours')
                ->rules(['max:255'])
                ->guess(['Working Hours'])
                ->exampleHeader('Working Hours'),
            ImportColumn::make('emp_workDays')
                ->label('Working Days')
                ->rules(['max:255'])
                ->guess(['Working Days'])
                ->exampleHeader('Working Days'),
        ];
    }

    public function resolveRecord(): ?Employees
    {
        // return Employees::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Employees();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your employees import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}

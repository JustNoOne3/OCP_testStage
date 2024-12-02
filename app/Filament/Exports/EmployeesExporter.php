<?php

namespace App\Filament\Exports;

use App\Models\Employees;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class EmployeesExporter extends Exporter
{
    protected static ?string $model = Employees::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('emp_lastName')
                ->label('Last Name'),
            ExportColumn::make('emp_firstName')
                ->label('First Name'),
            ExportColumn::make('emp_middleName')
                ->label('Middle Name'),
            ExportColumn::make('emp_extensionName')
                ->label('Name Extension'),
            ExportColumn::make('emp_birthday')
                ->label('Birthday'),
            ExportColumn::make('emp_sex')
                ->label('Sex'),
            ExportColumn::make('emp_civilStatus')
                ->label('Civil Status'),
            ExportColumn::make('emp_houseNum')
                ->label('House Number'),
            ExportColumn::make('emp_street')
                ->label('Street'),
            ExportColumn::make('emp_region')
                ->label('Sex'),
            ExportColumn::make('emp_province')
                ->label('Province'),
            ExportColumn::make('emp_city')
                ->label('City'),
            ExportColumn::make('emp_barangay')
                ->label('Barangay'),
            ExportColumn::make('emp_wage')
                ->label('Wage'),
            ExportColumn::make('emp_numDependents')
                ->label('Number of Independents'),
            ExportColumn::make('emp_serviceLength')
                ->label('Length Service'),
            ExportColumn::make('emp_occupation')
                ->label('Occupation'),
            ExportColumn::make('emp_yearsExp')
                ->label('Years of Experience'),
            ExportColumn::make('emp_employmentStatus')
                ->label('Employment Status'),
            ExportColumn::make('emp_shiftStart')
                ->label('Start of Shift'),
            ExportColumn::make('emp_shiftEnd')
                ->label('End of Shift'),
            ExportColumn::make('emp_workHours')
                ->label('Working hours per Day'),
            ExportColumn::make('emp_workDays')
                ->label('Working Days per Week'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your Employees Data export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export. Please try again in a moment';
        }

        return $body;
    }
}

<?php

namespace App\Filament\Exports;

use App\Models\FlexibleWork;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class FlexibleWorkExporter extends Exporter
{
    protected static ?string $model = FlexibleWork::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('fwa_startDate')
                ->label('Start Date'),
            ExportColumn::make('fwa_endDate')
                ->label('End Date'),
            ExportColumn::make('fwa_type')
                ->label('Type of FWA'),
            ExportColumn::make('fwa_typeSpecify')
                ->label('Specify'),
            ExportColumn::make('fwa_reason')
                ->label('Reason'),
            ExportColumn::make('fwa_reasonSpecify')
                ->label('Specify'),
            ExportColumn::make('fwa_affectedWorkers')
                ->label('Affected Workers'),
            ExportColumn::make('fwa_owner')
                ->label('Owner'),
            ExportColumn::make('fwa_designation')
                ->label('Designation'),
            ExportColumn::make('fwa_contact')
                ->label('Contact Number'),
            ExportColumn::make('created_at')
                ->label('Date Submitted'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your FWA\FWS Data export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export. Please try again in a moment.';
        }

        return $body;
    }
}

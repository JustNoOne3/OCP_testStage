<?php

namespace App\Filament\Exports;

use App\Models\TeleReport;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class TeleReportExporter extends Exporter
{
    protected static ?string $model = TeleReport::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('tele_reportType'),
            ExportColumn::make('tele_reportId'),
            ExportColumn::make('tele_estabId'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your tele report export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
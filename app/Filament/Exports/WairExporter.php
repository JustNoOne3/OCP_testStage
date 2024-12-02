<?php

namespace App\Filament\Exports;

use App\Models\Wair;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class WairExporter extends Exporter
{
    protected static ?string $model = Wair::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('wairs_reportType'),
            ExportColumn::make('wairs_reportId'),
            ExportColumn::make('wairs_estabId'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your wair export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}

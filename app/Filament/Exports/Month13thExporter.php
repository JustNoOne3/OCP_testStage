<?php

namespace App\Filament\Exports;

use App\Models\Month13th;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class Month13thExporter extends Exporter
{
    protected static ?string $model = Month13th::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('month13th_yearCovered')
                ->label('Year Covered'),
            ExportColumn::make('month13th_numWorkers')
                ->label('Number of Workers Affected'),
            ExportColumn::make('month13th_amount')
                ->label('Total Amount'),
            ExportColumn::make('month13th_ownRep')
                ->label('Owner/Representative'),
            ExportColumn::make('month13th_designation')
                ->label('Designation'),
            ExportColumn::make('month13th_contact')
                ->label('Contact Number'),
            ExportColumn::make('month13th_lessFive')
                ->label('< Php 5,000.00'),
            ExportColumn::make('month13th_fiveTen')
                ->label('Php 5,001.00 - Php 10,000.00'),
            ExportColumn::make('month13th_tenTwenty')
                ->label('Php 10,001.00 - Php 20,000.00'),
            ExportColumn::make('month13th_twentyThirty')
                ->label(' Php 20,001.00 - Php 30,000.00 '),
            ExportColumn::make('month13th_thirtyForty')
                ->label(' Php 30,001.00 - Php 40,000.00 '),
            ExportColumn::make('month13th_fortyFifty')
                ->label('Php 40,001.00 - Php 50,000.00'),
            ExportColumn::make('month13th_fiftySixty')
                ->label('Php 50,001.00 - Php 60,000.00'),
            ExportColumn::make('month13th_sixtySeventy')
                ->label(' Php 60,001.00 - Php 70,000.00 '),
            ExportColumn::make('month13th_seventyEighty')
                ->label(' Php 70,001.00 - Php 80,000.00 '),
            ExportColumn::make('month13th_eightyNinety')
                ->label('Php 80,001.00 - Php 90,000.00'),
            ExportColumn::make('month13th_ninetyHundred')
                ->label('Php 90,001.00 - Php 100,000.00'),
            ExportColumn::make('month13th_moreHundred')
                ->label('> Php 100,001.00'),
            ExportColumn::make('created_at')
                ->label('Date Submitted'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}

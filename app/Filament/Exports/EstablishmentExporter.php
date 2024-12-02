<?php

namespace App\Filament\Exports;

use App\Models\Establishment;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class EstablishmentExporter extends Exporter
{
    protected static ?string $model = Establishment::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('est_name')
                ->label('Name of Estalishment'),
            ExportColumn::make('est_email')
                ->label('Email Address'),
            ExportColumn::make('est_street')
                ->label('Street'),
            ExportColumn::make('region_id')
                ->label('Region'),
            ExportColumn::make('province_id')
                ->label('Province'),
            ExportColumn::make('city_id')
                ->label('City'),
            ExportColumn::make('barangay_id')
                ->label('Barangay'),
            ExportColumn::make('psic_section')
                ->label('Section'),
            ExportColumn::make('est_products')
                ->label('Products'),
            ExportColumn::make('est_class')
                ->label('Classification'),
            ExportColumn::make('est_tin')
                ->label('TIN'),
            ExportColumn::make('est_sss')
                ->label('SSS'),
            ExportColumn::make('est_payment')
                ->label('Mode of Payment'),
            ExportColumn::make('est_yearImplemented')
                ->label('Implementation Year'),
            ExportColumn::make('est_numworkMale')
                ->label('Male Workers'),
            ExportColumn::make('est_numworkFemale')
                ->label('Female Workers'),
            ExportColumn::make('est_numworkManager')
                ->label('Managers'),
            ExportColumn::make('est_numworkSupervisor')
                ->label('Supervisors'),
            ExportColumn::make('est_numworkRanks')
                ->label('Rank and File'),
            ExportColumn::make('est_numworkTotal')
                ->label('Total Workers'),
            ExportColumn::make('est_owner')
                ->label('Owner'),
            ExportColumn::make('est_designation')
                ->label('Designation'),
            ExportColumn::make('est_telNum')
                ->label('Telephone Number'),
            ExportColumn::make('est_contactNum')
                ->label('Contact Number'),
            // ExportColumn::make('est_status')
            // ->label('Status'),
            ExportColumn::make('created_at')
                ->label('Date Submitted'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your Registered Establishment Data export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export. Please try again in a moment.';
        }

        return $body;
    }
}

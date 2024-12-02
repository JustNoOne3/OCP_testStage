<?php

namespace App\Filament\Resources\Month13thResource\Pages;

use App\Filament\Resources\Month13thResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Columns\Column;

class ListMonth13ths extends ListRecords
{
    protected static string $resource = Month13thResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
            // ExportAction::make()->exports([
            //     ExcelExport::make()->withColumns([
            //         Column::make('month13th_yearCovered')
            //             ->heading(''),
            //         Column::make('month13th_numWorkers')
            //             ->heading(''),
            //         Column::make('month13th_amount')
            //             ->heading(''),
            //         Column::make('month13th_ownRep')
            //             ->heading(''),
            //         Column::make('month13th_designation')
            //             ->heading(''),
            //         Column::make('month13th_contact')
            //             ->heading(''),
            //         Column::make('month13th_lessFive')
            //             ->heading(''),
            //         Column::make('month13th_fiveTen')
            //             ->heading(''),
            //         Column::make('month13th_tenTwenty')
            //             ->heading(''),
            //         Column::make('month13th_twentyThirty')
            //             ->heading(''),
            //         Column::make('month13th_thirtyForty')
            //             ->heading(''),
            //         Column::make('month13th_fortyFifty')
            //             ->heading(''),
            //         Column::make('month13th_fiftySixty')
            //             ->heading(''),
            //         Column::make('month13th_sixtySeventy')
            //             ->heading(''),
            //         Column::make('month13th_seventyEighty')
            //             ->heading(''),
            //         Column::make('month13th_eightyNinety')
            //             ->heading(''),
            //         Column::make('month13th_ninetyHundred')
            //             ->heading(''),
            //         Column::make('month13th_moreHundred')
            //             ->heading(''),
            //     ])
            //     ->withFilename(date('Y-m-d') . '- 13th Month - export')
            //     ->withWriterType(\Maatwebsite\Excel\Excel::XLSX),
            // ])
        ];
    }
}

<?php

namespace App\Filament\Resources\LiReportResource\Pages;

use App\Filament\Resources\LiReportResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use App\Models\LiReport;

class ListLiReports extends ListRecords
{
    protected static string $resource = LiReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('upload_form')
                ->color('primary')
                ->label('Add a New Form')
                ->modalHeading('Add a New LI Form')
                ->form([
                    TextInput::make('li_reportName')
                        ->label('Name/Type of Form')
                        ->maxLength(255)
                        ->required(),
                    TextInput::make('li_category')
                        ->label('Form Category'),
                    FileUpload::make('li_reportUpload')
                        ->label('Upload the form.')
                        ->required(),
                ])
                ->action(function (array $data){
                    return LiReport::create([
                        'li_reportName' => $data['li_reportName'],
                        'li_category' => $data['li_category'],
                        'li_reportUpload' => $data['li_reportUpload'],
                    ]);
                }),
        ];
    }
}

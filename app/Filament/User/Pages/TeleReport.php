<?php

namespace App\Filament\User\Pages;

use Filament\Pages\Page;

class TeleReport extends Page
{
    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected ?string $heading = ' Select Telecommuting Report';

    protected static string $view = 'filament.user.pages.tele-report';

    public function teleReportHead(){
        return redirect()->route('head-form');
    }

    public function teleReportBranch(){
        return redirect()->route('branch-form');
    }
}

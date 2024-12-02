<?php

namespace App\Filament\User\Pages;

use Filament\Pages\Page;

class TeleReportBranchForm extends Page
{
    protected static bool $shouldRegisterNavigation = false;
    
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.user.pages.tele-report-branch-form';
    
}

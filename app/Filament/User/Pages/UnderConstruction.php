<?php

namespace App\Filament\User\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class UnderConstruction extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationLabel = 'Be right back';

    protected ?string $heading = 'Be right back';

    protected static string $view = 'filament.user.pages.under-construction';

    public function mount(){
        // dd(Auth::user());
    }
}

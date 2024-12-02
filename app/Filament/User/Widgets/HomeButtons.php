<?php

namespace App\Filament\User\Widgets;

use Filament\Widgets\Widget;
use App\Models\Establishment;
use Illuminate\Support\Facades\Auth;

class HomeButtons extends Widget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 4;
    
    protected static string $view = 'filament.user.widgets.home-buttons';
    // public function mount(){
    //     dd(Auth::user()->est_id);
    // }
    public function teleReport(){
        return redirect()->route('tele-report');
    }

    public function branchOnly(){
        return redirect('user/tele-reports/branch-report');
    }

    public function month13thReport(){
        return redirect('user/month13ths/create');
    }

    public function wair(){
        return redirect('user/wairs/create');
    }

    public function fwa(){
        return redirect('user/flexible-works/flexible-work-create');
    }

    public function underCons(){
        return redirect('user/underConstruction');
    }
}

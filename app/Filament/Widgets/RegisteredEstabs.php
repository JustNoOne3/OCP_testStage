<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Establishment;
use Illuminate\Support\Facades\Auth;

class RegisteredEstabs extends BaseWidget
{
    protected static ?int $sort = 1;
    protected function getStats(): array
    {
        $up = 'heroicon-m-arrow-trending-up';
        $down = 'heroicon-m-arrow-trending-down';

        

        if(Auth::user()->authority == '20'){
            $totalEstab = Establishment::query()->count();
            $today = Establishment::query()->whereDate('created_at', now())->count();
            $yesterday = Establishment::query()->whereDate('created_at', now()->subDay())->count();
        }else{
            $totalEstab = Establishment::query()->where('region_id', Auth::user()->authority)->count();
            $today = Establishment::query()->where('region_id', Auth::user()->authority)->whereDate('created_at', now())->count();
            $yesterday = Establishment::query()->where('region_id', Auth::user()->authority)->whereDate('created_at', now()->subDay())->count();
        }
        $yest_desc = "Yesterday we had " . $yesterday . " registrations";
        return [
            Stat::make('Total Registered Establishments', $totalEstab)
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Stat::make('Registered Today', $today)
                // ->description($yest_desc)
                // ->descriptionIcon($today > $yesterday ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($today > $yesterday ? 'success' : 'danger')
                ->chart([15, 5, 8, 3, 1, 14, 17]),
        ];
    }
}

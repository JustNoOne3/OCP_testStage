<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Establishment;
use App\Models\Wair;
use App\Models\FlexibleWork;
use App\Models\TeleReport;
use App\Models\Month13th;
use Illuminate\Support\Facades\Auth;

class ReportsSubmitted extends BaseWidget
{
    protected static ?int $sort = 2;
    protected static ?int $columns = 4;
    protected function getStats(): array
    {
        if(Auth::user()->authority == '20'){
            $tele = TeleReport::query()->count();
            $flexi = FlexibleWork::query()->count();
            $month13 = Month13th::query()->count();
            $wair = Wair::query()->count();
        }else{
            $countedEst = Establishment::query()->where('region_id', Auth::user()->authority)->pluck('est_id');
            $tele = TeleReport::query()->whereIn('tele_estabId', $countedEst)->count();
            $flexi = FlexibleWork::query()->whereIn('fwa_estabId', $countedEst)->count();
            $month13 = Month13th::query()->whereIn('month13th_estabId', $countedEst)->count();
            $wair = Wair::query()->whereIn('wairs_estabId', $countedEst)->count();
        }
        
        return [
            Stat::make('Telecommuting Reports', $tele)
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('warning'),
            Stat::make('FWA / AWS Reports', $flexi)
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('danger'),
            Stat::make('13th Month Reports', $month13)
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('warning'),
            Stat::make('Work Accidents / Illness Reports', $wair)
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('danger'),
        ];
    }
}

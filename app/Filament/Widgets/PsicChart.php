<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Establishment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PsicChart extends ChartWidget
{
    protected static ?string $heading = 'Establishments per Industry';

    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $countData = [];
        $nameData = [];
        $c = 0;
        if(Auth::user()->authority == '20'){
            $industryCounts = Establishment::select('psic_section', DB::raw('count(*) as total'))
                ->groupBy('psic_section')
                ->get();
        }else{
            $industryCounts = Establishment::where('region_id', Auth::user()->authority)->select('psic_section', DB::raw('count(*) as total'))
                ->groupBy('psic_section')
                ->get();
        }
        
        foreach($industryCounts as $industry){
            // $nameData[$c] = $industry->psic_section;
            $countData[$c] = $industry->total;
            switch ($industry->psic_section){
                case 'H':
                    $nameData[$c] = 'Transportation and Storage';
                    break;
                case 'A':
                    $nameData[$c] = 'Agriculture, Forestry, and Fishing';
                    break;
                case 'S':
                    $nameData[$c] = 'Other Services Actvities';
                    break;
                case 'R':
                    $nameData[$c] = 'Arts, Entertainment and Recreation';
                    break;
                case 'Q':
                    $nameData[$c] = 'Human Health and Social Work Activities';
                    break;
                case 'P':
                    $nameData[$c] = 'Education';
                    break;
                case 'N':
                    $nameData[$c] = 'Administrative and Support Service Activities';
                    break;
                case 'M':
                    $nameData[$c] = 'Professional, Scientific and Technical Activities';
                    break;
                case 'L':
                    $nameData[$c] = 'Real Estate Activities';
                    break;
                case 'K':
                    $nameData[$c] = 'Financial and Insurance Activities';
                    break;
                case 'J':
                    $nameData[$c] = 'Information and Communication';
                    break;
                case 'I':
                    $nameData[$c] = 'Accommodation and Food Service Activities';
                    break;
                case 'G':
                    $nameData[$c] = 'Wholesale and Retail Trade; Repair of MV';
                    break;
                case 'F':
                    $nameData[$c] = 'Construction';
                    break;
                case 'E':
                    $nameData[$c] = 'Water Supply; Sewerage, Waste Management and Remediation';
                    break;
                case 'D':
                    $nameData[$c] = 'Electricity, Gas, Steam and Air Conditioning Supply';
                    break;
                case 'C':
                    $nameData[$c] = 'Manufacturing';
                    break;
                case 'B':
                    $nameData[$c] = 'Mining and Quarrying';
                    break;
                default:
                    $nameData[$c] = 'Others';
            }
            $c = $c + 1;
        }
        return [
            'datasets' => [
                [
                    'label' => 'Industry Count',
                    'data' => $countData,
                ]   
            ],
            'labels' => $nameData,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}

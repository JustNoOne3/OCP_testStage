<?php

namespace App\Filament\BwcFocal\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Establishment;
use Illuminate\Support\Facades\DB;

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
        $industryCounts = Establishment::select('psic_section', DB::raw('count(*) as total'))
            ->groupBy('psic_section')
            ->get();
        foreach($industryCounts as $industry){
            // $nameData[$c] = $industry->psic_section;
            $countData[$c] = $industry->total;
            switch ($industry->psic_section){
                case 'H0000':
                    $nameData[$c] = 'Transportation and Storage';
                    break;
                case 'A0000':
                    $nameData[$c] = 'Agriculture, Forestry, and Fishing';
                    break;
                case 'S0000':
                    $nameData[$c] = 'Other Services Actvities';
                    break;
                case 'R0000':
                    $nameData[$c] = 'Arts, Entertainment and Recreation';
                    break;
                case 'Q0000':
                    $nameData[$c] = 'Human Health and Social Work Activities';
                    break;
                case 'P0000':
                    $nameData[$c] = 'Education';
                    break;
                case 'N0000':
                    $nameData[$c] = 'Administrative and Support Service Activities';
                    break;
                case 'M0000':
                    $nameData[$c] = 'Professional, Scientific and Technical Activities';
                    break;
                case 'L0000':
                    $nameData[$c] = 'Real Estate Activities';
                    break;
                case 'K0000':
                    $nameData[$c] = 'Financial and Insurance Activities';
                    break;
                case 'J0000':
                    $nameData[$c] = 'Information and Communication';
                    break;
                case 'I0000':
                    $nameData[$c] = 'Accommodation and Food Service Activities';
                    break;
                case 'G0000':
                    $nameData[$c] = 'Wholesale and Retail Trade; Repair og Motor Vehicles and Motorcycles';
                    break;
                case 'F0000':
                    $nameData[$c] = 'Construction';
                    break;
                case 'E0000':
                    $nameData[$c] = 'Water Supply; Sewerage, Waste Management and Remediation';
                    break;
                case 'D0000':
                    $nameData[$c] = 'Electricity, Gas, Steam and Air Conditioning Supply';
                    break;
                case 'C0000':
                    $nameData[$c] = 'Manufaturing';
                    break;
                case 'B0000':
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
